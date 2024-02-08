@if (!empty($label))
    <div class="input-wrapper-label">
        {{ $label }}
    </div>
@endif
<label class="input-wrapper">
    {{ $slot }}
</label>
