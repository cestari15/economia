// Aguarda o HTML ser totalmente carregado
document.addEventListener('DOMContentLoaded', () => {
    // Aplica o tema salvo imediatamente
    const savedTheme = localStorage.getItem('theme') || 'dark';
    if (savedTheme === 'light') {
        document.body.classList.add('light-theme');
    }
});

// Esta função fica acessível globalmente pois está no escopo da janela
window.toggleTheme = function() {
    document.body.classList.toggle('light-theme');
    const isLight = document.body.classList.contains('light-theme');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
};