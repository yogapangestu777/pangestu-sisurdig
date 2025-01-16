<!DOCTYPE html>
<html lang="en">

    <head>
        @include('partials.admin._meta')
        @include('partials.admin._css')
        @yield('styles')
        @notifyCss
        {!! ReCaptcha::htmlScriptTagJsApi() !!}
    </head>

    <body class="nk-body npc-crypto bg-white pg-auth">
        @include('notify::components.notify')
        @yield('app')
        @include('partials.admin._js')
        @yield('scripts')
        @notifyJs
    </body>

</html>
