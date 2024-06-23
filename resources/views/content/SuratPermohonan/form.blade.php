<main id="main" class="main">
    <div class="float-end status-section">
        <ul>
            <small class=""> ✔️ File Support PDF</small>
        </ul>
    </div>
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
                <label style="color: white" class="form-label mt-3 mb-3 text-center">Masukan File Dokumen Permohonan
                    disini</label>
                <div class=" input-group">
                    <button class="btn btn-primary text-white" type="button" id="button-addon1"
                        onclick="DokumenPermohonan.addFileOutTable(this)">
                        Pilih
                    </button>
                    <input onclick="DokumenPermohonan.addFileOutTable(this)" id="file" type="text"
                        class="form-control required" error="File" placeholder="File Document .PDF"
                        aria-label="File Document .PDF" aria-describedby="button-addon1" readonly>
                </div>
                <div class="mt-2">
                    <small class=" text-white">File max upload 2MB</small>
                </div>
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
</main>


@section('scripts')
<script>
    $(document).ready(function() {
        DokumenPermohonan.addFileOutTable();
    });

    let DokumenPermohonan = {
        addFileOutTable: () => {
            var uploader = $('<input type="file" accept="application/pdf" />');
            var src_foto = $('#file');
            uploader.click();

            uploader.on("change", function () {
                var reader = new FileReader();
                reader.onload = function (event) {
                    var files = uploader.get(0).files[0];
                    var filename = files.name;
                    var data_from_file = filename.split(".");
                    var type_file = $.trim(data_from_file[data_from_file.length - 1]);

                    if (type_file == 'pdf') {
                        var data = event.target.result;
                        src_foto.attr("src", data);
                        src_foto.attr("tipe", type_file);
                        src_foto.val(filename);
                        DokumenPermohonan.submit();
                    } else {
                        Swal.fire({
                        icon: 'error',
                        title: 'File tidak valid',
                        text: 'File harus berupa dokumen PDF.',
                        });
                    }
                };

                reader.readAsDataURL(uploader[0].files[0]);
            });
        },

        getPostData: () => {
            let data = {
                'data': {
                    'file': $('input#file').attr('src'),
                    'tipe': $('input#file').attr('tipe'),
                    'file_name': $('input#file').val(),
                },
            };
            return data;
        },

        submit: () => {
            let params = DokumenPermohonan.getPostData();

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process your file.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: params,
                url: '{{ route('parse.pdf') }}',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'File berhasil diproses.',
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ url('/hasil-scan-dokumen') }}/' + response.cacheKey;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal memproses file PDF.<br>Mohon masukan Dokumen file yang benar.',
                            html: 'Gagal memproses file PDF.<br>Mohon masukan Dokumen file yang benar.' ,
                        });
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                      html: xhr.responseJSON ? xhr.responseJSON.error : 'Gagal memproses file PDF.<br>Mohon masukan Dokumen file yang benar.'
                    });
                }
            });
        },
    }
</script>
@endsection
