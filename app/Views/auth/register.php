<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logar - SAEPSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f7f7f7}</style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Criar Conta</h4>

                    <?php if (session()->getFlashdata('register_error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('register_error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('register') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nome completo</label>
                            <input type="text" name="nome" class="form-control" value="<?= old('nome') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nome de usuário</label>
                            <input type="text" name="nome_usuario" class="form-control" value="<?= old('nome_usuario') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= site_url('/') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Logar</button>
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
