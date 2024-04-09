@extends('layout.mainLayout')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Hasil OCR</h1>
    </div>
    <div class="txt-dashboard">
        <h2>Hasil Teks:</h2>
        @if (isset($parsedText))
        <p>{{ $parsedText }}</p>
        @elseif (isset($error))
        <p>Error: {{ $error }}</p>
        @else
        <p>Error: Hasil OCR tidak tersedia.</p>
        @endif
    </div>
</main>
@endsection
