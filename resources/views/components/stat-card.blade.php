@props(['title', 'value' => '-', 'icon' => '', 'color' => 'primary'])

<div class="card card-stats card-round">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-4 text-center">
                <div class="icon-big text-center text-{{ $color }}">
                    <i class="{{ $icon }}"></i>
                </div>
            </div>
            <div class="col-8 col-stats">
                <div class="numbers">
                    <p class="card-category">{{ $title }}</p>
                    <h4 class="card-title">{{ $value }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
