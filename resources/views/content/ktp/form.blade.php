@extends('layout.mainLayout')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Masukkan Foto KTP</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
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
                <form id="pdfForm" action="{{ route('scancard') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="formFile" style="color: white" class="form-label mt-3 mb-3">Masukan File Foto KTP
                        disini</label>
                    <input class="form-control" name="image" type="file" accept="image/*" id="formFile">
                </form>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection

{{-- @extends('layout.mainLayout')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Masukkan Surat Permohonan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
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
                <form id="formFile" action="{{ route('scancard') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="formFile" style="color: white" class="form-label mt-3 mb-3">Masukan File Surat
                        Permohonan disini</label>
                    <input class="form-control image" name="image" type="file" accept="image/*" id="formFile">
                    <input type="hidden" name="image_base64">
                    <div class="image-container" style="max-width: 400px;">
                        <img class="show-image" id="selectedImage" src="#" alt="Selected Image"
                            style="max-width: 100%; height: auto; display: none;">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection --}}

