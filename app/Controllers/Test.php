<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// Carga el helper common
helper(['common']);

class Test extends BaseController
{
    public function index()
    {
        // Devuelve un mensaje de éxito
        gg_response(200, ['error' => false, 'msg' => 'Hola mundo']);
    }
}
