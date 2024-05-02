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
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="card col-lg-12 mb-3" style="background-color: #5691cc">
            <div class="card-body">
                <form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Pencipta</th>
                                <th>Kewarganegaraan Pencipta</th>
                                <th>Alamat Pencipta</th>
                                <th>Email Pencipta</th>
                                <th>No.HP Pencipta</th>
                                <th>Nama Pemegang Hak</th>
                                <th>Kewarganegaraan Pemegang Hak</th>
                                <th>Alamat Pemegang Hak</th>
                                <th>Email Pemegang Hak</th>
                                <th>Jenis Ciptaan</th>
                                <th>Tanggal dan Tempat Diumumkan</th>
                                <th>Uraian Ciptaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilDokumen['data'] as $item)
                            <tr>
                                <td><input class="form-control" type="text" name="nama_pencipta[]"
                                        value="{{ $item['pencipta']['nama'] }}"></td>
                                <td><input class="form-control" type="text" name="kewarganegaraan_pencipta[]"
                                        value="{{ $item['pencipta']['kewarganegaraan'] }}"></td>
                                <td><input class="form-control" type="text" name="alamat_pencipta[]"
                                        value="{{ $item['pencipta']['alamat'] }}"></td>
                                <td><input class="form-control" type="text" name="email_pencipta[]"
                                        value="{{ $item['pencipta']['email'] }}"></td>
                                <td><input class="form-control" type="text" name="email_pencipta[]"
                                        value="{{ $item['pencipta']['no_hp'] }}"></td>
                                <td><input class="form-control" type="text" name="nama_pemegang_hak[]"
                                        value="{{ $item['pemegang_hak']['nama'] }}"></td>
                                <td><input class="form-control" type="text" name="kewarganegaraan_pemegang_hak[]"
                                        value="{{ $item['pemegang_hak']['kewarganegaraan'] }}"></td>
                                <td><input class="form-control" type="text" name="alamat_pemegang_hak[]"
                                        value="{{ $item['pemegang_hak']['alamat'] }}"></td>
                                <td><input class="form-control" type="text" name="email_pemegang_hak[]"
                                        value="{{ $item['pemegang_hak']['email'] }}"></td>
                                <td><input class="form-control" type="text" name="jenis_ciptaan[]"
                                        value="{{ $item['jenis_ciptaan'] }}"></td>
                                <td><input class="form-control" type="text" name="tanggal_dan_tempat[]"
                                        value="{{ $item['tanggal_dan_tempat'] }}"></td>
                                <td><input class="form-control" type="text" name="uraian_ciptaan[]"
                                        value="{{ $item['uraian_ciptaan'] }}"></td>
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
</main><!-- End #main -->
