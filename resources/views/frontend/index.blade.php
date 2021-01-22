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
            <div class="w-100">
                <p>
                    熱門話題:
                    <a class="color-danger" style="text-decoration: underline;" href="https://github.com/init-engineer/init.engineer">純靠北工程師</a>
                    <a class="color-color-primary" style="text-decoration: underline;" href="https://www.google.com/search?q=富王鴨肉">炎上鴨肉飯</a>
                    <a class="color-color-primary" style="text-decoration: underline;" href="https://www.php.net/releases/8.0/en.php">PHP 8 Released</a>
                    <a class="color-color-primary" style="text-decoration: underline;" href="https://www.ruby-lang.org/en/news/2020/12/25/ruby-3-0-0-released">Ruby 3 Released</a>
                    <a class="color-primary" style="text-decoration: underline;" href="https://www.apple.com/tw/mac/m1/">Apple M1 晶片</a>
                    <a class="color-color-primary" style="text-decoration: underline;" href="https://www.cyberpunk.net">電馭叛客 2077</a>
                    <a class="color-primary" style="text-decoration: underline;" href="https://mewe.com/p/initkobeengineer">移民去 MeWe</a>
                </p>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-2 mx-auto" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="w-100 bg-color-primary card">
                <div class="d-none card-body p-2">
                    <p class="card-text">不習慣新介面嗎？如果需要，您可以透過我們的時光機，切換成經典版純靠北工程師。</p>
                    <button class="btn btn-block btn-primary-bg" onclick="Swal.fire('噢哦！', '版主並沒有寫「切換回經典版 純靠北工程師」的功能。', 'warning');">我想回去舊版頁面</button>
                </div>
                <div class="card-body p-2">
                    <music-player></music-player>
                </div>
            </div>
        </div>
    </div>

    <div class="row flex-column-reverse flex-md-row my-2">
        <div class="d-none col-12 col-md-4 col-lg-2 mx-auto my-2">
            <music-player></music-player>

            <label class="d-none col-label bg-color-primary color-color-primary">《近日熱門文章》</label>
            <div class="d-none w-100 mb-2 bg-color-primary">
                <a href="https://kaobei.engineer/cards/show/5689">
                    <img class="p-2 w-100" src="https://kaobei.engineer/storage/cards/images/tR1TNYuaKCJ2rMVOoHmVvyhm4EV0CdJiASLbrrJzwweaRZHjO8oRGsQSHvEZG1uSfso01FTytTn6FmzjZ6WbpfNMc0At8lSVPDcpYo7jEB3rKWgKFTzS57mnR8qqNdgQ.jpeg">
                </a>
            </div>

            <bulletin-board class="d-none"></bulletin-board>
        </div>
        <div class="col-12 col-md-12 col-lg-7 mx-auto my-2 px-0">
            <label class="d-none col-label bg-color-primary color-color-primary">快捷選單</label>
            <div class="d-none w-100 bg-color-primary">
                <table class="table table-sm table-hover color-color-primary">
                    <tbody>
                        <tr><th scope="row" style="border-top: 0px; border-bottom: 1px solid var(--font-primary-color);">
                            ["平台功能":[
                            "<a class="color-warning" href="{{ route('frontend.animal.index') }}">大頭菜計算機</a>",&nbsp;
                            "<a class="color-warning" href="{{ route('frontend.social.cards.create') }}">發表文章</a>",&nbsp;
                            "<a class="color-warning" href="{{ route('frontend.social.cards.review') }}">群眾審核</a>",&nbsp;
                            "<a class="color-warning" href="{{ route('frontend.social.cards.index') }}">文章列表</a>"]]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["研討會":[
                            "<a href="https://mopcon.org"><img src="https://t.kfs.io/upload_images/102093/Image_from_iOS_original.jpg" alt=""> MOPCON</a>",&nbsp;
                            "<a href="https://sitcon.org"><img src="https://sitcon.org/2016/image/stone.png" alt="sitcon"> SITCON</a>",&nbsp;
                            "<a href="https://hitcon.org"><img src="https://ctf.hitcon.org/img/og_img.png" alt="hitcon"> HITCON</a>",&nbsp;
                            "<a href="https://coscup.org"><img src="https://coscup.org/2019/avatar.jpg" alt="coscup"> COSCUP</a>"]]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["臉書社團":[
                            "<a href="https://www.facebook.com/groups/1182255762153380"><img src="https://scontent.fkhh1-1.fna.fbcdn.net/v/t1.0-9/117382620_882376012294771_230083542757351495_o.jpg?_nc_cat=103&ccb=2&_nc_sid=825194&_nc_ohc=PKdl6pl9BBYAX-B73DA&_nc_ht=scontent.fkhh1-1.fna&oh=f92f8e0dde95b34b827ce1a268c1b3d1&oe=600F82E1" alt=""> 程式語言讀書會</a>",&nbsp;
                            "<a href="https://www.facebook.com/groups/kaobei.engineer"><img src="https://scontent.fkhh1-1.fna.fbcdn.net/v/t1.0-9/p960x960/126900516_963381837527521_8778510908854194782_o.jpg?_nc_cat=102&ccb=2&_nc_sid=825194&_nc_ohc=vbS-sevn90kAX9UvhN2&_nc_ht=scontent.fkhh1-1.fna&tp=6&oh=2e0772124bcf43a405b5ffcbfedabc99&oe=600E82E4" alt=""> 純靠北工程師 同溫層</a>",&nbsp;
                            "<a href="https://www.facebook.com/groups/616369245163622"><img src="https://scontent.fkhh1-1.fna.fbcdn.net/v/t31.0-0/p180x540/12419361_10153759937808955_3887148722139652033_o.jpg?_nc_cat=100&ccb=2&_nc_sid=825194&_nc_ohc=W7d9v4_jMrgAX8X8FU2&_nc_ht=scontent.fkhh1-1.fna&tp=6&oh=2f78ff7e2ee4ffd35fc0c7cc902db394&oe=600CC7EB" alt=""> Backend 台灣</a>"]]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["瀏覽器":[
                            "<a href="https://www.mozilla.org/zh-TW/firefox/new"><img src="https://www.flaticon.com/svg/static/icons/svg/183/183320.svg" alt="firefox"> Firefox</a>",&nbsp;
                            "<a href="https://www.google.com/intl/zh-TW/chrome"><img src="https://www.flaticon.com/svg/static/icons/svg/183/183316.svg" alt="chrome"> Chrome</a>",&nbsp;
                            "<a href="https://www.opera.com/zh-cn"><img src="https://www.flaticon.com/svg/static/icons/svg/732/732233.svg" alt="opera"> Opera</a>",&nbsp;
                            "<a href="https://brave.com/zh"><img src="https://brave.com/wp-content/uploads/2019/03/brave-logo.png" alt="brave"> Brave</a>"]]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["undefined": null]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["undefined": null]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["undefined": null]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["undefined": null]
                        </th></tr>
                        <tr><th scope="row" style="border-top: 0px;">
                            ["undefined": null]
                        </th></tr>
                    </tbody>
                </table>
            </div>

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
                <div class="d-none col-6 mt-0 mb-1 pr-1 pl-0">
                    <a class="my-2" href="{{ route('frontend.fortunes.index') }}"><img class="w-100" src="/img/frontend/banner/navbar05.png" alt="線上抽籤系統"></a>
                </div>
                <div class="d-none col-6 mt-0 mb-1 pr-1 pl-0">
                    <a class="my-2" href="{{ route('frontend.animal.index') }}"><img class="w-100" src="/img/frontend/banner/navbar01.png" alt="大頭菜計算機"></a>
                </div>
            </div>

            <financial-status class="d-none"></financial-status>
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
