<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minhas Atividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background:#f1f1f1; }
        .sidebar { background:#2f2f2f; color:#fff; min-height:100vh; }
        .logo { width:140px; height:140px; object-fit:cover; border-radius:50%; }
        .menu-item { border-top:1px solid #555; border-bottom:1px solid #555; padding:15px; font-size:20px; }
        .card-atividade { background:#fff; border:1px solid #ccc; margin-bottom:15px; }
        .avatar { width:90px; height:90px; object-fit:cover; border-radius:5px; }
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

        .topbar .top-link:hover { color: #ddd; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar p-4 text-center">
            <?php $foto = ! empty($usuario['imagem']) ? $usuario['imagem'] : 'default.png'; ?>
            <img src="<?= base_url('public/img/imagens_perfil/' . $foto) ?>" class="logo" alt="Avatar">
            <h4 class="mt-3"><?= esc($usuario['nome_usuario']) ?></h4>

            <div class="row mt-4">
                <div class="col">
                    <h3><?= $userActivities ?></h3>
                    <small>Qtd. Atividades</small>
                </div>
                <div class="col">
                    <h3><?= $userCalories ?></h3>
                    <small>Qtd. Calorias</small>
                </div>
            </div>

            <div class="menu-item mt-4" style="background:#5b42e6;color:#fff">
                <i class="fa-solid fa-chart-column"></i>
                Atividade
            </div>

            <div class="mt-5 text-center">
                <h5>SAEPSaúde</h5>
            </div>
        </div>

        <div class="col-md-9">

            <div class="topbar">
                <div class="container-fluid d-flex align-items-center">
                    <div class="flex-grow-1"></div>

                    <div class="top-links">
                        <a class="top-link" href="<?= site_url('/?tipo=corrida') ?>">Corrida</a>
                        <a class="top-link" href="<?= site_url('/?tipo=caminhada') ?>">Caminhada</a>
                        <a class="top-link" href="<?= site_url('/?tipo=trilha') ?>">Trilha</a>
                    </div>

                    <div class="flex-grow-1 text-end">
                        <a href="<?= site_url('/logout') ?>" class="btn" style="background:#333;color:#fff">Logout</a>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="text-center">Crie sua atividade</h3>
                    <form action="<?= site_url('atividade/salvar') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label>Tipo da atividade</label>
                                <input name="tipo_atividade" class="form-control" placeholder="Ex: Caminhada" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Distância percorrida</label>
                                <input name="distancia_percorrida" class="form-control" placeholder="Ex: 1000 metros" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Duração da atividade</label>
                                <input name="duracao_atividade" class="form-control" placeholder="Ex: 120 min" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Quantidade de Calorias</label>
                                <input name="quantidade_calorias" class="form-control" placeholder="Ex: 300" required>
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button class="btn btn-dark">Criar Atividade</button>
                        </div>
                    </form>
                </div>
            </div>

            <h4 class="mb-3">Suas Atividades</h4>

            <?php foreach ($atividades as $atividade): ?>
                <div class="card-atividade p-3">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <?php $foto = !empty($atividade['imagem']) ? $atividade['imagem'] : 'default.png'; ?>
                            <img src="<?= base_url('public/img/imagens_perfil/' . $foto) ?>" class="avatar">
                        </div>
                        <div class="col-md-8">
                            <h5><?= esc($atividade['tipo_atividade']) ?></h5>
                            <div class="row text-center mt-2">
                                <div class="col">
                                    <strong><?= esc($atividade['distancia_percorrida']) ?> km</strong><br>Distância
                                </div>
                                <div class="col">
                                    <strong><?= esc($atividade['duracao_atividade']) ?> min</strong><br>Duração
                                </div>
                                <div class="col">
                                    <strong><?= esc($atividade['quantidade_calorias']) ?></strong><br>Calorias
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <?php if (! empty($atividade['liked_by_user'])): ?>
                                <img src="<?= base_url('public/img/coracao.svg') ?>" style="width:24px;filter:invert(35%) sepia(98%) saturate(6500%) hue-rotate(345deg) brightness(100%) contrast(101%);">
                            <?php else: ?>
                                <i class="fa-regular fa-heart"></i>
                            <?php endif; ?>
                            <div><?= $atividade['likes'] ?? 0 ?></div>
                            <div><i class="fa-regular fa-comment"></i> <?= $atividade['comments'] ?? 0 ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-center mt-4 mb-4">
                <?= $pager->links() ?>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>