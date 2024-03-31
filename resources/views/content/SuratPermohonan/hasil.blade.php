@extends('layout.mainLayout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $data['cardTitle'] }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                </ol>
            </nav>
        </div>
        <div class="txt-dashboard">
            <h2>BERKAS DOKUMEN</h2>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="card col-lg-6 mb-3" style="background-color: #5691cc">
                <div class="card-body">
                    <form action="">
                        <div class="mb-3 mt-3">
                            <label class="form-label" for="nama">Nama:</label>
                            <input class="form-control" type="text" id="nama"
                                name="nama"value="{{ $data['nama'] }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="perusahaan">Perusahaan/Badan Hukum:</label>
                            <input class="form-control" readonly type="text" id="perusahaan" name="perusahaan"
                                value="{{ $data['perusahaana'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat:</label>
                            <input class="form-control" readonly type="text" id="alamat" name="alamat"
                                value="{{ $data['alamata'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kuasa">Kuasa dan Alamat Kuasa:</label>
                            <input class="form-control"readonly type="text" id="kuasa" name="kuasa"
                                value="{{ $data['kuasa'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="telpon">Nomor Telepon/HP:</label>
                            <input class="form-control"readonly type="text" id="telpon" name="telpon"
                                value="{{ $data['telppon'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email:</label>
                            <input class="form-control" readonly type="text" id="email" name="email"
                                value="{{ $data['emails'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lisensi">Permohonan pencatatan perjanjian lisensi:</label>
                            <input class="form-control" readonly type="text" id="lisensi" name="lisensi"
                                value="{{ $data['lisensi'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pemilik_hak">Antara (Pemilik Hak):</label>
                            <input class="form-control" readonly type="text" id="pemilik_hak" name="pemilik_hak"
                                value="{{ $data['pemilik_hak'] }}">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="penerima_hak">Dengan (Penerima Hak):</label>
                            <input class="form-control" readonly type="text" id="penerima_hak" name="penerima_hak"
                                value="{{ $data['penerima_hak'] }}">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sejak_tanggal">Yang berlaku sejak tanggal:</label>
                            <input class="form-control" readonly type="text" id="sejak_tanggal" name="sejak_tanggal"
                                value="{{ $data['sejak_tanggal'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal">Sampai dengan tanggal:</label>
                            <input class="form-control" readonly type="text" id="sampai_tanggal" name="sampai_tanggal"
                                value="{{ $data['sampai_tanggal'] }}">
                        </div>
                        <div class="mb-3 float-end">
                            <a href="{{ route('suratpermohonan') }}" class="btn btn-primary">Kembali</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main><!-- End #main -->
@endsection
