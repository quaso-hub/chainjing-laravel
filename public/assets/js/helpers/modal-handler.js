/**
 * SweetAlert Delete Confirmation
 * @param {string} selector - Button selector
 */
function handleDelete(selector) {
    document.querySelectorAll(selector).forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
}

/**
 * Prefill Edit Modal Fields
 * @param {string} selector - Button selector
 * @param {string} modalId - Target modal
 * @param {Object} fieldsMap - Mapping field names to input selectors
 */
function handleEditModal(selector, modalId, fieldsMap) {
    document.querySelectorAll(selector).forEach(button => {
        button.addEventListener('click', function () {
            for (const key in fieldsMap) {
                const input = document.querySelector(fieldsMap[key]);
                if (input) input.value = this.dataset[key];
            }

            const form = document.querySelector(`${modalId} form`);
            if (form && this.dataset.id) {
                form.setAttribute('action', `${form.getAttribute('action').replace(/\d*$/, '')}${this.dataset.id}`);
            }
        });
    });
}

const ajaxConfig = {
    error: function(xhr) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            $('.form-text.text-danger').remove();

            for (let field in errors) {
                const input = $(`[name="${field}"]`);
                input.addClass('is-invalid');
                input.after(`<div class="form-text text-danger">${errors[field][0]}</div>`);
            }
        } else {
            Swal.fire('Gagal!', 'Terjadi kesalahan server.', 'error');
        }
    }
};
