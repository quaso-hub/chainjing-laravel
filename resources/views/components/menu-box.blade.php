@props(['route', 'label', 'icon'])

<a href="{{ route($route) }}" class="card card-stats card-round text-decoration-none text-dark h-100">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-3 text-center">
                <div class="icon-big text-center text-primary">
                    <i class="{{ $icon }}"></i>
                </div>
            </div>
            <div class="col-9 col-stats">
                <div class="numbers">
                    <h5 class="font-weight-bold">{{ $label }}</h5>
                </div>
            </div>
        </div>
    </div>
</a>
