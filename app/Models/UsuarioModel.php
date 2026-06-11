<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para a tabela `usuario`.
 *
 * Campos esperados (ajuste conforme seu schema):
 * - id_usuario (PK)
 * - nome_usuario
 * - email
 * - senha
 * - imagem
 * - createdAt
 * - updatedAt
 */
class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';

    // Campos que podem ser inseridos/atualizados via Model
    protected $allowedFields = [
        'nome_usuario', 'email', 'senha', 'imagem', 'createdAt', 'updatedAt'
    ];

    // Habilita timestamps automáticos (se as colunas existirem)
    protected $useTimestamps = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';

    /**
     * Buscar usuário por email.
     *
     * @param string $email
     * @return array|null
     */
    public function buscarPorEmail(string $email)
    {
        return $this->asArray()->where('email', $email)->first();
    }

    /**
     * Criar novo usuário.
     * A senha recebida em $dados['senha'] é armazenada usando password_hash().
     *
     * @param array $dados
     * @return int|false Retorna o id inserido ou false em caso de falha.
     */
    public function criar(array $dados)
    {
        if (isset($dados['senha'])) {
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        }

        // Se o projeto não estiver usando timestamps automáticos, descomente:
        // $dados['createdAt'] = date('Y-m-d H:i:s');
        // $dados['updatedAt'] = date('Y-m-d H:i:s');

        return $this->insert($dados);
    }
}

