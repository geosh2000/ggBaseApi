<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Code to be executed before the controller method
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

        echo "holaaaaa desde el filtro 2";
        // Establece el codigo de response y muestra la data resultado de la funcion del controlador
        $response->setStatusCode(200);
        $response->setBody('Hola mundo desde el filtro');
        return $response;
    }
}
