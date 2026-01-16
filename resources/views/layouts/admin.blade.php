<main class="main-content">
    
    <x-navigation title="Administration" />

    <div class="content-wrapper">
        @if(session('success')) <x-alert type="success">{{ session('success') }}</x-alert> @endif
        @if(session('error'))   <x-alert type="error">{{ session('error') }}</x-alert>   @endif

        @yield('content')
    </div>

    <x-footer />

</main>