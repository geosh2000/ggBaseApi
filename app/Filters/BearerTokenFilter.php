<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

helper(['common']);

class BearerTokenFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtiene el token de la cabecera
        $token = $request->getServer('HTTP_AUTHORIZATION');

        // Valida que el token no esté vacío y que comience con la palabra "Bearer "
        if ( empty($token) || !str_starts_with($token, 'Bearer ') ) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido' ] );
        }

        // Obtiene el bearer token del encabezado, quitando la palabra "Bearer " del inicio
        $bearerToken = str_replace('Bearer ', '', $token);
        
        // Usa el encrypter de CI4 para decodificar el token. hace un try catch del decrypt. Si falla, devuelve un error
        try {
            $tokenData = \Config\Services::encrypter()->decrypt($bearerToken);
        } catch (\Exception $e) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido, no se pude descifrar' ] );
        }

        // Valida que el token decodificado sea un json_encoded en formato texto y lo convierte a objeto. Si no es un json, devuelve un error
        $tokenData = json_decode($tokenData, true);
        if ( !is_array($tokenData) ) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido, información perdida' ] );
        }

        

        // Valida que el token tenga los datos necesarios
        if ( !isset($tokenData['id']) || !isset($tokenData['email']) || !isset($tokenData['started_at'])) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido, datos inconsistentes' ] );
        }

        // Valida que existan los datos de id, email y started_at en la sesion
        $session = session();
        if ( !$session->id || !$session->email || !$session->started_at ) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido, inicia sesión nuevamente' ] );
        }

        // Valida que el token sea válido comparandolo con el id, el email y el started_at de la sesion
        if ( $tokenData['id'] != $session->id || $tokenData['email'] != $session->email || $tokenData['started_at'] != $session->started_at ) {
            gg_response(401, [ 'error' => true, 'msg' => 'Token inválido, inicia sesión nuevamente' ] );
        }

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
