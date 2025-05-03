window.setupAjaxFilter = function ({ searchSelector = '#search', filterSelector = '#statusFilter', tableContainer = '#ruu-table-container', fetchUrl = window.location.href }) {
    const fetchData = (page = 1) => {
        let keyword = $(searchSelector).val();
        let status = $(filterSelector).val();

        $.ajax({
            url: `${fetchUrl}?page=${page}`,
            method: 'GET',
            data: { keyword, status },
            success: function (data) {
                $(tableContainer).html($(data).find(tableContainer).html());
            },
            error: function () {
                Swal.fire('Gagal', 'Gagal memuat data.', 'error');
            }
        });
    };

    $(document).on('input', searchSelector, () => fetchData());
    $(document).on('change', filterSelector, () => fetchData());
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });
};
