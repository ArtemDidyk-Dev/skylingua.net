<section class="faq">
    <div class="container">
        <h2>{{ language('frontend.faq.form.title') }}</h2>
        <span class="faq__subtitle">{{ language('frontend.faq.form.text') }}</span>
        <x-inc.faq.faq-inner>
            @foreach ($faq as $item)
                <x-inc.faq.faq-item title="{{ $item->title }}" content="{{ $item->content }}" />
            @endforeach
        </x-inc.faq.faq-inner>

        <div class="faq__bottom">
            <x-inc.btns.all color="blue" title="{{ language('Show more') }}" link="{{ route('frontend.faq.index') }}">
            </x-inc.btns.all>
        </div>
    </div>
</section>
