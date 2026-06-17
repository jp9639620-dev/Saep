<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SAEPSaúde</title>

<link href="<?= base_url('public/css/bootstrap.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body{
    background:#e5e5e5;
}
.sidebar{
    background:#2d2d2d;
    color:white;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}
.logo{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
}
.menu-item{
    border-top:1px solid #666;
    border-bottom:1px solid #666;
    padding:15px;
    background:#383838;
}
.menu-item a{
    color:white;
    text-decoration:none;
    font-size:22px;
    display:flex;
    align-items:center;
}
.menu-item a.desabilitado {
    pointer-events: none;
    opacity: 0.5;
}
.rodape{
    margin-top:auto;
    text-align:center;
    padding:20px;
}
.redes i{
    font-size:30px;
    margin:0 10px;
}
.topbar{
    background:#2d2d2d;
}
.topbar a{
    color:white;
    text-decoration:none;
    font-size:20px;
    padding:10px 20px;
}
.topbar a.filtro-ativo {
    background: #4b4bd8;
    font-weight: bold;
}
.login-btn{
    width:120px;
}
.card-feed{
    background:white;
    border:1px solid #bbb;
    margin-top:10px;
}
.avatar{
    width:90px;
    height:90px;
    border-radius: 4px;
    object-fit:cover;
}
.titulo{
    font-size:32px;
    font-weight:bold;
}
.icones {
    font-size:28px;
    display: inline-block;
    margin-right: 5px;
    cursor: pointer;
}
.container-comentarios {
    background: #fdfdfd;
    border-top: 1px solid #ddd;
    padding: 15px;
    display: none;
}
.paginacao ul {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
}
.paginacao li a, .paginacao li span {
    border:1px solid #666;
    background:white;
    padding:6px 12px;
    color: black;
    text-decoration: none;
    margin: 0 2px;
}
.paginacao li.active a, .paginacao li.active span {
    background:#4b4bd8 !important;
    color:white !important;
}

/* Topbar com logout */
.topbar-header {
    background: #333333;
    color: #FFFFFF;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
}
.topbar-header a.btn-logout {
    color: #FFFFFF;
    background: transparent;
    border: 1px solid #FFFFFF;
    padding: 6px 16px;
    text-decoration: none;
    border-radius: 4px;
    font-size: 16px;
}
.topbar-header a.btn-logout:hover {
    background: #FFFFFF;
    color: #333333;
}
.topbar-header span {
    color: #FFFFFF;
    margin-right: 15px;
    font-size: 16px;
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<div class="col-md-3 sidebar">
    <div class="text-center p-4">
        <?php
            if (session()->get('id_usuario')) {
                $fotoSessao = session()->get('imagem');
                $fotoPerfil = !empty($fotoSessao) ? $fotoSessao : 'placeholder.jpg';
                $srcFinal = base_url('public/img/imagens_perfil/' . $fotoPerfil);
            } else {
                $srcFinal = base_url('public/img/logo_saepsaude/SAEPSaude.png');
            }
        ?>
        <img src="<?= $srcFinal ?>" id="sidebar-avatar" class="logo" alt="Foto de Perfil">

        <h2 class="mt-3" id="sidebar-username">
            <?= session()->get('id_usuario') ? esc(session()->get('nome_usuario')) : 'SAEPSaúde' ?>
        </h2>

        <div class="row mt-4">
            <div class="col">
                <h2 id="sidebar-count-atividades"><?= $totalAtividades ?></h2>
                <small>Qtd. Atividades</small>
            </div>
            <div class="col">
                <h2 id="sidebar-count-calorias"><?= $totalCalorias ?></h2>
                <small>Qtd. Calorias</small>
            </div>
        </div>
    </div>

    <div class="menu-item">
        <a href="<?= site_url('/cadastroAtividade') ?>" 
           class="<?= !session()->get('id_usuario') ? 'desabilitado' : '' ?>">
            <img src="<?= base_url('public/img/icones/progresso.svg') ?>" 
                 alt="progresso" 
                 style="width:24px; height:24px; margin-right:10px;">
            Atividade
        </a>
    </div>

    <div class="rodape">
        <hr>
        <h3>SAEPSaúde</h3>
        <div class="redes">
            <i class="fab fa-instagram"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-tiktok"></i>
        </div>
        <p class="mt-3">Copyright 2025/2026</p>
    </div>
</div>

<div class="col-md-9">

    <div class="topbar-header">
        <?php if(!session()->get('id_usuario')): ?>
            <button class="btn btn-light login-btn" data-toggle="modal" data-target="#loginModal">Login</button>
        <?php else: ?>
            <span>Olá, <strong><?= esc(session()->get('nome_usuario')) ?></strong></span>
            <a href="<?= site_url('/logout') ?>" class="btn-logout">Logout</a>
        <?php endif; ?>
    </div>

    <div class="topbar d-flex justify-content-center">
        <a href="<?= site_url('/') ?>" class="<?= empty($tipo_atual) ? 'filtro-ativo' : '' ?>">Todas</a>
        <a href="<?= site_url('/?tipo=Corrida') ?>" class="<?= $tipo_atual == 'Corrida' ? 'filtro-ativo' : '' ?>">Corrida</a>
        <a href="<?= site_url('/?tipo=Caminhada') ?>" class="<?= $tipo_atual == 'Caminhada' ? 'filtro-ativo' : '' ?>">Caminhada</a>
        <a href="<?= site_url('/?tipo=Trilha') ?>" class="<?= $tipo_atual == 'Trilha' ? 'filtro-ativo' : '' ?>">Trilha</a>
    </div>

    <?php if (!empty($atividades) && is_array($atividades)): ?>
        <?php foreach ($atividades as $atividade): ?>
            <div class="card-feed">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <?php 
                                $avatarNome = !empty($atividade['imagem']) ? $atividade['imagem'] : 'placeholder.jpg';
                                $avatarUrl = base_url('public/img/imagens_perfil/' . $avatarNome);
                            ?>
                            <img src="<?= $avatarUrl ?>" class="avatar" alt="Avatar">
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex justify-content-between">
                                <h4><?= esc($atividade['nome_usuario'] ?? 'Usuário') ?></h4>
                                <small><?= date('H:i - d/m/Y', strtotime($atividade['createdAt'])) ?></small>
                            </div>
                            <div class="text-center titulo"><?= esc($atividade['tipo_atividade']) ?></div>
                            
                            <div class="row mt-4 text-center">
                                <div class="col"><h5><?= esc($atividade['distancia_percorrida']) ?> km</h5>Distância</div>
                                <div class="col"><h5><?= esc($atividade['duracao_atividade']) ?> min</h5>Duração</div>
                                <div class="col"><h5><?= esc($atividade['quantidade_calorias']) ?></h5>Calorias</div>
                                
                                <div class="col">
                                    <div class="icones btn-like-spa" data-id="<?= $atividade['id_atividade'] ?>">
                                        <img src="<?= base_url('public/img/icones/coracao.svg') ?>" 
                                             alt="Curtir"
                                             style="width: 28px; height: 28px; transition: filter 0.2s; <?= $atividade['liked_by_user'] ? 'filter: invert(15%) sepia(95%) saturate(6932%) hue-rotate(358deg) brightness(95%) contrast(112%);' : 'filter: grayscale(100%) opacity(60%);' ?>">
                                    </div>
                                    <span id="like-count-<?= $atividade['id_atividade'] ?>"><?= $atividade['likes'] ?></span>
                                </div>

                                <div class="col">
                                    <div class="icones btn-comment-spa" data-id="<?= $atividade['id_atividade'] ?>">
                                        <i class="fa-regular fa-comment"></i>
                                    </div>
                                    <span id="comment-count-<?= $atividade['id_atividade'] ?>"><?= $atividade['comments'] ?></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container-comentarios" id="box-comentarios-<?= $atividade['id_atividade'] ?>">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" 
                               id="input-msg-<?= $atividade['id_atividade'] ?>" 
                               placeholder="Escrever comentário..." 
                               <?= session()->get('id_usuario') ? '' : 'disabled' ?>>
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-enviar-comentario" 
                                    data-id="<?= $atividade['id_atividade'] ?>" 
                                    <?= session()->get('id_usuario') ? '' : 'disabled' ?>>
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">
                        <?= session()->get('id_usuario') ? '' : 'Faça login para escrever um comentário.' ?>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-light text-center mt-4 border">Nenhuma atividade registrada nesta categoria até o momento.</div>
    <?php endif; ?>

    <div class="text-center mt-4 paginacao">
        <?php if ($pager): ?>
            <?= $pager->links() ?>
        <?php endif; ?>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Autenticação de Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="modal-login-error" style="display: none;"></div>
        <div id="modal-login-form">
          <div class="form-group">
            <label for="login-email">E-mail</label>
            <input type="email" name="email" class="form-control" id="login-email" placeholder="Ex: seuemail@provedor.com" required>
          </div>
          <div class="form-group">
            <label for="login-senha">Senha</label>
            <input type="password" name="senha" class="form-control" id="login-senha" placeholder="Informe sua senha" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="modal-btn-login">Logar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function vincularEventosInteracoes() {

    // 1. Curtidas via AJAX (Garante aplicação correta da cor na tag img)
    document.querySelectorAll('.btn-like-spa').forEach(botao => {
        botao.addEventListener('click', function() {
            const idAtividade = this.getAttribute('data-id');
            const imgCoracao = this.querySelector('img'); // Localiza a imagem interna de forma exata
            const formData = new FormData();
            formData.append('id_atividade', idAtividade);

            fetch('<?= base_url('index.php/toggleLike') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualiza o número de curtidas na tela instantaneamente
                    document.getElementById(`like-count-${idAtividade}`).textContent = data.totalLikes;
                    
                    // Altera o filtro cromático da imagem .svg
                    if (data.acao === 'adicionado') {
                        imgCoracao.style.filter = 'invert(15%) sepia(95%) saturate(6932%) hue-rotate(358deg) brightness(95%) contrast(112%)';
                    } else {
                        imgCoracao.style.filter = 'grayscale(100%) opacity(60%)';
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert('Erro ao processar curtida.'));
        });
    });

    // 2. Abrir e Fechar Comentários
    document.querySelectorAll('.btn-comment-spa').forEach(botao => {
        botao.addEventListener('click', function() {
            const idAtividade = this.getAttribute('data-id');
            const box = document.getElementById(`box-comentarios-${idAtividade}`);
            if (box.style.display === 'block') {
                box.style.display = 'none';
            } else {
                box.style.display = 'block';
                const inputCampo = document.getElementById(`input-msg-${idAtividade}`);
                if (inputCampo) inputCampo.focus();
            }
        });
    });

    // 3. Enviar Comentários via AJAX
    document.querySelectorAll('.btn-enviar-comentario').forEach(botao => {
        botao.addEventListener('click', function() {
            const idAtividade = this.getAttribute('data-id');
            const inputCampo = document.getElementById(`input-msg-${idAtividade}`);
            const mensagem = inputCampo.value;

            if (!mensagem.trim()) return;

            const formData = new FormData();
            formData.append('id_atividade', idAtividade);
            formData.append('mensagem', mensagem);

            fetch('<?= base_url('index.php/adicionarComentario') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`comment-count-${idAtividade}`).textContent = data.totalComments;
                    inputCampo.value = '';
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert('Erro ao enviar comentário.'));
        });
    });
}

document.addEventListener('DOMContentLoaded', function(){
    vincularEventosInteracoes();

    // Login Dinâmico na Modal
    const btnLogar = document.getElementById('modal-btn-login');
    const errorBox = document.getElementById('modal-login-error');

    if(btnLogar) {
        btnLogar.addEventListener('click', function(){
            errorBox.style.display = 'none';
            const formData = new FormData();
            formData.append('email', document.getElementById('login-email').value);
            formData.append('senha', document.getElementById('login-senha').value);

            fetch('<?= base_url('index.php/login') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())\n            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    errorBox.textContent = data.message;
                    errorBox.style.display = 'block';
                }
            })
            .catch(() => {
                errorBox.textContent = 'Ocorreu um erro no servidor. Tente novamente.';
                errorBox.style.display = 'block';
            });
        });
    }
});
</script>

</body>
</html>