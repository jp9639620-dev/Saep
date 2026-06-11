<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAEPSaúde</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f1f1f1;
        }b

        .sidebar {
            background: #2f2f2f;
            color: white;
            min-height: 100vh;
            position: relative;
        }

        .logo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
        }

        .menu-item {
            border-top: 1px solid #555;
            border-bottom: 1px solid #555;
            padding: 15px;
            font-size: 20px;
        }

        .card-atividade {
            background: #fff;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        .avatar {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 5px;
        }

        .atividade-titulo {
            font-size: 32px;
            font-weight: bold;
        }

        .redes i {
            font-size: 30px;
            margin: 0 10px;
        }

        .login-btn {
            width: 120px;
        }

        .rodape-sidebar {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }

        /* Topbar */
        .topbar {
            background: #333333;
            padding: 6px 0;
        }

        .topbar .top-links {
            display: flex;
            gap: 36px;
            align-items: center;
            justify-content: center;
        }

        .topbar .top-link {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            padding: 6px 12px;
        }

        .topbar .top-link:hover {
            color: #ddd;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 sidebar p-0">

            <div class="text-center p-4">

                <img src="<?= base_url('public/img/logo_saepsaude/SAEPSaude.png') ?>"
                     class="logo"
                     alt="Logo">

                <h2 class="mt-3">SAEPSaúde</h2>

                <div class="row mt-4">

                    <div class="col">
                        <h3><?= $totalAtividades ?></h3>
                        <small>Qtd. Atividades</small>
                    </div>

                    <div class="col">
                        <h3><?= $totalCalorias ?></h3>
                        <small>Qtd. Calorias</small>
                    </div>

                </div>

            </div>

            <div class="menu-item">
                <?php $sess = session(); if ($sess->get('usuario')): ?>
                    <a href="<?= site_url('atividade') ?>" style="color:inherit;text-decoration:none;">
                        <i class="fa-solid fa-chart-column"></i>
                        Atividade
                    </a>
                <?php else: ?>
                    <span style="opacity:0.6; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-chart-column"></i>
                        Atividade
                    </span>
                <?php endif; ?>
            </div>

            <div class="rodape-sidebar text-center">

                <h4>SAEPSaúde</h4>

                <div class="redes">
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-tiktok"></i>
                </div>

                <small>
                    Copyright - 2025/2026
                </small>

            </div>

        </div>

        <!-- CONTEÚDO -->
        <div class="col-md-9">

            <!-- TOPBAR FILTERS -->
            <div class="topbar">
                <div class="container-fluid d-flex align-items-center">
                    <div class="flex-grow-1"></div>

                    <div class="top-links">
                        <a class="top-link" href="<?= site_url('/?tipo=corrida') ?>">Corrida</a>
                        <a class="top-link" href="<?= site_url('/?tipo=caminhada') ?>">Caminhada</a>
                        <a class="top-link" href="<?= site_url('/?tipo=trilha') ?>">Trilha</a>
                    </div>

                    <div class="flex-grow-1 text-end">
                        <?php $sess = session(); if ($sess->get('id_usuario')): ?>
                            <!-- Mostrar nome do usuário com fundo preto quando logado -->
                            <a href="<?= site_url('/logout') ?>" class="btn" style="background:#000;color:#fff"><?= esc($sess->get('nome_usuario')) ?></a>
                        <?php else: ?>
                            <button class="btn btn-light login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Logar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <?php if (session()->get('id_usuario')): ?>
                    <?php foreach ($atividades as $atividade): ?>

                        <div class="card-atividade p-3">

                            <div class="row align-items-center">

                                <!-- FOTO -->
                                <div class="col-md-2 text-center">

                                    <?php
                                    $foto = !empty($atividade['imagem'])
                                        ? $atividade['imagem']
                                        : 'default.png';
                                    ?>

                                    <img
                                        src="<?= base_url('public/img/imagens_perfil/' . $foto) ?>"
                                        class="avatar"
                                        alt="Foto de Perfil">

                                </div>

                                <!-- DADOS -->
                                <div class="col-md-10">

                                    <div class="d-flex justify-content-between">

                                        <h4>
                                            <?= esc($atividade['nome_usuario']) ?>
                                        </h4>

                                        <small>
                                            <?= date(
                                                'H:i - d/m/Y',
                                                strtotime($atividade['createdAt'])
                                            ) ?>
                                        </small>

                                    </div>

                                    <div class="text-center atividade-titulo">

                                        <?= esc($atividade['tipo_atividade']) ?>

                                    </div>

                                    <div class="row mt-4 text-center">

                                        <div class="col">
                                            <h5>
                                                <?= esc($atividade['distancia_percorrida']) ?> km
                                            </h5>
                                            Distância
                                        </div>

                                        <div class="col">
                                            <h5>
                                                <?= esc($atividade['duracao_atividade']) ?> min
                                            </h5>
                                            Duração
                                        </div>

                                        <div class="col">
                                            <h5>
                                                <?= esc($atividade['quantidade_calorias']) ?>
                                            </h5>
                                            Calorias
                                        </div>

                                        <div class="col">
                                            <h5>
                                                <i class="fa-regular fa-heart"></i>
                                            </h5>
                                            Curtidas
                                        </div>

                                        <div class="col">
                                            <h5>
                                                <i class="fa-regular fa-comment"></i>
                                            </h5>
                                            Comentários
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center mt-5">
                        <p>Faça login para ver as atividades.</p>
                        <a href="<?= site_url('login') ?>" class="btn btn-dark">Entrar</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- PAGINAÇÃO -->
            <div class="d-flex justify-content-center mt-4 mb-4">
               <?php if (isset($pager) && $pager): ?>
                 <?= $pager->links() ?>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form id="modal-login-form">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-login-error" class="alert alert-danger small mb-2" style="display:none"></div>

                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input id="modal-email" type="email" name="email" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Senha</label>
                        <input id="modal-senha" type="password" name="senha" class="form-control form-control-sm" required>
                    </div>
                    <?= csrf_field() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button id="modal-btn-login" type="button" class="btn btn-dark btn-sm">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('modal-btn-login');
    const form = document.getElementById('modal-login-form');
    const err = document.getElementById('modal-login-error');

    btn && btn.addEventListener('click', function(){
        err.style.display = 'none';
        const formData = new FormData(form);
        // include CSRF token automatically present in the form

        fetch('<?= site_url('/login') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // reload page to reflect session state
                window.location.reload();
            } else {
                err.textContent = data.message || 'Falha no login';
                err.style.display = 'block';
            }
        })
        .catch(() => {
            err.textContent = 'Erro na requisição. Tente novamente.';
            err.style.display = 'block';
        });
    });
});
</script>