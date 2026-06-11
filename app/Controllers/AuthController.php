<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

/**
 * Controlador de autenticação.
 * Métodos:
 * - index(): mostra a página de login
 * - login(): processa o POST de login
 * - register(): mostra/processa o cadastro
 * - logout(): encerra a sessão
 */
class AuthController extends BaseController
{
    // Exibe a view de login (app/Views/auth/login.php)
    public function index()
    {
        return view('auth/login');
    }

    // Processa o formulário de login
    public function login()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        $model = new UsuarioModel();
        $user = $model->buscarPorEmail($email);

        // Verifica existência e senha com password_verify
        if ($user && ! empty($user['senha']) && password_verify($senha, $user['senha'])) {
            // Inicia sessão com os dados solicitados
            session()->set([
                'id_usuario'   => (int) $user['id_usuario'],
                'nome_usuario' => $user['nome_usuario'],
                'imagem'       => $user['imagem'] ?? null,
            ]);

            // Se for requisição AJAX, retornar JSON indicando sucesso
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true]);
            }

            return redirect()->to(site_url('atividades'));
        }

        // Falha no login
        $errorMsg = 'Email ou senha inválidos';
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
        }

        session()->setFlashdata('error', $errorMsg);
        return redirect()->back()->withInput();
    }

    // Mostra o formulário de registro (GET) e processa o cadastro (POST)
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $dados = [
                'nome_usuario' => $this->request->getPost('nome_usuario'),
                'email'        => $this->request->getPost('email'),
                'senha'        => $this->request->getPost('senha'), // será hashada no model
            ];

            $model = new UsuarioModel();
            try {
                $insertId = $model->criar($dados);
                if ($insertId) {
                    // Loga o usuário automaticamente após registro
                    $user = $model->find($insertId);
                    session()->set([
                        'id_usuario'   => (int) $user['id_usuario'],
                        'nome_usuario' => $user['nome_usuario'],
                        'imagem'       => $user['imagem'] ?? null,
                    ]);
                    return redirect()->to(site_url('atividades'));
                }
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Erro ao registrar usuário');
                return redirect()->back()->withInput();
            }
        }

        // GET: mostra o formulário de registro (app/Views/auth/register.php)
        return view('auth/register');
    }

    // Encerra a sessão do usuário e redireciona para /login
    public function logout()
    {
        session()->remove(['id_usuario', 'nome_usuario', 'imagem']);
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}

