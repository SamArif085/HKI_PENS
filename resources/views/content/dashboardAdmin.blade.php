<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> --}}
                <li class="breadcrumb-item active">{{ $data['title'] }}</li>
            </ol>
        </nav>
    </div>
    <div class="txt-dashboard">
        <h2>Selamat Datang {{ Auth::user()->name }}</h2>
    </div>
    <div class="">
        <img src="img/logo2.png" class="mx-auto d-block" alt="" style="height: 300px;">
    </div>
    <div class="px-3 pt-5 txt-dashboard">
        <h2>Sistem Pendukung Pendataan Permohonan Hak Kekayaan Intelektual</h2>
        <h2>di Sentra HKI PENS</h2>
    </div>
    </div>
</main><!-- End #main -->
