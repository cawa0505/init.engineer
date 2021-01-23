@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.social.cards.create'))

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col col-12 align-self-center">
                <social-cards-create :is-admin="{{ $logged_in_user->isAdmin()? 1 : 0 }}"></social-cards-create>
            </div><!--col-->

            <div class="col col-12 mt-2 align-self-center">
                <label class="col-label">這裡是 Ads 廣告</label>
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-4188608440091450"
                    data-ad-slot="1792789160"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
            </div><!--col-->
        </div><!--row-->
    </div><!--container-->
@endsection
