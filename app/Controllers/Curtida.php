<?php

namespace App\Controllers;

use App\Models\CurtidaModel;

class Curtida extends BaseController
{
    public function toggle()
    {
        $session = session();
        $user = $session->get('usuario');
        if (! $user) {
            return redirect()->back();
        }

        $atividadeId = $this->request->getPost('atividade_id');
        if (! $atividadeId) {
            return redirect()->back();
        }

        $model = new CurtidaModel();

        // check by correct column names in curtida_curtida
        $exists = $model->where('fk_atividade_id_atividade', $atividadeId)
            ->where('fk_usuario_id_usuario', $user['id'])
            ->first();

        if ($exists) {
            // delete by where conditions
            $model->where('fk_atividade_id_atividade', $atividadeId)
                ->where('fk_usuario_id_usuario', $user['id'])
                ->delete();
        } else {
            $model->insert([
                'fk_atividade_id_atividade' => $atividadeId,
                'fk_usuario_id_usuario' => $user['id'],
            ]);
        }

        return redirect()->back();
    }
}
