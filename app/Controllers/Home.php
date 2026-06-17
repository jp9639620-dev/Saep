<?php

namespace App\Controllers;

use App\Models\AtividadeModel;
use Config\Database;

class Home extends BaseController
{
    /**
     * Página Inicial / Feed de Atividades
     */
    public function index()
    {
        $model = new AtividadeModel();
        $db = Database::connect();

        $tipo = $this->request->getGet('tipo');
        $session = session();
        $userId = $session->get('id_usuario');

        // Determina os contadores da Sidebar baseado no estado do login
        if ($userId) {
            // Se o usuário estiver logado, exibe os dados específicos dele
            $dados['totalAtividades'] = $db->table('atividade')->where('fk_usuario_id_usuario', $userId)->countAllResults();
            $sum = $db->table('atividade')->selectSum('quantidade_calorias')->where('fk_usuario_id_usuario', $userId)->get()->getRowArray();
            $dados['totalCalorias'] = $sum['quantidade_calorias'] ?? 0;
        } else {
            // Se não houver login, exibe os totais globais do sistema
            $dados['totalAtividades'] = $model->countAllResults();
            $total = $model->selectSum('quantidade_calorias')->first();
            $dados['totalCalorias'] = $total['quantidade_calorias'] ?? 0;
        }

        // Criação da Query principal trazendo os posts unidos aos dados dos respectivos autores
        $builder = $model->select('atividade.*, usuario.nome_usuario, usuario.imagem')
                         ->join('usuario', 'usuario.id_usuario = atividade.fk_usuario_id_usuario');

        if (!empty($tipo)) {
            $builder = $builder->where('LOWER(atividade.tipo_atividade)', strtolower($tipo));
        }

        $atividades = $builder->orderBy('atividade.createdAt', 'DESC')->paginate(4);
        
        // Verifica as curtidas para cada item renderizado no loop
        foreach ($atividades as &$a) {
            $atividadeId = $a['id_atividade'];
            
            $a['likes'] = (int) $db->table('curtida_curtida')->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();
            $a['comments'] = (int) $db->table('comentario_comentario')->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();
            
            $a['liked_by_user'] = false;
            if ($userId) {
                $a['liked_by_user'] = $db->table('curtida_curtida')
                    ->where('fk_atividade_id_atividade', $atividadeId)
                    ->where('fk_usuario_id_usuario', $userId)
                    ->countAllResults() > 0;
            }
        }

        $dados['atividades'] = $atividades;
        $dados['pager'] = $model->pager;
        $dados['tipo_atual'] = $tipo;

        return view('index', $dados);
    }

    /**
     * Endpoint de Autenticação Assíncrona via AJAX
     */
    public function login()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        if (empty($email) || empty($senha)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Por favor, preencha todos os campos.'
            ]);
        }

        $db = Database::connect();
        $usuario = $db->table('usuario')
                      ->where('email', $email)
                      ->where('senha', $senha)
                      ->get()
                      ->getRowArray();

        if ($usuario) {
            $session = session();
            $session->set([
                'id_usuario'   => $usuario['id_usuario'],
                'nome_usuario' => $usuario['nome_usuario'],
                'imagem'       => $usuario['imagem'],
                'usuario'      => [
                    'id'    => $usuario['id_usuario'],
                    'nome'  => $usuario['nome_usuario'],
                    'email' => $usuario['email']
                ]
            ]);

            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'E-mail ou senha incorretos.'
        ]);
    }

    /**
     * Finaliza a Sessão Atual do Usuário
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * Interface de Cadastro e Visualização Interna de Atividades
     */
    public function cadastroAtividade()
    {
        $session = session();
        $usuario = $session->get('usuario');

        if (!$usuario) {
            return redirect()->to('/');
        }

        $userId = $usuario['id'];
        $db = Database::connect();
        $model = new AtividadeModel();

        $atividades = $model
            ->where('fk_usuario_id_usuario', $userId)
            ->orderBy('createdAt', 'DESC')
            ->paginate(4);

        foreach ($atividades as &$a) {
            $atividadeId = $a['id_atividade'] ?? ($a['id'] ?? null);
            if ($atividadeId) {
                $a['likes'] = (int) $db->table('curtida_curtida')->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();
                $a['comments'] = (int) $db->table('comentario_comentario')->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();
                $a['liked_by_user'] = (int) $db->table('curtida_curtida')
                    ->where('fk_atividade_id_atividade', $atividadeId)
                    ->where('fk_usuario_id_usuario', $userId)
                    ->countAllResults() > 0;
            } else {
                $a['likes'] = 0;
                $a['comments'] = 0;
                $a['liked_by_user'] = false;
            }
        }

        $dados['usuario'] = $usuario;
        $dados['atividades'] = $atividades;
        $dados['pager'] = $model->pager;

        $dados['userActivities'] = (int) $db->table('atividade')->where('fk_usuario_id_usuario', $userId)->countAllResults();
        $sum = $db->table('atividade')->selectSum('quantidade_calorias')->where('fk_usuario_id_usuario', $userId)->get()->getRowArray();
        $dados['userCalories'] = $sum['quantidade_calorias'] ?? 0;

        return view('atividade/cadastro', $dados);
    }

    /**
     * Alterna o estado da curtida (Like / Unlike) no Banco de Dados
     */
    public function toggleLike()
    {
        $session = session();
        $userId = $session->get('id_usuario');

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Você precisa estar logado para curtir.']);
        }

        $atividadeId = $this->request->getPost('id_atividade');
        if (!$atividadeId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Atividade inválida.']);
        }

        $db = Database::connect();
        $tabelaCurtidas = $db->table('curtida_curtida');

        $jaCurtiu = $tabelaCurtidas->where('fk_atividade_id_atividade', $atividadeId)
                                   ->where('fk_usuario_id_usuario', $userId)
                                   ->countAllResults() > 0;

        if ($jaCurtiu) {
            $tabelaCurtidas->where('fk_atividade_id_atividade', $atividadeId)
                           ->where('fk_usuario_id_usuario', $userId)
                           ->delete();
            $acao = 'removido';
        } else {
            $tabelaCurtidas->insert([
                'fk_atividade_id_atividade' => $atividadeId,
                'fk_usuario_id_usuario'     => $userId
            ]);
            $acao = 'adicionado';
        }

        $totalLikes = $tabelaCurtidas->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();

        return $this->response->setJSON([
            'success'    => true,
            'acao'       => $acao,
            'totalLikes' => $totalLikes
        ]);
    }

    /**
     * Insere um novo comentário associado à atividade no Banco de Dados
     */
    public function adicionarComentario()
    {
        $session = session();
        $userId = $session->get('id_usuario');

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Você precisa estar logado para comentar.']);
        }

        $atividadeId = $this->request->getPost('id_atividade');
        $mensagem    = $this->request->getPost('mensagem');

        if (!$atividadeId || empty(trim($mensagem))) {
            return $this->response->setJSON(['success' => false, 'message' => 'O comentário não pode estar vazio.']);
        }

        $db = Database::connect();
        $tabelaComentarios = $db->table('comentario_comentario');

        $tabelaComentarios->insert([
            'mensagem'                  => esc($mensagem),
            'fk_usuario_id_usuario'     => $userId,
            'fk_atividade_id_atividade' => $atividadeId
        ]);

        $totalComments = $tabelaComentarios->where('fk_atividade_id_atividade', $atividadeId)->countAllResults();

        return $this->response->setJSON([
            'success'       => true,
            'totalComments' => $totalComments
        ]);
    }
} // <- Esta é a chave final que fecha a classe Home!