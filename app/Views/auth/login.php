<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAEPSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f7f7f7}
        /* Estilos para a área de login quando o usuário estiver autenticado */
        .login-area-logged { background: #000 !important; color: #fff !important; }
        .login-area-logged a { color: #fff !important; }
    </style>
</head>
<body>
<!--
  View de login
  - Formulário Bootstrap com campos `email` e `senha`
  - Botão de submit com id `btn-login`
  - Quando houver sessão (`session()->get('id_usuario')`), a área de login troca para fundo preto e texto branco
  - Exibe mensagens de erro usando flashdata
-->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card <?= session()->get('id_usuario') ? 'login-area-logged' : '' ?>">
                <div class="card-body">
                    <h4 class="card-title mb-4">Entrar</h4>

                    <?php if (session()->getFlashdata('error') || session()->getFlashdata('login_error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?? session()->getFlashdata('login_error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('/login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= site_url('/') ?>" class="btn btn-secondary">Voltar</a>
                            <button id="btn-login" type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <small>Não tem conta? <a href="<?= site_url('register') ?>">Criar conta</a></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
