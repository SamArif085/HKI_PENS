@extends('layout.mainLayout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Input Surat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </nav>
        </div>
        <div class="txt-dashboard">
            <h2>BERKAS DOKUMEN</h2>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3" style="background-color: #5691cc">
                <div class="card-body">
                    <form id="pdfForm" action="{{ route('parse.pdf') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="formFile" style="color: white" class="form-label mt-3 mb-3">Masukan File KTP
                            disini</label>
                        <input class="form-control" name="pdf_file" type="file" id="formFile">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main><!-- End #main -->
@endsection
