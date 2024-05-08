@include('layout.head')

<body style="background-image: url('img/background.png'); background-size: cover;">
    @include('layout.header')
    @include('layout.aside')
    {!! isset($view_file) ? $view_file : '' !!}
    {{-- @yield('content') --}}
    @include('layout.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
            <script src="{{ asset('js/jQuery.js') }}"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('layout.scripts')
    @yield('scripts')
    @if (isset($js))
    <script src="{{ asset($js) }}"></script>
    @endif

</body>

</html>
