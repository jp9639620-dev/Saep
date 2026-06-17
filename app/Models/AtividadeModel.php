<?php

namespace App\Models;

use CodeIgniter\Model;

class AtividadeModel extends Model
{
    protected $table            = 'atividade';
    protected $primaryKey       = 'id_atividade';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tipo_atividade', 
        'distancia_percorrida', 
        'duracao_atividade', 
        'quantidade_calorias', 
        'fk_usuario_id_usuario'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
}