<!DOCTYPE html>
<html lang="en">

    <head>
        @include('partials.admin._meta')
        @include('partials.admin._css')
        @yield('styles')
        @notifyCss
    </head>

    <body class="nk-body bg-white has-sidebar ">
        @include('notify::components.notify')
        <div class="nk-app-root">
            <div class="nk-main ">
                @include('partials.admin._sidebar')
                <div class="nk-wrap ">
                    @include('partials.admin._header')
                    @yield('app')
                    @include('partials.admin._footer')
                </div>
            </div>
        </div>
        @include('partials.admin._js')
        @yield('scripts')
        @notifyJs
    </body>

</html>
