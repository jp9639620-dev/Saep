<?php

namespace App\Controllers;

use App\Models\AtividadeModel;
use Config\Database;

class Home extends BaseController
{
    public function index()
    {
        $model = new AtividadeModel();

        $tipo = $this->request->getGet('tipo');

        $dados['totalAtividades'] = $model->countAll();

        $total = $model
            ->selectSum('quantidade_calorias')
            ->first();

        $dados['totalCalorias'] = $total['quantidade_calorias'] ?? 0;

        // Apenas buscar atividades se houver usuário logado
        $session = session();
        if ($session->get('id_usuario')) {
            $builder = $model->select('atividade.*, usuario.nome_usuario, usuario.imagem')
                ->join('usuario', 'usuario.id_usuario = atividade.fk_usuario_id_usuario');

            if (! empty($tipo)) {
                $builder = $builder->where('LOWER(atividade.tipo_atividade)', strtolower($tipo));
            }

            $dados['atividades'] = $builder->orderBy('atividade.createdAt', 'DESC')->paginate(4);
            $dados['pager'] = $model->pager;
        } else {
            // Sem sessão: não passar atividades
            $dados['atividades'] = [];
            $dados['pager'] = null;
        }

        return view('atividade/index', $dados);
    }

    public function cadastroAtividade()
    {
        $session = session();
        $usuario = $session->get('usuario');

        if (! $usuario) {
            return redirect()->to('/');
        }

        $userId = $usuario['id'];

        $db = Database::connect();
        $model = new AtividadeModel();

        $atividades = $model
            ->where('fk_usuario_id_usuario', $userId)
            ->orderBy('createdAt', 'DESC')
            ->paginate(4);

        // add likes/comments counts (use actual table names)
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

        // user totals
        $dados['userActivities'] = (int) $db->table('atividade')->where('fk_usuario_id_usuario', $userId)->countAllResults();
        $sum = $db->table('atividade')->selectSum('quantidade_calorias')->where('fk_usuario_id_usuario', $userId)->get()->getRowArray();
        $dados['userCalories'] = $sum['quantidade_calorias'] ?? 0;

        return view('atividade/cadastro', $dados);
    }
}