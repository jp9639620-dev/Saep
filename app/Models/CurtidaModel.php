<?php

namespace App\Models;

use CodeIgniter\Model;

class CurtidaModel extends Model
{
    // table is a pivot table named curtida_curtida
    protected $table = 'curtida_curtida';
    // pivot table has no single-column primary key; we'll rely on queries
    protected $primaryKey = '';
    protected $allowedFields = [
        'fk_usuario_id_usuario',
        'fk_atividade_id_atividade',
    ];
    protected $returnType = 'array';
    public $useTimestamps = false;

    // Adicionar curtida (se não existir)
    public function curtir(int $id_usuario, int $id_atividade)
    {
        $exists = $this->where('fk_usuario_id_usuario', $id_usuario)
            ->where('fk_atividade_id_atividade', $id_atividade)
            ->first();

        if ($exists) {
            return false;
        }

        return (bool) $this->insert([
            'fk_usuario_id_usuario' => $id_usuario,
            'fk_atividade_id_atividade' => $id_atividade,
        ]);
    }

    // Remover curtida
    public function descurtir(int $id_usuario, int $id_atividade)
    {
        return (bool) $this->where('fk_usuario_id_usuario', $id_usuario)
            ->where('fk_atividade_id_atividade', $id_atividade)
            ->delete();
    }

    // Contar curtidas de uma atividade
    public function contarCurtidas(int $id_atividade)
    {
        return $this->where('fk_atividade_id_atividade', $id_atividade)->countAllResults();
    }
}
