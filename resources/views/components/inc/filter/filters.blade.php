@php($minPrice = (int) (isset($filter['minPrice']) && $filter['minPrice'] > 0 ? $filter['minPrice'] : $minMaxPrice['minPrice']))
@php($maxPrice = (int) (isset($filter['maxPrice']) && $filter['maxPrice'] > 0 ? $filter['maxPrice'] : $minMaxPrice['maxPrice']))

<form class="filters" action="{{ $action }}" method="GET" data-min="{{ $minPrice }}"
      data-max="{{ $maxPrice }}">
    <div class="filters__content">
        <div class="filters__top">
            <img width="22" height="22" src="{{ asset('build/website/images/filter.png') }}"
                 alt="filter">
            <h3 class="filters-title h3">
                {{ language('Filters') }}
            </h3>
        </div>
        <div class="filters__content-element">
            @if ($filter)
                <a class="clear-all" href="{{ $route }}">{{ language('Clear All') }}</a>
            @endif
            <div class="filters-input-wrapper">
                <div class="filters-input-price">
                    <x-inc.inputs.input label="">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M3.59993 8.09932C3.59993 6.90584 4.07403 5.76125 4.91795 4.91734C5.76186 4.07342 6.90645 3.59932 8.09993 3.59932C9.2934 3.59932 10.438 4.07342 11.2819 4.91734C12.1258 5.76125 12.5999 6.90584 12.5999 8.09932C12.5999 9.29279 12.1258 10.4374 11.2819 11.2813C10.438 12.1252 9.2934 12.5993 8.09993 12.5993C6.90645 12.5993 5.76186 12.1252 4.91795 11.2813C4.07403 10.4374 3.59993 9.29279 3.59993 8.09932ZM8.09993 1.79932C7.10168 1.79932 6.11772 2.03653 5.22914 2.49141C4.34056 2.9463 3.57279 3.60582 2.9891 4.41564C2.40542 5.22546 2.02253 6.16239 1.87198 7.14922C1.72144 8.13605 1.80755 9.14453 2.12322 10.0916C2.4389 11.0386 2.97509 11.897 3.68763 12.5962C4.40016 13.2953 5.26863 13.8151 6.22147 14.1128C7.17431 14.4104 8.18424 14.4774 9.16804 14.3081C10.1518 14.1389 11.0813 13.7383 11.8799 13.1393C11.9055 13.1734 11.9335 13.2055 11.9636 13.2356L14.6636 15.9356C14.8334 16.0996 15.0607 16.1903 15.2967 16.1882C15.5327 16.1862 15.7584 16.0915 15.9253 15.9247C16.0921 15.7578 16.1868 15.5321 16.1888 15.2961C16.1909 15.0601 16.1002 14.8328 15.9362 14.663L13.2362 11.963C13.2062 11.9329 13.174 11.9049 13.1399 11.8793C13.8419 10.9433 14.2694 9.83035 14.3745 8.66509C14.4795 7.49983 14.2581 6.32834 13.7348 5.28187C13.2116 4.2354 12.4073 3.35531 11.412 2.74022C10.4168 2.12512 9.26991 1.79932 8.09993 1.79932Z"
                                  fill="#0B2E3D"/>
                        </svg>
                        <x-inc.inputs.text class="price" name="keyword" placeholder="{{ language('Search here...') }}"
                                           value="{{ isset($filter['keyword']) && is_array($filter) ? $filter['keyword'] : '' }}"/>
                    </x-inc.inputs.input>
                </div>
            </div>


            <div class="filters-input-wrapper">
                <x-inc.inputs.category title="{{ language('Categories') }}"
                                       :categoryActive="$filter['user_category'] ?? ''" :default="[
            ]" :values="$selectCategories" name="user_category"/>

            </div>
            <div class="filters-input-prices">
                <div class="filters-input-price">
                    <x-inc.inputs.input label="Min price, $">
                        <x-inc.inputs.text value="{{ $minPrice }}" attribute="data-minPrice" name="minPrice"/>
                    </x-inc.inputs.input>
                </div>
                <div class="filters-input-price">
                    <x-inc.inputs.input label="Max price, $">
                        <x-inc.inputs.text value="{{ $maxPrice }}" attribute="data-maxPrice" name="maxPrice"/>
                    </x-inc.inputs.input>
                </div>
            </div>
            <div id="price-slider" class="price-slider"></div>
            <x-inc.btns.filter color="purple" title="Search"/>
        </div>
    </div>
</form>
