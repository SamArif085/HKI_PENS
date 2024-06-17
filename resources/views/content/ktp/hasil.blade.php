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
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['nik'] ?? '' }}</td>
                            <td>{{ $item['nama'] ?? '' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-detail" data-nik="{{ $item['nik'] ?? '' }}"
                                        data-nama="{{ $item['nama'] ?? '' }}"
                                        data-alamat="{{ $item['addressDetails']['alamat'] ?? '' }}">Detail</button>
                                    <button class="btn btn-danger btn-delete" style="margin-left: 5px;">Hapus</button>
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
    <div class="mb-3 float-end">
        <form id="detailForm" action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="detailId" name="id">
        </form>
    </div>

    {{-- <div class="mb-3 float-end">
        <form id="detailForm" action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="detailId" name="id">
            {{-- <button id="detailBtn" type="button" class="btn btn-primary">Detail</button> --}}
        </form>
    </div> --}}
</main>
