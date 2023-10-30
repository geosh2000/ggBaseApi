<?php namespace App\Libraries;

class Authentication{
    
    // Guarda las variables de credenciales incluyendo id, username, id_cliente, llave_secreta y valid_until
    public function setCredentials( $client ){
        $session = \Config\Services::session();
        $session->set('id', $client['id']);
        $session->set('username', $client['email']);
        $session->set('id_cliente', $client['id_cliente']);
        $session->set('llave_secreta', $client['llave_secreta']);
        $session->set('valid_until', $client['valid_until']);
    }

    // Obtiene las variables de credenciales
    public function getCredentials(){
        $session = \Config\Services::session();
        $credentials = array(
            'id' => $session->get('id'),
            'username' => $session->get('username'),
            'id_cliente' => $session->get('id_cliente'),
            'llave_secreta' => $session->get('llave_secreta'),
            'valid_until' => $session->get('valid_until')
        );
        return $credentials;
    }

    // Elimina las variables de credenciales
    public function deleteCredentials(){
        $session = \Config\Services::session();
        $session->remove('id');
        $session->remove('username');
        $session->remove('id_cliente');
        $session->remove('llave_secreta');
        $session->remove('valid_until');
    }

}
