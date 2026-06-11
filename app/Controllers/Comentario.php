<?php

namespace App\Controllers;

use App\Models\ComentarioModel;

class Comentario extends BaseController
{
    public function salvar()
    {
        $session = session();
        $user = $session->get('usuario');
        if (! $user) {
            return redirect()->back();
        }

        $texto = trim($this->request->getPost('texto'));
        $atividadeId = $this->request->getPost('atividade_id');

        if ($texto === '') {
            session()->setFlashdata('comentario_error', 'Não é possível enviar um comentário vazio.');
            return redirect()->back();
        }

        if (mb_strlen($texto) < 3) {
            session()->setFlashdata('comentario_error', 'Comentário deve ter ao menos 3 caracteres.');
            return redirect()->back();
        }

        $model = new ComentarioModel();
        $model->insert([
            'mensagem' => $texto,
            'fk_usuario_id_usuario' => $user['id'],
            'fk_atividade_id_atividade' => $atividadeId,
        ]);

        return redirect()->back();
    }
}
