<x-modal
    id="createRUUModal"
    labelledby="createRUUModalLabel"
    title="Tambah RUU"
    formId="formCreateRUU"
    action="{{ route('ruu.store') }}"
    method="POST"
    submitText="Simpan"
>
    {{-- Isi form: --}}
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control form-control-sm" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control form-control-sm" required></textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-control form-control-sm" required>
            <option value="DRAFT">DRAFT</option>
            <option value="VOTING">VOTING</option>
        </select>
    </div>
</x-modal>
