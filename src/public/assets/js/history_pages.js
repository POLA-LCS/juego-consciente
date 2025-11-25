document.addEventListener('DOMContentLoaded', () => {
    // Lee los datos del historial desde la variable global definida en la vista.
    const allHistoryRecords = typeof gameHistoryData !== 'undefined' ? gameHistoryData : [];
    const historyBody = document.getElementById('history-body');
    const paginationControls = document.getElementById('pagination-controls');

    if (allHistoryRecords.length === 0) {
        historyBody.innerHTML = `<tr><td colspan="3" class="p-4 text-center text-[var(--color-text-muted)]">No hay partidas en tu historial todavía.</td></tr>`;
        if (paginationControls) paginationControls.style.display = 'none';
        return;
    }

    const recordsPerPage = 7;
    let currentPage = 1;
    const totalPages = Math.ceil(allHistoryRecords.length / recordsPerPage);

    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');

    function renderPage(page) {
        historyBody.innerHTML = '';
        const start = (page - 1) * recordsPerPage;
        const end = start + recordsPerPage;
        const pageRecords = allHistoryRecords.slice(start, end);

        pageRecords.forEach(record => {
            const resultClass = record.result > 0 ? 'text-green-400' : 'text-red-400';
            const resultSign = record.result > 0 ? '+' : '- ';
            const resultValue = record.result > 0 ? record.result : Math.abs(record.result);

            const row = `
                <tr class="border-t border-[var(--color-border)] hover:bg-[var(--color-background)] transition-colors">
                    <td class="p-4 uppercase font-semibold text-center">${record.game.toUpperCase()}</td>
                    <td class="p-4 text-center font-bold ${resultClass}">${resultSign}${resultValue}</td>
                    <td class="p-4 text-center">
                        <span class="block font-semibold">${new Date(record.played_at).toLocaleDateString('es-ES')}</span>
                        <span class="block text-xs text-[var(--color-text-muted)]">${new Date(record.played_at).toLocaleTimeString('es-ES')}</span>
                    </td>
                </tr>
            `;
            historyBody.innerHTML += row;
        });

        pageInfo.textContent = `Página ${page} de ${totalPages}`;
        prevButton.disabled = page === 1;
        nextButton.disabled = page === totalPages;
    }

    prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderPage(currentPage);
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            renderPage(currentPage);
        }
    });

    renderPage(currentPage);
});