<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $data[0]['cardTitle'] }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $data[0]['title'] }}</li>
            </ol>
        </nav>
    </div>
    <div class="float-end status-section alert alert-info" role="alert">
        <ul>
            <li>
                <small class="text-black">❌ Data belum tersimpan didatabase</small>
            </li>
            <li>
                <small class="text-black">✔️ Data sudah tersimpan didatabase</small>
            </li>
        </ul>
    </div>
    <div class="txt-dashboard">
        <h2>BERKAS DOKUMEN</h2>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body mt-2">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['nik'] ?? '' }}</td>
                            <td>{{ $item['nama'] ?? '' }}</td>
                            <td>
                                @if(isset($item['is_saved']) && $item['is_saved'])
                                <span style="color: green;">✔️</span>
                                @else
                                <span style="color: red;">❌</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-detail" data-nik="{{ $item['nik'] ?? '' }}"
                                        data-nama="{{ $item['nama'] ?? '' }}"
                                        data-alamat="{{ $item['addressDetails']['alamat'] ?? '' }}">Detail</button>
                                    <button class="btn btn-danger btn-delete" style="margin-left: 5px;">Hapus</button>
                                </div>
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input check-item"
                                    value="{{ isset($item['id']) ? 'id_' . $item['id'] : 'nik_' . $item['nik'] }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3 float-end">
                    <button id="submitAllBtn" class="btn btn-primary mb-3">Submit All Data</button>
                    <button id="submitAllBtnCheck" class="btn btn-primary mb-3">Submit All Data Checklist</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 float-end">
        <form id="detailForm" action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="detailId" name="id">
        </form>
    </div>
</main>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let data = @json($data);

        document.getElementById('submitAllBtn').addEventListener('click', function () {
            sendData(false);
        });

        document.getElementById('submitAllBtnCheck').addEventListener('click', function () {
            sendData(true);
        });

        function sendData(checklistOnly) {
            let xData = [];
            let checkedItems = Array.from(document.querySelectorAll('.check-item:checked'));

            if (checklistOnly && checkedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih setidaknya satu item untuk di-submit.'
                });
                return;
            }

            data.forEach(item => {
                let itemId = item['id'] ? 'id_' + item['id'] : 'nik_' + item['nik'];
                if (!checklistOnly || checkedItems.some(el => el.value === itemId)) {
                    let alamat = (item['addressDetails'] && item['addressDetails']['alamat']) ? item['addressDetails']['alamat'] : '';

                    xData.push({
                        id: item['id'] ?? '',
                        found: item['is_saved'] || false,
                        nama: item['nama'] ?? '',
                        nik: item['nik'] ?? '',
                        alamat: alamat,
                    });
                }
            });
            $.ajax({
                url: "{{ route('submit-all-ktp') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    x_data: xData
                }),
                success: function (data) {
                    if (data.status === 'success') {
                        let message = 'Data berhasil disimpan.<br>';
                        if (data.updated_count > 0) {
                            message += ' Data yang diperbarui: ' + data.updated_count + '<br>';
                        }
                        if (data.new_count > 0) {
                            message += ' Data baru ditambahkan: ' + data.new_count;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: message
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim permintaan.'
                    });
                }
            });
        }
    });
</script>
@endsection
