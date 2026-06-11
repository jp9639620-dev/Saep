<?php

namespace App\Models;

use CodeIgniter\Model;

class AtividadeModel extends Model
{
    protected $table = 'atividade';
    protected $primaryKey = 'id_atividade';

    protected $allowedFields = [
        'fk_usuario_id_usuario',
        'tipo_atividade',
        'distancia_percorrida',
        'duracao_atividade',
        'quantidade_calorias'
    ];
}
