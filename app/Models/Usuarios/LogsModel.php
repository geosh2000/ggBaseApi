<?php

namespace App\Models\Usuarios;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario_id', 'ip', 'user_agent', 'fecha', 'accion'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    private function getIpAddress(){
        $ip = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        return $ip;
    }

    public function log( $user_id, $logType = 'login' ){
        $this->insert([
            'usuario_id' => $user_id,
            'ip' => $this->getIpAddress(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'fecha' => date('Y-m-d H:i:s'),
            'accion' => $logType,
        ]);
    }
}
