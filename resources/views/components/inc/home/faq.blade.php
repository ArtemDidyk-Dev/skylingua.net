<section class="faq">
    <div class="container">
        <h2>Frequently asked Questions</h2>
        <span class="faq__subtitle">Learn a little more about our services</span>
        <x-inc.faq.faq-inner >
            @for ($i = 0; $i < 6; $i++)
                <x-inc.faq.faq-item  title="How can I trust the service providers on your platform?"
                    content="We prioritize the quality and reliability of our service providers. Each professional goes through a thorough screening process before joining our marketplace. This includes verifying their credentials, reviewing their past work experience, and checking client feedback and ratings. We also encourage users to leave reviews and ratings after their projects are completed to maintain transparency and accountability." />
            @endfor
        </x-inc.faq.faq-inner>

        <div class="faq__bottom">
            <x-inc.btns.all color="blue" title="{{ language('Show more') }}" link="/" >
            </x-inc.btns.all>
        </div>
    </div>
</section>
