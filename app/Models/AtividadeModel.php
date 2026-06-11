<?php

namespace App\Models;

use CodeIgniter\Model;

class AtividadeModel extends Model
{
    protected $table = 'atividade';

    protected $primaryKey = 'id_atividade';

    protected $allowedFields = [
        'tipo_atividade',
        'distancia_percorrida',
        'duracao_atividade',
        'quantidade_calorias',
        'fk_usuario_id_usuario'
    ];

    protected $useTimestamps = false;

    // Buscar atividades apenas do usuário informado
    public function buscarPorUsuario(int $id_usuario, int $limit = 0, int $offset = 0)
    {
        $builder = $this->where('fk_usuario_id_usuario', $id_usuario)->orderBy('createdAt', 'DESC');
        if ($limit > 0) {
            return $builder->findAll($limit, $offset);
        }
        return $builder->findAll();
    }

    // Criar nova atividade (garante fk_usuario_id_usuario)
    public function criar(array $dados)
    {
        // garantir que o campo fk_usuario_id_usuario esteja presente
        if (empty($dados['fk_usuario_id_usuario'])) {
            throw new \InvalidArgumentException('fk_usuario_id_usuario é obrigatório');
        }
        $dados['createdAt'] = date('Y-m-d H:i:s');
        $dados['updatedAt'] = date('Y-m-d H:i:s');
        return $this->insert($dados);
    }

    // Deletar atividade por id (retorna true/false)
    public function deletar(int $id_atividade)
    {
        return (bool) $this->delete($id_atividade);
    }
}