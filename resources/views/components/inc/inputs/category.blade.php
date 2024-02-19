<div class="input category__wrapper">
    <span class="category__wrapper-title">{{ $title }}</span>
    <div class="category__box">

        @foreach ($values as $item)
            <div class="category__item">
                @if ($categoryActive)
                    <input {{ in_array($item->user_category_id, $categoryActive) ? 'checked' : '' }} class="checkbox"
                        type="checkbox" name="project_category[]" value="{{ $item->user_category_id }}" />
                @else
                <input  class="checkbox"
                type="checkbox" name="project_category[]" value="{{ $item->user_category_id }}" />
                @endif

                <span>{{ $item->user_category_name }}</span>
            </div>
        @endforeach
    </div>
</div>
