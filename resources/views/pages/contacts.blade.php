<x-layout>

    <section class="contacts">
        <div class="container">
            <x-inc.breadcrumbs :items="[
                [
                    'title' => 'Contacts',
                    'link' => '/',
                ],
            ]" />
            <div class="contacts__wrapper">
                <form action="{{ route('frontend.home.contactSendAjax') }}" method="POST" class="contacts-form">
                    @csrf
                    <h2>
                        {{ language('Send us a message') }}
                    </h2>
                    <p>If you have questions or suggestions, leave your details and we will contact you</p>
                    <div class="contacts-form__top">
                        <div class="contacts-form__top-element contacts-form-input-sm">
                            <x-inc.inputs.input >
                                <x-inc.inputs.text name="name" placeholder="{{ language('Name*') }}" />
                            </x-inc.inputs.input>
                        </div>
                        <div class="contacts-form__top-element contacts-form-input-sm">
                            <x-inc.inputs.input >
                                <x-inc.inputs.text name="email" placeholder="{{ language('Email*') }}" />
                            </x-inc.inputs.input>
                        </div>
                        <div class="contacts-form__top-element contacts-form-input">
                            <x-inc.inputs.input >
                                <x-inc.inputs.text placeholder="{{ language('Subject') }}" name="subject" />
                            </x-inc.inputs.input>
                        </div>
                    </div>
                    <div class="contacts-form__bottom">
                        <div class="contacts-form__top-element contacts-form-input">
                            <x-inc.inputs.input >
                                <x-inc.inputs.textarea placeholder="{{ language('Message') }}"
                                                       name="message" />
                            </x-inc.inputs.input>
                        </div>
                    </div>
                    <x-inc.btns.filter color="black" title="send a message" />

                    <div class="result"></div>
                </form>
                <div class="contacts__left">
                    <h1 class="contacts__info-title">
                        {{ language('Love to hear from you, get in touch') }}
                    </h1>
                    <div class="contacts__info-subtitle">
                        Contact us today to access reliable and trusted services. You can reach us at:
                    </div>
                    @if (!empty(setting('address', true)))
                        <a href="{{ setting('map') }}" class="contacts__info-line">
                            <img src="{{ asset('/images/icons/contacts-location.svg') }}" alt="" class="contacts__info-line-img">
                            <div class="contacts__info-line-text contacts">
                                {{ setting('address', true) }}
                            </div>
                        </a>
                    @endif
                    @if (!empty(setting('email')))
                        <a href="mailto:{{ setting('email') }}" class="contacts__info-line">
                            <img src="{{ asset('build/website/images/icons/contacts-email-white.svg') }}" alt="" class="contacts__info-line-img">
                            <div class="contacts__info-line-text contacts">
                                {{ setting('email') }}
                            </div>
                        </a>
                    @endif
                    <div class="footer__left-social">
                        @if (!empty(json_decode(setting('social'))))
                            @foreach (json_decode(setting('social')) as $key => $value)
                                <a href="{{ $value->link }}" target="_blank" rel="nofollow" class="footer-social-link">
                                    <img  loading="lazy" src="/images/icons/{{ $value->name }}-white.svg" alt="{{ $value->name }}"
                                          class="footer-social-link-img">
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>


    @push('meta')
        <title>
            {{ empty(language('frontend.contact.title')) ? language('frontend.contact.name') : language('frontend.contact.title') }}
        </title>
        <meta name="description" content="{{ language('frontend.contact.description') }}">
        <meta name="keywords" content="{{ language('frontend.contact.keywords') }}">
    @endPush


</x-layout>
