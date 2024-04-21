@extends('layout.mainLayout')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $cardTitle }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="txt-dashboard">
        <h2>BERKAS DOKUMEN</h2>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="card col-lg-6 mb-3" style="background-color: #5691cc">
            <div class="card-body">
                {{-- <form action="{{ route('tambahPermohonan') }}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                    @if ($nik && $nama)
                    <div class="mb-3 mt-3">
                        <label class="form-label" for="nama">NIK:</label>
                        <input class="form-control" type="text" id="nama" name="nama" value=" {{ $nik }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="perusahaan">Nama:</label>
                        <input class="form-control" type="text" id="perusahaan" name="perusahaan" value=" {{ $nama }}">
                    </div>
                    @else
                    <p>Data KTP tidak lengkap atau tidak ditemukan. Mohon unggah ulang KTP.</p>
                    @endif
                    @if ($addressDetails)
                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat:</label>
                        <input class="form-control" type="text" id="alamat" name="alamat"
                            value="{{ $addressDetails['alamat'] }} RT/RW {{ $addressDetails['rtRw'] }} Kelurahan/Desa {{ $addressDetails['kelDesa'] }} Kecamatan {{ $addressDetails['kecamatan'] }}">
                    </div>
                    @endif
                    <div class="mb-3 float-end">
                        {{-- <a href="{{ route('suratpermohonan') }}" class="btn btn-primary">Kembali</a> --}}
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
