window.handleAjaxFormSubmit = function (formId, onSuccessMessage = 'Berhasil!', onSuccessCallback = () => location.reload()) {
    const $form = $(`#${formId}`);
    $form.on('submit', function (e) {
        e.preventDefault();
        const action = $form.attr('action');
        // const method = $form.find('input[name="_method"]').val() || 'POST';

        $.ajax({
            url: action,
            method: 'POST',
            data: $form.serialize(),
            success: function () {
                $('.modal').modal('hide');
                Swal.fire(onSuccessMessage, '', 'success').then(onSuccessCallback);
            },
            error: function () {
                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
            }
        });
    });
};



window.confirmDeleteAjax = function (url, onSuccessMessage = 'Data berhasil dihapus.', onSuccessCallback = () => location.reload()) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    Swal.fire('Terhapus!', onSuccessMessage, 'success').then(onSuccessCallback);
                },
                error: function () {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            });
        }
    });
};
