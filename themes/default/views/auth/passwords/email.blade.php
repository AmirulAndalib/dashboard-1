@extends('layouts.app')

@section('content')

    <body class="hold-transition dark-mode login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="text-center card-header">
                    <a href="{{ route('welcome') }}" class="h1"><b
                            class="mr-1">{{ config('app.name', 'Laravel') }}</b></a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="login-box-msg">
                        {{ __('You forgot your password? Here you can easily retrieve a new password.') }}</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3 input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>

                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      @php ($recaptchaVersion = app(App\Settings\GeneralSettings::class)->recaptcha_version)
                      @if ($recaptchaVersion)
                        <div class="mb-3 input-group">
                          @switch($recaptchaVersion)
                            @case("v2")
                              {!! htmlFormSnippet() !!}
                              @break
                            @case("v3")
                              {!! RecaptchaV3::field('recaptchathree') !!}
                              @break
                            @case("turnstile")
                              <x-turnstile-widget
                                theme="dark"
                                language="en-us"
                                size="normal"
                              />
                              @error('cf-turnstile-response')
                              <p class="error">{{ $message }}</p>
                              @enderror
                              @break
                          @endswitch

                          @error('g-recaptcha-response')
                          <span class="text-danger" role="alert">
                                  <small><strong>{{ $message }}</strong></small>
                                </span>
                          @enderror
                        </div>
                      @endif

                        <div class="row">
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-primary btn-block">{{ __('Request new password') }}</button>
                            </div>

                            <!-- /.col -->
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        {{-- imprint and privacy policy --}}
        <div class="fixed-bottom ">
            <div class="container text-center">
                @php($website_settings = app(App\Settings\WebsiteSettings::class))
                @if ($website_settings->show_imprint)
                    <a target="_blank" href="{{ route('terms', 'imprint') }}"><strong>{{ __('Imprint') }}</strong></a> |
                @endif
                @if ($website_settings->show_privacy)
                    <a target="_blank" href="{{ route('terms', 'privacy') }}"><strong>{{ __('Privacy') }}</strong></a>
                @endif
                @if ($website_settings->show_tos)
                    | <a target="_blank"
                        href="{{ route('terms', 'tos') }}"><strong>{{ __('Terms of Service') }}</strong></a>
                @endif
            </div>
        </div>
    </body>
@endsection
