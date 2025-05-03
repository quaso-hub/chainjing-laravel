<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $labelledby }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="{{ $formId }}" action="{{ $action }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $labelledby }}">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
