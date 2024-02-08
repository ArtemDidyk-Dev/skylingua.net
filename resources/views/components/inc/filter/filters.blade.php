@php($minPrice = (int) (isset($filter['minPrice']) && $filter['minPrice'] > 0 ? $filter['minPrice'] : $minMaxPrice['minPrice']))
@php($maxPrice = (int) (isset($filter['maxPrice']) && $filter['maxPrice'] > 0 ? $filter['maxPrice'] : $minMaxPrice['maxPrice']))

<form class="filters" action="{{ $action }}" method="GET" data-min="{{ $minPrice }}"
    data-max="{{ $maxPrice }}">
    <h3 class="filters-title h3">
        {{ language('Filters') }}
    </h3>
    @if ($filter)
        <a class="clear-all" href="{{ $route }}">{{ language('Clear All') }}</a>
    @endif
    <div class="filters-input-wrapper">
        <div class="filters-input-price">
            <x-inc.inputs.input label="Keywords">
                <x-inc.inputs.text name="keyword" placeholder="{{ language('Enter Keywords') }}"
                    value="{{ isset($filter['keyword']) && is_array($filter) ? $filter['keyword'] : '' }}" />
            </x-inc.inputs.input>
        </div>
    </div>

    @if ($countries)
        <div class="filters-input-wrapper">
            <x-inc.inputs.input label="{{ language('Location') }}">
                <x-inc.inputs.custom-select :default="[
                    'title' => $firstElementCountry->name ?? language('Select Country'),
                    'value' => $firstElementCountry->id ?? '',
                    'index' => 0
                ]" :values="$selectCountries" name="country" />
            </x-inc.inputs.input>
        </div>
    @endif
 
    <div class="filters-input-wrapper">
        <x-inc.inputs.input label="{{ language('Category') }}">
            <x-inc.inputs.custom-select :default="[
                'title' => $firstElementCategory->name ?? language('Select Category'),
                'value' => $firstElementCategory->id ?? '',
                'index' => 1
            ]" :values="$selectCategories" name="user_category" />
        </x-inc.inputs.input>
    </div>


    <div class="filters-input-prices">
        <div class="filters-input-price">
            <x-inc.inputs.input label="Min price, $">
                <x-inc.inputs.text value="{{ $minPrice }}" attribute="data-minPrice" name="minPrice" />
            </x-inc.inputs.input>
        </div>
        <div class="filters-input-price">
            <x-inc.inputs.input label="Max price, $">
                <x-inc.inputs.text value="{{ $maxPrice }}" attribute="data-maxPrice" name="maxPrice" />
            </x-inc.inputs.input>
        </div>
    </div>
    <div id="price-slider" class="price-slider"></div>
    <x-inc.btns.filter color="purple" title="Search" />
</form>
