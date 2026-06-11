<?php

namespace App\Models;

use CodeIgniter\Model;

class ComentarioModel extends Model
{
    // actual table name is comentario_comentario
    protected $table = 'comentario_comentario';
    protected $primaryKey = 'id_comentario';
    protected $allowedFields = [
        'mensagem',
        'fk_usuario_id_usuario',
        'fk_atividade_id_atividade',
    ];
    protected $returnType = 'array';
    public $useTimestamps = false;

    // Buscar comentários por atividade
    public function buscarPorAtividade(int $id_atividade)
    {
        return $this->where('fk_atividade_id_atividade', $id_atividade)->orderBy('id_comentario', 'ASC')->findAll();
    }

    // Criar comentário
    public function criar(array $dados)
    {
        $dados['createdAt'] = date('Y-m-d H:i:s');
        return $this->insert($dados);
    }

    // Deletar comentário
    public function deletar(int $id_comentario)
    {
        return (bool) $this->delete($id_comentario);
    }
}
