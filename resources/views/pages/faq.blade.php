<x-layout>
    <div class="container">
        <x-inc.breadcrumbs :items="[
            [
                'title' => 'Frequently asked Questions',
                'link' => '/',
            ],
        ]" />
    </div>

    <div class="container">
        <section class="faq page-one">
            <h2>Frequently asked Questions</h2>
            <span class="faq__subtitle">Learn a little more about our services</span>
            <div class="faq__top">
                <x-inc.faq.faq-inner col="first-colum">
                    @foreach ($faq as $item)
                        <x-inc.faq.faq-item col="first-colum" title="{{ $item->title }}" content="{{ $item->content }}" />
                    @endforeach
                </x-inc.faq.faq-inner>
            </div>
        </section>
    </div>

    @push('meta')
        <title>
            {{ empty(language('frontend.faq.title')) ? language('frontend.faq.name') : language('frontend.faq.title') }}
        </title>
        <meta name="description" content="{{ language('frontend.faq.description') }}">
        <meta name="keywords" content="{{ language('frontend.faq.keywords') }}">
    @endPush


</x-layout>
