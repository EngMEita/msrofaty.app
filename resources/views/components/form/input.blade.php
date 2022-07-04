@props(['id', 'name', 'type' => 'text', 'title', 'required' => 'no', 'value' => ''])
@php
$id ??= 'id_' . rand();
$name ??= 'fld_' . rand();
@endphp
<div class="row">
    <div class="offset-3 col-2">
        <label for="{{ $id }}">{{ $title }}</label>
    </div>
    <div class="col-4 mb-3">
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
            class="form-control @error($name) is-invalid @enderror" value="{{ old($name, $value) }}"
            @if ($required == 'yes') required @endif placeholder="{{ $title }}">
    </div>
</div>
@error($name)
    <div class="alert alert-danger">خطأ بـ "{{$title}}"</div>
@enderror
