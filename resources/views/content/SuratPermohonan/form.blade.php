<main id="main" class="main">
    <div class="pagetitle">
        <h1>Masukkan Surat Permohonan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $data['title'] }}</li>
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
                    <label for="formFile" style="color: white" class="form-label mt-3 mb-3">Masukan File Surat
                        Permohonan
                        disini</label>
                    <input class="form-control" name="pdf_file" type="file" id="formFile">
                </form>
            </div>
        </div>
    </div>
    </div>
</main><!-- End #main -->
