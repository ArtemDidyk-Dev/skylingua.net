<!DOCTYPE html>
<html lang="{{ request('currentLang') }}">
<head>
@include('frontend.layouts.partials.head')
</head>
@if(Route::is(['frontend.home.index']))
<body class="home-page">
@endif

{{--@if(Route::is(['frontend.dashboard.chats']))--}}
{{--    <body class="chat-page">--}}
{{--@endif--}}

@if(Route::is([
'frontend.dashboard.chats',
'frontend.dashboard.change-password',
'frontend.dashboard.delete-account',

'frontend.dashboard.employer',
'frontend.dashboard.employer.projects-all',
'frontend.dashboard.employer.projects-pending',
'frontend.dashboard.employer.projects-ongoing',
'frontend.dashboard.employer.projects-completed',
'frontend.dashboard.employer.projects-cancelled',
'frontend.dashboard.employer.project.proposals',
'frontend.dashboard.employer.favourites',
'frontend.dashboard.employer.review',
'frontend.dashboard.employer.membership-plans',
'frontend.dashboard.employer.milestones',
'frontend.dashboard.employer.verify-identity',
'frontend.dashboard.employer.deposit-funds',
'frontend.dashboard.employer.profile-settings',

'frontend.dashboard.freelancer',
'frontend.dashboard.freelancer.project-proposals',
'frontend.dashboard.freelancer.project-ongoing',
'frontend.dashboard.freelancer.project-completed',
'frontend.dashboard.freelancer.project-cancelled',
'frontend.dashboard.freelancer.project-detail',
'frontend.dashboard.freelancer.project-hireds',
'frontend.dashboard.freelancer.favourites',
'frontend.dashboard.freelancer.reviews',
'frontend.dashboard.freelancer.portfolio',
'frontend.dashboard.freelancer.membership',
'frontend.dashboard.freelancer.verify-identity',
'frontend.dashboard.freelancer.withdraw-money',

'frontend.dashboard.freelancer.pay.bank.step1',
'frontend.dashboard.freelancer.pay.bank.step2',
'frontend.dashboard.freelancer.pay.bank.stepProgress',
'frontend.dashboard.freelancer.pay.bank.stepSuccess',
'frontend.dashboard.freelancer.pay.bank.stepError',

'frontend.dashboard.freelancer.transaction-history',
'frontend.dashboard.freelancer.view-invoice',
'frontend.dashboard.freelancer.profile-settings',
'frontend.cabinet.notification',

]))
<body class="dashboard-page">
@endif
@if(Route::is([
    'frontend.forgot.index',
    'frontend.login.index',
    'frontend.cabinet.register',
    'frontend.cabinet.success',
    'frontend.cabinet.verify',
    'frontend.forgot.success',
    'frontend.forgot.password_resets'
]))
<body class="account-page">
@endif

@include('frontend.layouts.partials.header')

@yield('content')
@if(!Route::is(['frontend.dashboard.chats']))
@include('frontend.layouts.partials.footer')
@endif
@include('frontend.layouts.partials.footer-scripts')
</body>
</html>
