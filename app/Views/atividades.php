<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atividades - SAEPSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-atividade { margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container py-4">
    <?php if (! session()->get('id_usuario')): ?>
        <?php header('Location: ' . site_url('login')); exit; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Atividades de <?= esc($nome_usuario ?? session()->get('nome_usuario')) ?></h3>
        <form action="<?= site_url('logout') ?>" method="get">
            <button class="btn btn-dark">Logout</button>
        </form>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Criar nova atividade</h5>
            <form action="<?= site_url('atividades/criar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row g-2">
                    <div class="col-md-3">
                        <input name="tipo_atividade" class="form-control" placeholder="Tipo (corrida)" required>
                    </div>
                    <div class="col-md-2">
                        <input name="distancia_percorrida" type="number" step="any" class="form-control" placeholder="Dist km" required>
                    </div>
                    <div class="col-md-2">
                        <input name="duracao_atividade" type="number" class="form-control" placeholder="Duração min" required>
                    </div>
                    <div class="col-md-2">
                        <input name="quantidade_calorias" type="number" class="form-control" placeholder="Calorias" required>
                    </div>
                    <div class="col-md-3 text-end">
                        <button class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php foreach ($atividades as $a): ?>
        <div class="card card-atividade">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5><?= esc($a['tipo_atividade']) ?></h5>
                    <form action="<?= site_url('atividades/deletar') ?>" method="post" onsubmit="return confirm('Remover atividade?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_atividade" value="<?= esc($a['id_atividade']) ?>">
                        <button class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                </div>

                <div class="row mt-2">
                    <div class="col">Distância: <?= esc($a['distancia_percorrida']) ?> km</div>
                    <div class="col">Duração: <?= esc($a['duracao_atividade']) ?> min</div>
                    <div class="col">Calorias: <?= esc($a['quantidade_calorias']) ?></div>
                    <div class="col">Curtidas: <?= esc($a['likes'] ?? 0) ?></div>
                    <div class="col">Comentários: <?= esc($a['comments'] ?? 0) ?></div>
                </div>

                <hr>
                <div>
                    <h6>Comentários</h6>
                    <?php if (! empty($a['id_atividade'])): ?>
                        <?php $cm = new \App\Models\ComentarioModel(); $lista = $cm->buscarPorAtividade($a['id_atividade']); ?>
                        <?php if (! empty($lista)): ?>
                            <?php foreach ($lista as $c): ?>
                                <div class="mb-1"><strong><?= esc($c['fk_usuario_id_usuario']) ?>:</strong> <?= esc($c['mensagem']) ?></div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-muted">Nenhum comentário</div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="<?= site_url('comentario/salvar') ?>" method="post" class="mt-2">
                        <?= csrf_field() ?>
                        <input type="hidden" name="atividade_id" value="<?= esc($a['id_atividade']) ?>">
                        <div class="input-group">
                            <input name="texto" class="form-control" placeholder="Escreva um comentário..." required>
                            <button class="btn btn-outline-secondary">Enviar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
