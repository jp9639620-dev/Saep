<?php

namespace App\Controllers;

use App\Models\AtividadeModel;

class Atividade extends BaseController
{
    public function salvar()
    {
        $session = session();
        $usuario = $session->get('usuario');
        if (! $usuario) {
            return redirect()->to('/');
        }

        $data = [
            'tipo_atividade' => $this->request->getPost('tipo_atividade'),
            'distancia_percorrida' => $this->request->getPost('distancia_percorrida'),
            'duracao_atividade' => $this->request->getPost('duracao_atividade'),
            'quantidade_calorias' => $this->request->getPost('quantidade_calorias'),
            'fk_usuario_id_usuario' => $usuario['id'],
        ];

        $model = new AtividadeModel();
        $model->insert($data);

        return redirect()->to(site_url('atividade'));
    }
}
