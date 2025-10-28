document.addEventListener('DOMContentLoaded', () => {
    const betSidebar = document.getElementById('betSidebar');
    const openBetSidebar = document.getElementById('openBetSidebar');
    const closeBetSidebar = document.getElementById('closeBetSidebar');

    if (openBetSidebar && betSidebar && closeBetSidebar) {
        openBetSidebar.addEventListener('click', () => {
            betSidebar.classList.toggle('-translate-x-full');
        });

        closeBetSidebar.addEventListener('click', () => {
            betSidebar.classList.add('-translate-x-full');
        });
    }
});

