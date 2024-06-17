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
    <div class="txt-dashboard mt-3">
        <h2>DATA DOKUMEN PERMOHONAN</h2>
    </div>
    <div class="col-lg-12 mb-5">
        <div class="card">
            <div class="card-body mt-2">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pencipta</th>
                            <th>Uraian Cipta</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getDataDokumen as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_pencipta }}</td>
                            <td>{{ $item->uraian_cipta }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-detail-form"
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama_pencipta }}"
                                        data-wn="{{ $item->wn_pencipta }}" data-alamat="{{ $item->alamat_pencipta }}"
                                        data-email="{{ $item->email_pencipta }}" data-hp="{{ $item->no_hp_pencipta }}"
                                        data-namapghak="{{ $item->nama_pg_hak }}" data-wnpghak="{{ $item->wn_pg_hak }}"
                                        data-alamatpghak="{{ $item->alamat_pg_hak }}"
                                        data-emailpghak="{{ $item->email_pg_hak }}"
                                        data-jenis="{{ $item->jenis_cipta }}" data-tgl="{{ $item->tgl_tempat }}"
                                        data-uraian="{{ $item->uraian_cipta }}" data-bs-toggle="modal"
                                        data-bs-target="#basicModal">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning text-white btn-edit-pencipta"
                                        style="margin-left: 5px;" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama_pencipta }}" data-wn="{{ $item->wn_pencipta }}"
                                        data-alamat="{{ $item->alamat_pencipta }}"
                                        data-email="{{ $item->email_pencipta }}" data-hp="{{ $item->no_hp_pencipta }}"
                                        data-namapghak="{{ $item->nama_pg_hak }}" data-wnpghak="{{ $item->wn_pg_hak }}"
                                        data-alamatpghak="{{ $item->alamat_pg_hak }}"
                                        data-emailpghak="{{ $item->email_pg_hak }}"
                                        data-jenis="{{ $item->jenis_cipta }}" data-tgl="{{ $item->tgl_tempat }}"
                                        data-uraian="{{ $item->uraian_cipta }}">
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
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Detail content will be inserted here -->
                    <div id="detail-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->
