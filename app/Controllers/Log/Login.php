<?php

namespace App\Controllers\Log;

use App\Controllers\BaseController;

// Carga el helper common
helper(['common']);

class Login extends BaseController
{
    public function index()
    {
        //
    }

    public function login()
    {
        // Asigna los valores del formulario a variables
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Valida que el email y la contraseña no estén vacíos
        if (empty($email) || empty($password)) {
            gg_die('Email o contraseña vacíos');
        }

        $um = new \App\Models\Usuarios\UsuariosModel();

        // Valida que el email exista en la base de datos
        $user = $um->where('email', $email)->first();

        // Si el email existe, valida que la contraseña sea correcta
        if ( !$user ){
            gg_response(400, [ 'error' => true, 'msg' => 'Usuario o contraseña inválidos' ] );
        }

        // Valida que la contraseña sea correcta
        if ( password_verify($password, $user->password) ) {

            // Crea la variable para la sesion
            $session = session();

            //  Duracion de la sesion en segundos
            $sessionLength = 86400;
            $sessionStartedAt = time();

            // Si la contraseña es correcta, crea la sesión
            $session->set([
                'id' => $user->id,
                'nombre' => $user->nombre,
                'apellido' => $user->apellido,
                'email' => $user->email,
                'isLoggedIn' => true,
                'started_at' => $sessionStartedAt,
                'session_length' => $sessionLength, 
            ]);

            // Establece una vigencia para la sesion
            $session->markAsTempdata(['id', 'nombre', 'apellido', 'email', 'isLoggedIn'], $sessionLength);

            // Crea un token de sesion para usar como BasicAuth combinando id con email, encriptado con herramientas de CI
            $encrypter = \Config\Services::encrypter();
            $tokenData = [ 'id' => $user->id, 'email' => $user->email, 'started_at' => $sessionStartedAt ];
            $token = $encrypter->encrypt(json_encode($tokenData, true));

            // Crea un registro de log de login
            $lm = new \App\Models\Usuarios\LogsModel();
            $lm->log( $user->id, 'login' );

            // Devuelve el token
            gg_response(200, [ 'error' => false, 'msg' => 'Logueo correcto', 'token' => $token ]);

        } else {
            gg_response(400, [ 'error' => true, 'msg' => 'Usuario o contraseña inválidos' ] );
        }
        
    }

    public function logout(){

        $session = session();

        // Revisa si existe una sesion activa
        if ( !$session->isLoggedIn ){
            gg_die('No hay una sesión activa');
        }

        // Crea un registro de log de logout
        $lm = new \App\Models\Usuarios\LogsModel();
        $lm->log( $session->id, 'logout' );

        // Destruye la sesión
        $session->destroy();

        // Devuelve un mensaje de éxito
        gg_response(200, [ 'error' => false, 'msg' => 'Sesión cerrada' ] );

    }

    protected function sessionTimeLeft(){
        // Obtén el servicio de sesión
        $session = \Config\Services::session();

        // Nombre de la variable de sesión temporal que deseas verificar
        $nombreVariableTemporal = 'isLoggedIn';

        // Verifica si la variable de sesión temporal existe
        if ($session->has($nombreVariableTemporal)) {
            // Obtén la marca de tiempo en la que se creó la variable de sesión temporal
            $tiempoCreacion = $session->get('started_at');

            // Obtén la duración de vida de la sesión temporal en segundos
            $duracionVida = $session->get('session_length');

            // Calcula el tiempo restante en segundos
            $tiempoActual = time();
            $tiempoExpiracion = $tiempoCreacion + $duracionVida;
            return $tiempoExpiracion - $tiempoActual;
        } else {
            // Si la variable de sesión temporal no existe, devuelve 0
            return 0;
        }
    }

    public function show(){

        $session = session();

        // Revisa si existe una sesion activa
        if ( !$session->isLoggedIn ){
            gg_die('No hay una sesión activa');
        }

        // Asigna los datos de la sesion a un array
        $sessionData = [
            'id' => $session->id,
            'nombre' => $session->nombre,
            'apellido' => $session->apellido,
            'email' => $session->email,
            'started_at' => $session->started_at,
            'session_length' => $session->session_length,
            'isLoggedIn' => $session->isLoggedIn,
            'timeLeft' => $this->sessionTimeLeft(),
        ];

        // Devuelve los datos de la sesion
        gg_response(200, [ 'error' => false, 'msg' => 'Datos de la sesión', 'data' => $sessionData ]);
    }
}
