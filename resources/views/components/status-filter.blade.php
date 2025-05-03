@props(['id' => 'statusFilter', 'options' => []])

<select id="{{ $id }}" class="form-control">
    <option value="">Semua Status</option>
    @foreach($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
