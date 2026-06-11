<?php

namespace App\Controllers;

use App\Models\AtividadeModel;
use App\Models\CurtidaModel;
use App\Models\ComentarioModel;

class AtividadeController extends BaseController
{
    protected $atividadeModel;

    public function __construct()
    {
        $this->atividadeModel = new AtividadeModel();
    }

    // Lista atividades do usuário logado
    public function index()
    {
        $sess = session();
        $id = $sess->get('id_usuario');
        if (! $id) {
            return redirect()->to(site_url('login'));
        }

        $atividades = $this->atividadeModel->buscarPorUsuario($id);

        // adicionar contagens de curtidas e comentários
        $curtidaModel = new CurtidaModel();
        $comentarioModel = new ComentarioModel();

        foreach ($atividades as &$a) {
            $aid = $a['id_atividade'] ?? null;
            if ($aid) {
                $a['likes'] = $curtidaModel->contarCurtidas((int) $aid);
                $a['comments'] = count($comentarioModel->buscarPorAtividade((int) $aid));
            } else {
                $a['likes'] = 0;
                $a['comments'] = 0;
            }
        }

        $dados['atividades'] = $atividades;
        $dados['nome_usuario'] = $sess->get('nome_usuario');

        return view('atividades', $dados);
    }

    // Criar nova atividade (POST)
    public function criar()
    {
        $sess = session();
        $id = $sess->get('id_usuario');
        if (! $id) {
            return redirect()->to(site_url('login'));
        }

        $data = [
            'tipo_atividade' => $this->request->getPost('tipo_atividade'),
            'distancia_percorrida' => (int) $this->request->getPost('distancia_percorrida'),
            'duracao_atividade' => (int) $this->request->getPost('duracao_atividade'),
            'quantidade_calorias' => (int) $this->request->getPost('quantidade_calorias'),
            'fk_usuario_id_usuario' => $id,
        ];

        $this->atividadeModel->criar($data);
        return redirect()->back();
    }

    // Deletar atividade (POST) — garante que só o dono possa deletar
    public function deletar()
    {
        $sess = session();
        $id = $sess->get('id_usuario');
        if (! $id) {
            return redirect()->to(site_url('login'));
        }

        $id_atividade = (int) $this->request->getPost('id_atividade');
        // verificar propriedade
        $atividade = $this->atividadeModel->find($id_atividade);
        if (! $atividade || (int) $atividade['fk_usuario_id_usuario'] !== $id) {
            return redirect()->back();
        }

        $this->atividadeModel->deletar($id_atividade);
        return redirect()->back();
    }
}
