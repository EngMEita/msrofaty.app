<form {{ $attributes->merge(['method' => 'POST']) }}>
    @method($attributes->get('data-method') ?? 'POST')
    @csrf
    {{$slot}}
</form>
