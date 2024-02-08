<x-layout>

    <section class="contacts section">
        <div class="container">
            <x-inc.breadcrumbs :items="[
                [
                    'title' => 'Contacts',
                    'link' => '/',
                ],
            ]" />
            <div class="contacts__wrapper">
                <div class="contacts__wrapper-left">
                    <h2 class="contacts__info-title">
                        {{ language('general.contact') }}
                    </h2>
                    <div class="contacts__info-subtitle">
                        Do you have any questions? Just write us a message!
                    </div>
                    <form action="{{ route('frontend.home.contactSendAjax') }}" method="POST" class="contacts-form">
                        @csrf
                        <div class="contacts-form__top">
                            <div class="contacts-form__top-element contacts-form-input-sm">
                                <x-inc.inputs.input label="Name">
                                    <x-inc.inputs.text name="name"
                                        placeholder="{{ language('frontend.contact.your_name') }}" />
                                </x-inc.inputs.input>
                            </div>
                            <div class="contacts-form__top-element contacts-form-input-sm">
                                <x-inc.inputs.input label="Email">
                                    <x-inc.inputs.text name="email"
                                        placeholder="{{ language('frontend.contact.your_email') }}" />
                                </x-inc.inputs.input>
                            </div>
                            <div class="contacts-form__top-element contacts-form-input">
                                <x-inc.inputs.input label="Subject">
                                    <x-inc.inputs.text placeholder="{{ language('frontend.contact.your_subject') }}"
                                        name="subject" />
                                </x-inc.inputs.input>
                            </div>
                        </div>
                        <div class="contacts-form__bottom">
                            <div class="contacts-form__top-element contacts-form-input">
                                <x-inc.inputs.input label="Message">
                                    <x-inc.inputs.textarea placeholder="{{ language('frontend.contact.your_message') }}"
                                        name="message" />
                                </x-inc.inputs.input>
                            </div>
                            <x-inc.btns.filter color="black" title="Send message" />
                        </div>

                        <div class="result"></div>
                    </form>
                </div>
                <div class="contacts__wrapper-right">
                    @if (!empty(setting('address', true)))
                        <a href="{{ setting('map') }}" class="contacts__info-line">
                            <img src="{{ asset('build/website/images/icons/contacts-location.svg') }}" alt=""
                                class="contacts__info-line-img">
                            <div class="contacts__info-line-text contacts">
                                {{ setting('address', true) }}
                            </div>
                        </a>
                    @endif
                    @if (!empty(setting('email')))
                        <a href="mailto:{{ setting('email') }}" class="contacts__info-line">
                            <img src="{{ asset('build/website/images/icons/contacts-email.svg') }}" alt=""
                                class="contacts__info-line-img">
                            <div class="contacts__info-line-text contacts">
                                {{ setting('email') }}
                            </div>
                        </a>
                    @endif
                    <x-inc.socials class="offset-top" :links="$socials" />
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
