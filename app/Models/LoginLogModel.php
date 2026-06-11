<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginLogModel extends Model
{
    protected $table = 'login_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fk_usuario_id_usuario',
        'ip',
        'user_agent',
        'createdAt',
    ];
    protected $returnType = 'array';
    public $useTimestamps = false;
}
