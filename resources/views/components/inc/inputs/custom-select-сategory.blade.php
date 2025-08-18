<div class="custom-select-wrapper" onclick="this.classList.toggle('active')" >
    <div class="custom-select" data-value="{{ $default['value'] ?? ($values[0]['value'] ?? '') }}">
        {{ $default['title'] ?? ($values[0]['title'] ?? '') }}
    </div>
    <img src="/images/icons/arrow-bottom.svg" alt="" class="custom-select-arrow">
</div>
<div class="custom-select-options">
    <div class="custom-select-options-scrollable">
        @dd($values)
        @foreach ($values as $item)
            <div class="custom-select-option" data-value="{{ $item['value'] }}">
                {{ $item['title'] }}
            </div>
        @endforeach
    </div>
</div>
<select name="{{$name}}" class="form-control select">
	<option value="{{ $default['value'] ?? ($values[0]['value'] ?? '') }}"></option>
</select>

