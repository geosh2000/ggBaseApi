<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class TimezoneFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        date_default_timezone_set('America/Cancun');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Code to be executed after the controller method
    }
}
