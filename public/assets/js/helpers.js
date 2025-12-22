function episodeNumberToRoman(num) {
    if (!isFinite(num)) {
        return '';
    }
    const romanNumerals = [
        { value: 10, numeral: 'X' },
        { value: 9, numeral: 'IX' },
        { value: 5, numeral: 'V' },
        { value: 4, numeral: 'IV' },
        { value: 1, numeral: 'I' }
    ];

    let result = '';
    for (const { value, numeral } of romanNumerals) {
        while (num >= value) {
            result += numeral;
            num -= value;
        }
    }
    return result;
}

function createPagination(totalPages, currentPage, route) {
    const paginationElement = $(`
            <ul class="list-group list-group-horizontal justify-content-end mb-5 mt-3" id="pagination-controls"></ul>
        `);
    const paginationItem = `
            <li class="list-group-item text-warning border-warning" style="cursor: pointer; :hover { background: var(--bs-warning); color: #1a1a1a !important; }">0</li>
        `;

    const prevItem = $(paginationItem);
    prevItem.text('« Prev');
    if (currentPage > 1) {
        prevItem.on('click', function () {
            window.location.href = route + '?page=' + (currentPage - 1);
        });
    } else {
        prevItem.addClass('disabled');
    }
    paginationElement.append(prevItem);

    for (let i = currentPage - 3; i < currentPage; i++) {
        if (i < 1) continue;
        const pageItem = $(paginationItem);
        pageItem.text(i);
        pageItem.on('click', function () {
            window.location.href = route + '?page=' + i;
        });
        paginationElement.append(pageItem);
    }

    const currentItem = $(paginationItem);
    currentItem.text(currentPage);
    currentItem.addClass('bg-warning text-dark');
    paginationElement.append(currentItem);

    for (let i = currentPage + 1; i <= Math.min(currentPage + 2, totalPages); i++) {
        const pageItem = $(paginationItem);
        pageItem.text(i);
        pageItem.on('click', function () {
            window.location.href = route + '?page=' + i;
        });
        paginationElement.append(pageItem);
    }

    const nextItem = $(paginationItem);
    nextItem.text('Next »');
    if (currentPage < totalPages) {
        nextItem.on('click', function () {
            window.location.href = route + '?page=' + (currentPage + 1);
        });
    } else {
        nextItem.addClass('disabled');
    }
    paginationElement.append(nextItem);

    return paginationElement;
}