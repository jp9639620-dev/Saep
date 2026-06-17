function renderSidebarComponent(stats) {
    // Atualiza os contadores numéricos na barra lateral
    document.getElementById('sidebar-count-atividades').textContent = stats.totalAtividades;
    document.getElementById('sidebar-count-calorias').textContent = stats.totalCalorias;
    
    // Altera o nome e a foto de perfil dependendo do estado de autenticação
    if (appState.isAutenticado) {
        document.getElementById('sidebar-username').textContent = stats.nome;
        
        // Mapeia o caminho da pasta onde estão guardadas as fotos de perfil dos usuários
        document.getElementById('sidebar-avatar').src = `<?= base_url('public/img/imagens_perfil/') ?>/${stats.imagem}`;
    } else {
        // Se deslogado, retorna o layout para o padrão institucional (conforme o estado inicial)
        document.getElementById('sidebar-username').textContent = "SAEPSaúde";
        document.getElementById('sidebar-avatar').src = `<?= base_url('public/img/logo_saepsaude/SAEPSaude.png') ?>`;
    }
}