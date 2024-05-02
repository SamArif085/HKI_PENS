{{-- {{ dd($data) }} --}}

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
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="card col-lg-12 mb-3" style="background-color: #5691cc">
            <div class="card-body">
                <form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                {{-- <th>RT/RW</th>
                                <th>Kelurahan/Desa</th>
                                <th>Kecamatan</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td><input class="form-control" type="text" name="nik[]"
                                        value="{{ $item['nik'] ?? '' }}"></td>
                                <td><input class="form-control" type="text" name="nama[]"
                                        value="{{ $item['nama'] ?? '' }}"></td>
                                <td><input class="form-control" type="text" name="alamat[]"
                                        value="{{ $item['addressDetails']['alamat'] ?? '' }}"></td>
                                {{-- <td><input class="form-control" type="text" name="rtRw[]"
                                        value="{{ $item['addressDetails']['rtRw'] ?? '' }}"></td>
                                <td><input class="form-control" type="text" name="kelDesa[]"
                                        value="{{ $item['addressDetails']['kelDesa'] ?? '' }}"></td>
                                <td><input class="form-control" type="text" name="kecamatan[]"
                                        value="{{ $item['addressDetails']['kecamatan'] ?? '' }}"></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mb-3 float-end">
                        {{-- <a href="{{ route('suratpermohonan') }}" class="btn btn-primary">Kembali</a> --}}
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
