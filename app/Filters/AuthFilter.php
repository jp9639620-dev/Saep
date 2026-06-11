<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Filtro de autenticação.
 * Verifica se existe sessão válida com 'id_usuario' antes de permitir acesso.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Executado antes da rota ser processada.
     * Se não houver usuário logado, redireciona para /login.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $sess = session();
        if (! $sess->get('id_usuario')) {
            return redirect()->to(site_url('login'));
        }
    }

    /**
     * Executado após a rota ser processada. (Não utilizado aqui.)
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // sem ação
    }
}

