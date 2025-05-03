window.enableAjaxPagination = function(containerSelector, paginationSelector) {
    $(document).on('click', `${paginationSelector} a`, function(e) {
        e.preventDefault();
        const url = new URL($(this).attr('href'), window.location.origin);

        const search = $('#search').val();
        const status = $('#statusFilter').val();

        if (search) url.searchParams.set('search', search);
        if (status) url.searchParams.set('status', status);

        $.get(url.toString(), function(data) {
            $(containerSelector).html($(data).find(containerSelector).html());
        });
    });
};
