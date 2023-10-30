<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\ClientesModel;
use App\Libraries\Authentication;

date_default_timezone_set('America/Cancun');

class BasicAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('common');

        // Revisa si existen credenciales
        if( empty($_SERVER['PHP_AUTH_USER'])){
            gg_die('Servicio no autorizado, token no recibido');
        }

        // Asigna las credenciales a variables
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        // Obtiene el modelo de clientes
        $cm = new ClientesModel();
        $cliente = $cm->where('id_cliente', $username)->first();

        // Si no existe el cliente
        if( empty($cliente) ){
            gg_die('Servicio no autorizado, id_cliente no existe');
        }

        // Compara credenciales con id_cliente y llave_secreta
        if( empty($cliente) || $cliente['llave_secreta'] != $password ){
            gg_die('Servicio no autorizado, credenciales incorrectas');
        }

        // Obtiene el modelo de autenticacion
        $auth = new Authentication();

        // Obtiene los datos del cliente de la sesion
        $credentials = $auth->getCredentials();

        // Compara si las credenciales de la sesion son iguales a las credenciales recibidas
        if( $credentials['id_cliente'] != $username || $credentials['llave_secreta'] != $password ){
            gg_die('Servicio no autorizado, credenciales incorrectas, debes iniciar sesion en este equipo para poder usar el servicio');
        }

        // Compara la fecha actual con el valid_until de las $credentials
        if( strtotime($credentials['valid_until']) < strtotime(date('Y-m-d H:i:s')) ){
            gg_die('Servicio no autorizado, credenciales expiradas, debes iniciar sesion nuevamente para poder usar el servicio');
        }


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Code to be executed after the controller method
    }
}
