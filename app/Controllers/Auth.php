<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\LoginLogModel;

class Auth extends BaseController
{
    public function login()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        $model = new UsuarioModel();
        $user = $model->where('email', $email)->first();

        if ($user) {
            // support hashed or plain passwords
            $valid = false;
            if (! empty($user['senha']) && password_verify($senha, $user['senha'])) {
                $valid = true;
            } elseif (! empty($user['senha']) && $user['senha'] === $senha) {
                $valid = true;
            }

            if ($valid) {
                session()->set('usuario', [
                    'id' => $user['id_usuario'],
                    'nome_usuario' => $user['nome_usuario'],
                    'imagem' => $user['imagem'] ?? null,
                ]);

                // record login event in DB
                try {
                    $logModel = new LoginLogModel();
                    $logModel->insert([
                        'fk_usuario_id_usuario' => $user['id_usuario'],
                        'ip' => $this->request->getIPAddress(),
                        'user_agent' => $this->request->getUserAgent()->getAgentString(),
                        'createdAt' => date('Y-m-d H:i:s'),
                    ]);
                } catch (\Throwable $e) {
                    // don't block login if logging fails; consider logging to file
                    log_message('error', 'Login log failed: ' . $e->getMessage());
                }

                // after successful login, redirect to atividade (user area)
                return redirect()->to(site_url('atividade'));
            }
        }

        session()->setFlashdata('login_error', 'Credenciais inválidas.');
        return redirect()->back();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    // Show registration form
    public function showRegister()
    {
        return view('auth/register');
    }

    // Handle registration POST
    public function register()
    {
        $nome = $this->request->getPost('nome');
        $nome_usuario = $this->request->getPost('nome_usuario');
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        // basic validation
        if (empty($email) || empty($senha) || empty($nome) || empty($nome_usuario)) {
            session()->setFlashdata('register_error', 'Preencha todos os campos obrigatórios.');
            return redirect()->back()->withInput();
        }

        $model = new UsuarioModel();

        // check unique email or username
        if ($model->where('email', $email)->first()) {
            session()->setFlashdata('register_error', 'Email já cadastrado.');
            return redirect()->back()->withInput();
        }

        if ($model->where('nome_usuario', $nome_usuario)->first()) {
            session()->setFlashdata('register_error', 'Nome de usuário já existe.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nome' => $nome,
            'nome_usuario' => $nome_usuario,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'imagem' => 'default.png',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        $insertId = $model->insert($data);

        if ($insertId) {
            // auto-login
            session()->set('usuario', [
                'id' => $insertId,
                'nome_usuario' => $nome_usuario,
                'imagem' => 'default.png',
            ]);
            return redirect()->to('/');
        }

        session()->setFlashdata('register_error', 'Erro ao criar conta. Tente novamente.');
        return redirect()->back()->withInput();
    }
}
