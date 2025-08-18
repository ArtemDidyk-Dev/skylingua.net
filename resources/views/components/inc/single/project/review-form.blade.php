<form action="{{ route('frontend.service.store-comment', [$projectId, $toId]) }}" class="review-form" method="POST">
    @csrf
    <span>Add a Review</span>
    <div class="promo__item-ratings">
        <div class="promo__recall-rating">
            <div class="promo__rating-inner">
                <div class="promo__rating-active" style="width: 100%;"></div>
                <div rating="1" class="promo__rating-items">
                    <input type="radio" class="promo__rating-item" value="1" name="rating">
                    <input type="radio" class="promo__rating-item" value="2" name="rating">
                    <input type="radio" class="promo__rating-item" value="3" name="rating">
                    <input type="radio" class="promo__rating-item" value="4" name="rating">
                    <input type="radio" class="promo__rating-item" value="5" name="rating">
                </div>
            </div>
            <div class="promo__rating-value">5.0</div>
        </div>
    </div>
    <div class="review-form-box">
        <div class="review-form-input">
            <x-inc.inputs.input>
                <x-inc.inputs.text  name="name" placeholder="{{ language('Name*') }}"/>
            </x-inc.inputs.input>
        </div>
        <div class="review-form-input">
            <x-inc.inputs.input>
                <x-inc.inputs.text name="email" placeholder="{{ language('Email*') }}"/>
            </x-inc.inputs.input>
        </div>
        <div class="review-form-input-text">
            <x-inc.inputs.input>
                <x-inc.inputs.textarea placeholder="{{ language('Message') }}"
                                       name="message"/>
            </x-inc.inputs.input>
        </div>
        <x-inc.btns.filter color="black" title="submit review"/>
    </div>
    <div class="review-form__result"></div>

</form>
