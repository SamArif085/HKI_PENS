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
    <div class="txt-dashboard">
        <h2>BERKAS DOKUMEN</h2>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body mt-2">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Nama Pencipta</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilDokumen['data'] as $item)
                        <tr>
                            <td>{{ $item['pencipta']['nama'] }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-detail"
                                        data-nama="{{ $item['pencipta']['nama'] }}"
                                        data-kewarganegaraan="{{ $item['pencipta']['kewarganegaraan'] }}"
                                        data-alamat-pencipta="{{ $item['pencipta']['alamat'] }}"
                                        data-email-pencipta="{{ $item['pencipta']['email'] }}"
                                        data-no-hp-pencipta="{{ $item['pencipta']['no_hp'] }}"
                                        data-nama-pemegang-hak="{{ $item['pemegang_hak']['nama'] }}"
                                        data-kewarganegaraan-pemegang-hak="{{ $item['pemegang_hak']['kewarganegaraan'] }}"
                                        data-alamat-pemegang-hak="{{ $item['pemegang_hak']['alamat'] }}"
                                        data-email-pemegang-hak="{{ $item['pemegang_hak']['email'] }}"
                                        data-jenis-ciptaan="{{ $item['jenis_ciptaan'] }}"
                                        data-tanggal-dan-tempat="{{ $item['tanggal_dan_tempat'] }}"
                                        data-uraian-ciptaan="{{ $item['uraian_ciptaan'] }}">
                                        Detail
                                    </button>
                                    <button class="btn btn-danger btn-delete" style="margin-left: 5px;">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3 float-end">
                    {{-- <a href="{{ route('suratpermohonan') }}" class="btn btn-primary">Kembali</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 float-end">
        <form id="detailForm" action="{{ route('submit-dokumen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="detailId" name="id">
            {{-- <button id="detailBtn" type="button" class="btn btn-primary">Detail</button> --}}
        </form>
    </div>
</main><!-- End #main -->
