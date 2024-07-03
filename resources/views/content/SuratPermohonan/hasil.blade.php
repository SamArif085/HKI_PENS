<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $home['cardTitle'] }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $home['title'] }}</li>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-2">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nama Pencipta</th>
                                <th>Uraian Cipta</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($hasilDokumen['data']))
                            @foreach ($hasilDokumen['data'] as $item)
                            <tr>
                                <td>{{ $item['pencipta']['nama'] ?? '' }}</td>
                                <td>{{ $item['uraian_ciptaan'] ?? '' }}</td>
                                <td>
                                    @php
                                    $found = false;
                                    foreach ($existingPencipta as $pencipta) {
                                    if (isset($item['pencipta']['nama']) && isset($pencipta['nama_pencipta']) &&
                                    $pencipta['nama_pencipta'] == $item['pencipta']['nama'] &&
                                    isset($item['uraian_ciptaan']) && isset($pencipta['uraian_cipta']) &&
                                    $pencipta['uraian_cipta'] == $item['uraian_ciptaan']) {
                                    $found = true;
                                    break;
                                    } }
                                    @endphp
                                    @if ($found)
                                    <span style="color: green;">✔️</span>
                                    @else
                                    <span style="color: red;">❌</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-detail"
                                            data-nama="{{ $item['pencipta']['nama'] }}"
                                            data-kewarganegaraan="{{ $item['pencipta']['kewarganegaraan'] ?? '' }}"
                                            data-alamat-pencipta="{{ $item['pencipta']['alamat'] ?? '' }}"
                                            data-email-pencipta="{{ $item['pencipta']['email'] ?? '' }}"
                                            data-no-hp-pencipta="{{ $item['pencipta']['no_hp'] ?? '' }}"
                                            data-nama-pemegang-hak="{{ $item['pemegang_hak']['nama'] ?? '' }}"
                                            data-kewarganegaraan-pemegang-hak="{{ $item['pemegang_hak']['kewarganegaraan'] ?? '' }}"
                                            data-alamat-pemegang-hak="{{ $item['pemegang_hak']['alamat'] ?? '' }}"
                                            data-email-pemegang-hak="{{ $item['pemegang_hak']['email'] ?? '' }}"
                                            data-jenis-ciptaan="{{ $item['jenis_ciptaan'] ?? '' }}"
                                            data-tanggal-dan-tempat="{{ $item['tanggal_dan_tempat'] ?? '' }}"
                                            data-uraian-ciptaan="{{ $item['uraian_ciptaan'] ?? '' }}">
                                            Detail
                                        </button>
                                        <button class="btn btn-danger btn-delete"
                                            style="margin-left: 5px;">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data tersedia</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="float-end">
                        <form id="submitForm" action="{{ route('submit-all-data') }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-primary" onclick="submitXData()">Submit All
                                Data</button>
                            <input type="hidden" id="xData" name="x_data">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 float-end">
        <form id="detailForm" action="{{ route('submit-dokumen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="detailId" name="id">
        </form>
    </div>
</main>

@section('scripts')
<script>
    function submitXData() {
        let xData = [];
        @foreach ($hasilDokumen['data'] as $item)
            @php
                $found = false;
                foreach ($existingPencipta as $pencipta) {
                    if (isset($item['pencipta']['nama']) && isset($pencipta['nama_pencipta']) && $pencipta['nama_pencipta'] == $item['pencipta']['nama'] && isset($item['uraian_ciptaan']) && isset($pencipta['uraian_cipta']) && $pencipta['uraian_cipta'] == $item['uraian_ciptaan']) {
                        $found = true;
                        break;
                    }
                }
            @endphp
            xData.push({
                id: '{{ $item['id'] ?? '' }}',
                found: {{ $found ? 'true' : 'false' }},
                nama: '{{ $item['pencipta']['nama'] ?? '' }}',
                kewarganegaraan: '{{ $item['pencipta']['kewarganegaraan'] ?? '' }}',
                alamat_pencipta: '{{ $item['pencipta']['alamat'] ?? '' }}',
                email_pencipta: '{{ $item['pencipta']['email'] ?? '' }}',
                no_hp_pencipta: '{{ $item['pencipta']['no_hp'] ?? '' }}',
                nama_pemegang_hak: '{{ $item['pemegang_hak']['nama'] ?? '' }}',
                kewarganegaraan_pemegang_hak: '{{ $item['pemegang_hak']['kewarganegaraan'] ?? '' }}',
                alamat_pemegang_hak: '{{ $item['pemegang_hak']['alamat'] ?? '' }}',
                email_pemegang_hak: '{{ $item['pemegang_hak']['email'] ?? '' }}',
                jenis_ciptaan: '{{ $item['jenis_ciptaan'] ?? '' }}',
                tanggal_dan_tempat: '{{ $item['tanggal_dan_tempat'] ?? '' }}',
                uraian_ciptaan: '{{ $item['uraian_ciptaan'] ?? '' }}'
            });
        @endforeach

        document.getElementById('xData').value = JSON.stringify(xData);

        $.ajax({
            url: "{{ route('submit-all-data') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                x_data: xData
            }),
            success: function(data) {
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
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengirim permintaan.'
                });
            }
        });
    }
</script>
@endsection
