<main id="main" class="main">
    <div class="pagetitle">
        <h1>Masukkan Foto KTP</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $data['title'] }}</li>
            </ol>
        </nav>
    </div>
    <div class="txt-dashboard">
        <h2>UPLOAD FILE KTP</h2>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="card mb-3" style="background-color: #5691cc">
            <div class="card-body">
                <form id="formFile" action="{{ route('scancard') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="formFile" style="color: white" class="form-label mt-3 mb-3">Masukan File Foto KTP
                        disini</label>
                    <input class="form-control" name="image" type="file" id="formFile">
                </form>
            </div>
        </div>
    </div>
    <div class="txt-dashboard mt-3">
        <h2>DATA KTP</h2>
    </div>
    <div class="col-lg-12 mb-5">
        <div class="card">
            <div class="card-body mt-2">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getDataKTP as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-detail-form-ktp"
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                        data-nik="{{ $item->nik }}" data-alamat="{{ $item->alamat }}"
                                        data-bs-toggle="modal" data-bs-target="#basicModalKTP">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning text-white btn-edit-form-ktp"
                                        style="margin-left: 5px;" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama }}" data-nik="{{ $item->nik }}"
                                        data-alamat="{{ $item->alamat }}" data-bs-toggle="modal"
                                        data-bs-target="#editModalKTP">
                                        <i class="ri ri-edit-box-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3 float-end">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="basicModalKTP" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Detail content will be inserted here -->
                    <div id="detail-content-ktp"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-3 float-end">
        <form id="editForm" action="{{ route('submit-edit-ktp') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="editId" name="id">
        </form>
    </div>
    {{-- <div>
        <form action="{{ route('upload.signature') }}" method="post" enctype="multipart/form-data">
            <label for="signature">Upload Tanda Tangan:</label>
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </form>

    </div> --}}
</main>
