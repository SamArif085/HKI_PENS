let ScanDokumen = {
    module: () => {
        return "ScanDokumen";
    },
    moduleApi: () => {
        return `api/${ScanDokumen.module()}`;
    },

    getPostData: () => {
        let data = {
            'id': $('input#id').val(),
            'namaPencipta': $('#editNamaPencipta').val(),
            'kewarganegaraanPencipta': $('#editKewarganegaraanPencipta').val(),
            'alamatPencipta': $('#editAlamatPencipta').val(),
            'emailPencipta': $('#editEmailPencipta').val(),
            'noHpPencipta': $('#editNoHpPencipta').val(),
            'namaPemegangHak': $('#editNamaPemegangHak').val(),
            'kewarganegaraanPemegangHak': $('#editKewarganegaraanPemegangHak').val(),
            'alamatPemegangHak': $('#editAlamatPemegangHak').val(),
            'emailPemegangHak': $('#editEmailPemegangHak').val(),
            'jenisCiptaan': $('#editJenisCiptaan').val(),
            'tanggalDanTempat': $('#editTanggalDanTempat').val(),
            'uraianCiptaan': $('#editUraianCiptaan').val()
        };
        return data;
    },

    showDetailModal: function (existingData, scannedData) {
        Swal.fire({
            title: 'Detail Data',
            html: `<div>
                <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pencipta</div>
                <input class="form-control" type="text" id="editNamaPencipta" class="swal2-input" value="${existingData.nama_pencipta || scannedData.nama_pencipta}" placeholder="Nama Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pencipta</div>
                <input class="form-control" type="text" id="editKewarganegaraanPencipta" class="swal2-input" value="${existingData.wn_pencipta || scannedData.wn_pencipta}" placeholder="Kewarganegaraan Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pencipta</div>
                <input class="form-control" type="text" id="editAlamatPencipta" class="swal2-input" value="${existingData.alamat_pencipta || scannedData.alamat_pencipta}" placeholder="Alamat Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pencipta</div>
                <input class="form-control" type="text" id="editEmailPencipta" class="swal2-input" value="${existingData.email_pencipta || scannedData.email_pencipta}" placeholder="Email Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">No. HP Pencipta</div>
                <input class="form-control" type="text" id="editNoHpPencipta" class="swal2-input" value="${existingData.no_hp_pencipta || scannedData.no_hp_pencipta}" placeholder="No. HP Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Nama Pemegang Hak</div>
                <input class="form-control" type="text" id="editNamaPemegangHak" class="swal2-input" value="${existingData.nama_pg_hak || scannedData.nama_pg_hak}" placeholder="Nama Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pemegang Hak</div>
                <input class="form-control" type="text" id="editKewarganegaraanPemegangHak" class="swal2-input" value="${existingData.wn_pg_hak || scannedData.wn_pg_hak}" placeholder="Kewarganegaraan Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pemegang Hak</div>
                <input class="form-control" type="text" id="editAlamatPemegangHak" class="swal2-input" value="${existingData.alamat_pg_hak || scannedData.alamat_pg_hak}" placeholder="Alamat Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pemegang Hak</div>
                <input class="form-control" type="text" id="editEmailPemegangHak" class="swal2-input" value="${existingData.email_pg_hak || scannedData.email_pg_hak}" placeholder="Email Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start"> Tanggal dan tempat diumumkan untuk pertama kali di wilayah Indonesia atau di luar wilayah Indonesia</div>
                <input class="form-control" type="text" id="editTanggalDanTempat" class="swal2-input" value="${existingData.tgl_tempat || scannedData.tgl_tempat}" placeholder="Tanggal dan Tempat">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Jenis Ciptaan</div>
                <input class="form-control" type="text" id="editJenisCiptaan" class="swal2-input" value="${existingData.jenis_cipta || scannedData.jenis_cipta}" placeholder="Jenis Ciptaan">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Uraian Ciptaan</div>
                <input class="form-control" type="text" id="editUraianCiptaan" class="swal2-input" value="${existingData.uraian_cipta || scannedData.uraian_cipta}" placeholder="Uraian Ciptaan">
            </div>
            `,
            customClass: {
                popup: 'my-custom-popup-class',
                content: 'my-custom-content-class',
            },
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Kirim',
            preConfirm: () => {
                // Update data dalam modal jika diperlukan
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = ScanDokumen.getPostData();
                console.log(formData);
                $.ajax({
                    url: $('#detailForm').attr('action'),
                    type: $('#detailForm').attr('method'),
                    data: formData,
                    success: function (response) {
                        console.log('Data berhasil dikirim');
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ', error);
                    }
                });
            }
        });
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const detailButtons = document.querySelectorAll('.btn-detail-form');

    detailButtons.forEach(button => {
        button.addEventListener('click', function () {
            const detailContent = `
             <div class="form-label text-start" style="color: black;">Nama Pencipta</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-nama')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Kewarganegaraan Pencipta</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-wn')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Pencipta</div>
                    <input class="form-control" readonly disabled type="text" id="existingAlamatPencipta" class="swal2-input" value="${button.getAttribute('data-alamat')}" placeholder="Alamat Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Email Pencipta</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value=" ${button.getAttribute('data-email')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">No.Telp Pencipta</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value=" ${button.getAttribute('data-hp')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pemegang Hak</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-namapghak')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">kewarganegaraan Pemegang Hak</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value=" ${button.getAttribute('data-wnpghak')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Pemegang Hak</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-alamatpghak')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Email Pemegang Hak</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-emailpghak')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;"> Tanggal dan tempat diumumkan untuk pertama kali di wilayah Indonesia atau di luar wilayah Indonesia</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-jenis')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Jenis Ciptaan</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value=" ${button.getAttribute('data-tgl')}" placeholder="Nama Pencipta">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Uraian Ciptaan</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-uraian')}" placeholder="Nama Pencipta">
            `;

            document.getElementById('detail-content').innerHTML = detailContent;
        });
    });
});

$(document).on('click', '.btn-delete', function () {
    $(this).closest('tr').remove();
});

$(document).on('click', '.btn-detail', function () {
    var namaPencipta = $(this).data('nama');
    var kewarganegaraanPencipta = $(this).data('kewarganegaraan');
    var alamatPencipta = $(this).data('alamat-pencipta');
    var emailPencipta = $(this).data('email-pencipta');
    var noHpPencipta = $(this).data('no-hp-pencipta');
    var namaPemegangHak = $(this).data('nama-pemegang-hak');
    var kewarganegaraanPemegangHak = $(this).data('kewarganegaraan-pemegang-hak');
    var alamatPemegangHak = $(this).data('alamat-pemegang-hak');
    var emailPemegangHak = $(this).data('email-pemegang-hak');
    var jenisCiptaan = $(this).data('jenis-ciptaan');
    var tanggalDanTempat = $(this).data('tanggal-dan-tempat');
    var uraianCiptaan = $(this).data('uraian-ciptaan');
    var button = $(this);

    $.ajax({
        url: 'http://127.0.0.1:8000/get-data-dokumen?nama_pencipta=' + encodeURIComponent(namaPencipta) + '&uraian_cipta=' + encodeURIComponent(uraianCiptaan),
        // url: 'https://hkipens.pjjaka.com/get-data-dokumen?nama_pencipta=' + encodeURIComponent(namaPencipta) + '&uraian_cipta=' + encodeURIComponent(uraianCiptaan),
        // url: 'https://sp3hki.pens.pusproset.site/get-data-dokumen?nama_pencipta=' + encodeURIComponent(namaPencipta) + '&uraian_cipta=' + encodeURIComponent(uraianCiptaan),
        type: 'GET',
        success: function (response) {
            if (response.dokumen_cek.length > 0) {
                ScanDokumen.showDetailModal(response.dokumen_cek[0], {
                    nama_pencipta: namaPencipta,
                    wn_pencipta: kewarganegaraanPencipta,
                    alamat_pencipta: alamatPencipta,
                    email_pencipta: emailPencipta,
                    no_hp_pencipta: noHpPencipta,
                    nama_pg_hak: namaPemegangHak,
                    wn_pg_hak: kewarganegaraanPemegangHak,
                    alamat_pg_hak: alamatPemegangHak,
                    email_pg_hak: emailPemegangHak,
                    jenis_cipta: jenisCiptaan,
                    tgl_tempat: tanggalDanTempat,
                    uraian_cipta: uraianCiptaan
                });
            } else {
                ScanDokumen.showDetailModal(null, {
                    nama_pencipta: namaPencipta,
                    wn_pencipta: kewarganegaraanPencipta,
                    alamat_pencipta: alamatPencipta,
                    email_pencipta: emailPencipta,
                    no_hp_pencipta: noHpPencipta,
                    nama_pg_hak: namaPemegangHak,
                    wn_pg_hak: kewarganegaraanPemegangHak,
                    alamat_pg_hak: alamatPemegangHak,
                    email_pg_hak: emailPemegangHak,
                    jenis_cipta: jenisCiptaan,
                    tgl_tempat: tanggalDanTempat,
                    uraian_cipta: uraianCiptaan
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan: ', error);
        }
    });
});

ScanDokumen.showDetailModal = function (existingData, scannedData) {
    Swal.fire({
        title: 'Detail Data',
        html: `
            <div class="row">
                <div class="col-md-6">
                    <h5>Data yang sudah ada:</h5>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pencipta</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData && existingData.nama_pencipta ? existingData.nama_pencipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Kewarganegaraan Pencipta</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData && existingData.wn_pencipta ? existingData.wn_pencipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Pencipta</div>
                    <input class="form-control" type="text" id="existingAlamatPencipta" class="swal2-input" value="${existingData && existingData.alamat_pencipta ? existingData.alamat_pencipta : 'data masih belum ada'}" placeholder="Alamat Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Email Pencipta</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.email_pencipta ? existingData.email_pencipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">No.Telp Pencipta</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.no_hp_pencipta ? existingData.no_hp_pencipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pemegang Hak</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.nama_pg_hak ? existingData.nama_pg_hak :'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">kewarganegaraan Pemegang Hak</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.wn_pg_hak ? existingData.wn_pg_hak : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Pemegang Hak</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.alamat_pg_hak ? existingData.alamat_pg_hak : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Email Pemegang Hak</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.email_pg_hak ? existingData.email_pg_hak : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;"> Tanggal dan tempat diumumkan untuk pertama kali di wilayah Indonesia atau di luar wilayah Indonesia</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.tgl_tempat ? existingData.tgl_tempat : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Jenis Ciptaan</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.jenis_cipta ? existingData.jenis_cipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Uraian Ciptaan</div>
                    <input class="form-control" type="text" class="swal2-input" value="${existingData  && existingData.uraian_cipta ? existingData.uraian_cipta : 'data masih belum ada'}" placeholder="Nama Pencipta" ${existingData ? 'disabled' : ''}>


                    <!-- Tambahkan input untuk data lainnya yang sudah ada -->

                </div>
                <div class="col-md-6">
                <h5>Data hasil scan baru:</h5>
                 <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pencipta</div>
                <input class="form-control" type="text" id="editNamaPencipta" class="swal2-input" value="${scannedData.nama_pencipta}" placeholder="Nama Pencipta">
                <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pencipta</div>
                <input class="form-control" type="text" id="editKewarganegaraanPencipta" class="swal2-input" value="${scannedData.wn_pencipta}" placeholder="Kewarganegaraan Pencipta">
                <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pencipta</div>
                <input class="form-control" type="text" id="editAlamatPencipta" class="swal2-input" value="${scannedData.alamat_pencipta}" placeholder="Alamat Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pencipta</div>
                <input class="form-control" type="text" id="editEmailPencipta" class="swal2-input" value="${scannedData.email_pencipta}" placeholder="Email Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">No. HP Pencipta</div>
                <input class="form-control" type="text" id="editNoHpPencipta" class="swal2-input" value="${scannedData.no_hp_pencipta}" placeholder="No. HP Pencipta">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Nama Pemegang Hak</div>
                <input class="form-control" type="text" id="editNamaPemegangHak" class="swal2-input" value="${scannedData.nama_pg_hak}" placeholder="Nama Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pemegang Hak</div>
                <input class="form-control" type="text" id="editKewarganegaraanPemegangHak" class="swal2-input" value="${scannedData.wn_pg_hak}" placeholder="Kewarganegaraan Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pemegang Hak</div>
                <input class="form-control" type="text" id="editAlamatPemegangHak" class="swal2-input" value="${scannedData.alamat_pg_hak}" placeholder="Alamat Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pemegang Hak</div>
                <input class="form-control" type="text" id="editEmailPemegangHak" class="swal2-input" value="${scannedData.email_pg_hak}" placeholder="Email Pemegang Hak">

                <div style="color: black" class="form-label mt-3 mb-3 text-start"> Tanggal dan tempat diumumkan untuk pertama kali di wilayah Indonesia atau di luar wilayah Indonesia</div>
                <input class="form-control" type="text" id="editTanggalDanTempat" class="swal2-input" value="${scannedData.tgl_tempat}" placeholder="Tanggal dan Tempat">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Jenis Ciptaan</div>
                <input class="form-control" type="text" id="editJenisCiptaan" class="swal2-input" value="${scannedData.jenis_cipta}" placeholder="Jenis Ciptaan">

                <div style="color: black" class="form-label mt-3 mb-3 text-start">Uraian Ciptaan</div>
                <input class="form-control mb-3" type="text" id="editUraianCiptaan" class="swal2-input" value="${scannedData.uraian_cipta}" placeholder="Uraian Ciptaan">
                </div>
                    <!-- Tambahkan input untuk data lainnya hasil scan -->

            </div>
        `,
        customClass: {
            popup: 'my-custom-popup-class',
            content: 'my-custom-content-class',
        },
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Kirim',
        preConfirm: () => {
            var namaPencipta = $('#editNamaPencipta').val();
            var kewarganegaraanPencipta = $('#editKewarganegaraanPencipta').val();
            var alamatPencipta = $('#editAlamatPencipta').val();
            var emailPencipta = $('#editEmailPencipta').val();
            var noHpPencipta = $('#editNoHpPencipta').val();
            var namaPemegangHak = $('#editNamaPemegangHak').val();
            var kewarganegaraanPemegangHak = $('#editKewarganegaraanPemegangHak').val();
            var alamatPemegangHak = $('#editAlamatPemegangHak').val();
            var emailPemegangHak = $('#editEmailPemegangHak').val();
            var jenisCiptaan = $('#editJenisCiptaan').val();
            var tanggalDanTempat = $('#editTanggalDanTempat').val();
            var uraianCiptaan = $('#editUraianCiptaan').val();

            var data = {
                existingData: existingData,
                namaPencipta: namaPencipta,
                kewarganegaraanPencipta: kewarganegaraanPencipta,
                alamatPencipta: alamatPencipta,
                emailPencipta: emailPencipta,
                noHpPencipta: noHpPencipta,
                namaPemegangHak: namaPemegangHak,
                kewarganegaraanPemegangHak: kewarganegaraanPemegangHak,
                alamatPemegangHak: alamatPemegangHak,
                emailPemegangHak: emailPemegangHak,
                jenisCiptaan: jenisCiptaan,
                tanggalDanTempat: tanggalDanTempat,
                uraianCiptaan: uraianCiptaan
            };
            return $.ajax({
                url: 'http://127.0.0.1:8000/api/submit-scan-dokumen',
                // url: 'https://hkipens.pjjaka.com/api/submit-scan-dokumen',
                // url: 'https://sp3hki.pens.pusproset.site/api/submit-scan-dokumen',
                method: 'POST',
                data: data,
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: 'Data berhasil disimpan atau diperbarui.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }).catch((error) => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menyimpan data.',
        });
    });
};

$(document).ready(function () {
    $('.btn-edit-pencipta').click(function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var wn = $(this).data('wn');
        var alamat = $(this).data('alamat');
        var email = $(this).data('email');
        var hp = $(this).data('hp');
        var namapghak = $(this).data('namapghak');
        var wnpghak = $(this).data('wnpghak');
        var alamatpghak = $(this).data('alamatpghak');
        var emailpghak = $(this).data('emailpghak');
        var jenis = $(this).data('jenis');
        var tgl = $(this).data('tgl');
        var uraian = $(this).data('uraian');

        Swal.fire({
            title: 'Edit Data Pencipta',
            html: `<input type="hidden" id="edit-id" value="${id}">
                <div class="mb-3">
                    <div for="edit-nama" class="form-label text-start" style="color: black;">Nama Pencipta</div>
                    <input type="text" class="form-control" id="edit-nama" value="${nama}">
                </div>
                <div class="mb-3">
                    <div for="edit-wn" class="form-label text-start" style="color: black;">WN Pencipta</div>
                    <input type="text" class="form-control" id="edit-wn" value="${wn}">
                </div>
                <div class="mb-3">
                    <div for="edit-alamat" class="form-label text-start" style="color: black;">Alamat Pencipta</div>
                    <textarea class="form-control" id="edit-alamat">${alamat}</textarea>
                </div>
                <div class="mb-3">
                    <div for="edit-email" class="form-label text-start" style="color: black;">Email Pencipta</div>
                    <input type="email" class="form-control" id="edit-email" value="${email}">
                </div>
                <div class="mb-3">
                    <div for="edit-hp" class="form-label text-start" style="color: black;">No. HP Pencipta</div>
                    <input type="text" class="form-control" id="edit-hp" value="${hp}">
                </div>
                <div class="mb-3">
                    <div for="edit-namapghak" class="form-label text-start" style="color: black;">Nama Pengelolaan Hak</div>
                    <input type="text" class="form-control" id="edit-namapghak" value="${namapghak}">
                </div>
                <div class="mb-3">
                    <div for="edit-wnpghak" class="form-label text-start" style="color: black;">WN Pengelolaan Hak</div>
                    <input type="text" class="form-control" id="edit-wnpghak" value="${wnpghak}">
                </div>
                <div class="mb-3">
                    <div for="edit-alamatpghak" class="form-label text-start" style="color: black;">Alamat Pengelolaan Hak</div>
                    <textarea class="form-control" id="edit-alamatpghak">${alamatpghak}</textarea>
                </div>
                <div class="mb-3">
                    <div for="edit-emailpghak" class="form-label text-start" style="color: black;">Email Pengelolaan Hak</div>
                    <input type="email" class="form-control" id="edit-emailpghak" value="${emailpghak}">
                </div>
                <div class="mb-3">
                    <div for="edit-jenis" class="form-label text-start" style="color: black;">Jenis Ciptaan</div>
                    <input type="text" class="form-control" id="edit-jenis" value="${jenis}">
                </div>
                <div class="mb-3">
                    <div for="edit-tgl" class="form-label text-start" style="color: black;"> Tanggal dan tempat diumumkan untuk pertama kali di wilayah Indonesia atau di luar wilayah Indonesia</div>
                    <input type="text" class="form-control" id="edit-tgl" value="${tgl}">
                </div>
                <div class="mb-3">
                    <div for="edit-uraian" class="form-label text-start" style="color: black;">Uraian Ciptaan</div>
                    <textarea class="form-control" id="edit-uraian">${uraian}</textarea>
                </div>`,
            customClass: {
                popup: 'my-custom-popup-class-edit-dokumen',
                content: 'my-custom-content-class',
            },
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                var id = $('#edit-id').val();
                var nama = $('#edit-nama').val();
                var wn = $('#edit-wn').val();
                var alamat = $('#edit-alamat').val();
                var email = $('#edit-email').val();
                var hp = $('#edit-hp').val();
                var namapghak = $('#edit-namapghak').val();
                var wnpghak = $('#edit-wnpghak').val();
                var alamatpghak = $('#edit-alamatpghak').val();
                var emailpghak = $('#edit-emailpghak').val();
                var jenis = $('#edit-jenis').val();
                var tgl = $('#edit-tgl').val();
                var uraian = $('#edit-uraian').val();

                return $.ajax({
                    // url: 'http://127.0.0.1:8000/api/submit-edit-dokumen',
                    // url: 'https://hkipens.pjjaka.com/api/submit-edit-dokumen',
                    url: 'https://sp3hki.pens.pusproset.site/api/submit-edit-dokumen',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        nama: nama,
                        wn: wn,
                        alamat: alamat,
                        email: email,
                        hp: hp,
                        namapghak: namapghak,
                        wnpghak: wnpghak,
                        alamatpghak: alamatpghak,
                        emailpghak: emailpghak,
                        jenis: jenis,
                        tgl: tgl,
                        uraian: uraian
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil diperbarui!',
                    timer: 1500,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    location.reload();
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {

            }
        }).catch((error) => {
            console.error('Terjadi kesalahan:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat mengirim data.',
                footer: '<a href>Butuh bantuan?</a>'
            });
        });
    });
});






// .then((result) => {
//     if (result.isConfirmed) {
//         button.removeClass('btn-primary').addClass('btn-success').text('Terkirim').prop('disabled', true);
//         button.next('.btn-delete').removeClass('btn-danger').addClass('btn-success').html('<i class="bi bi-check"></i>').prop('disabled', true);
//     }
// });
