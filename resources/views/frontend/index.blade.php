@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <div class="col-12 col-md-4 col-lg-3 mx-auto" style="display: flex; flex-direction: column; justify-content: center;">
            <img class="w-100" src="/img/frontend/banner/logo.png" alt="LOGO">
        </div>
        <div class="col-12 col-md-8 col-lg-7 mx-auto px-0" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="w-100">
                <search-engine></search-engine>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-2 mx-auto" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="w-100 bg-color-primary card">
                <div class="card-body p-2">
                    <music-player></music-player>
                </div>
            </div>
        </div>
    </div>

    <div class="row flex-column-reverse flex-md-row my-2">
        <div class="col-12 col-md-12 col-lg-7 mx-auto my-2 px-0">
            <terminal-window></terminal-window>
        </div>

        <div class="col-12 col-lg-4 mx-auto my-2">
            @guest
                <login-tools></login-tools>
            @else
                <login-tools :login="true" avatar="{{ $logged_in_user->picture }}" username="{{ $logged_in_user->name }}" email="{{ $logged_in_user->email }}"></login-tools>
            @endguest

            <label class="mt-2 col-label bg-color-primary color-color-primary">我的工具</label>
            <div class="row mb-2 m-0 p-2 bg-color-primary text-center">
                <div class="col-12 mt-0 mb-1 pr-1 pl-0">
                    <a class="my-2" href="{{ route('frontend.social.cards.create') }}"><img class="w-100" src="/img/frontend/banner/navbar02.png" alt="發表文章"></a>
                </div>
                <div class="col-6 mt-0 mb-1 pr-1 pl-0">
                    <a class="my-2" href="{{ route('frontend.social.cards.review') }}"><img class="w-100" src="/img/frontend/banner/navbar03.png" alt="群眾審核"></a>
                </div>
                <div class="col-6 mt-0 mb-1 pr-1 pl-0">
                    <a class="my-2" href="{{ route('frontend.social.cards.index') }}"><img class="w-100" src="/img/frontend/banner/navbar04.png" alt="文章列表"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('before-styles')
<style>
tr {
    color: var(--color-gray) !important;
}
tr:hover {
    color: var(--font-secondary-color) !important;
}
tr a {
    color: var(--font-primary-color) !important;
}
tr a:hover {
    color: var(--color-info) !important;
}
tr img {
    max-width: 24px;
    max-height: 24px;
    border-radius: 4px;
}
</style>
@endpush
