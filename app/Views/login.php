<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SAEPSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-area{ padding:1rem }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="login-area" style="background: <?= session()->get('id_usuario') ? '#000' : '#fff' ?>; color: <?= session()->get('id_usuario') ? '#fff' : '#000' ?>; padding:1rem;">
        <?php if (session()->get('id_usuario')): ?>
            <div>Bem-vindo, <?= esc(session()->get('nome_usuario')) ?></div>
            <a href="<?= site_url('logout') ?>" class="btn btn-light btn-sm mt-2">Sair</a>
        <?php else: ?>
            <h4>Entrar</h4>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-2">
                    <input name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-2">
                    <input name="senha" type="password" class="form-control" placeholder="Senha" required>
                </div>
                <button class="btn btn-primary">Login</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

                    <form action="<?= site_url('login') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('/') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
