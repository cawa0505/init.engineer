@if (config('services.bitbucket.active'))
    <a href='{{ route('frontend.auth.social.login', 'bitbucket') }}' class='btn btn-lg btn-block btn-bitbucket rounded border border-w-3 p-2'><i class='fab fa-bitbucket'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'BitBucket'])</a>
@endif

@if (config('services.facebook.active'))
    <a href='{{ route('frontend.auth.social.login', 'facebook') }}' class='btn btn-lg btn-block btn-facebook rounded border border-w-3 p-2'><i class='fab fa-facebook'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'Facebook'])</a>
@endif

@if (config('services.google.active'))
    <a href='{{ route('frontend.auth.social.login', 'google') }}' class='btn btn-lg btn-block btn-google rounded border border-w-3 p-2'><i class='fab fa-google'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'Google'])</a>
@endif

@if (config('services.github.active'))
    <a href='{{ route('frontend.auth.social.login', 'github') }}' class='btn btn-lg btn-block btn-github rounded border border-w-3 p-2'><i class='fab fa-github'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'GitHub'])</a>
@endif

@if (config('services.linkedin.active'))
    <a href='{{ route('frontend.auth.social.login', 'linkedin') }}' class='btn btn-lg btn-block btn-linkedin rounded border border-w-3 p-2'><i class='fab fa-linkedin'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'LinkedIn'])</a>
@endif

@if (config('services.twitter.active'))
    <a href='{{ route('frontend.auth.social.login', 'twitter') }}' class='btn btn-lg btn-block btn-twitter rounded border border-w-3 p-2'><i class='fab fa-twitter'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'Twitter'])</a>
@endif

@if (config('services.mastodon.active'))
    <a href='{{ route('frontend.auth.social.login', 'mastodon') }}' class='btn btn-lg btn-block btn-mastodon rounded border border-w-3 p-2'><i class='fab fa-mastodon'></i> @lang('labels.frontend.auth.login_with', ['social_media' => 'Mastodon'])</a>
@endif