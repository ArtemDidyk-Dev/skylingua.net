<nav class="user-tabs mb-4">
    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.withdraw-money',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.withdraw-money') }}">{{ language('Withdraw Funds') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.transaction-history',
                                                        'frontend.dashboard.freelancer.view-invoice',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.transaction-history') }}">{{ language('Transaction History') }}</a>
        </li>
    </ul>
</nav>
