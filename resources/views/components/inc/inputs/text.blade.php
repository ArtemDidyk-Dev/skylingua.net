<input {{ $attribute ?? '' }} name="{{ $name ?? '' }}" type="{{ $type ?? 'text' }}"
    class="input-text {{ $class ?? '' }}" placeholder="{{ $placeholder ?? '' }}" value="{{ $value ?? '' }}"
    {{ $required ?? '' }}  @if (isset($type) && $type == 'number' )
    step="{{ $step ?? 'any' }}"
    min="{{ $min ?? '' }}"
@endif>
