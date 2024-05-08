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

    showDetailModal: function (_namaPencipta, _kewarganegaraanPencipta, _alamatPencipta, _emailPencipta, _noHpPencipta, _namaPemegangHak, _kewarganegaraanPemegangHak, _alamatPemegangHak, _emailPemegangHak, _jenisCiptaan, _tanggalDanTempat, _uraianCiptaan) {}
}

$(function () {
    ScanDokumen.getData();
    ScanDokumen.setTextEditor();
    // ScanDokumen.setDate();
    ScanDokumen.select2All();
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formFile").addEventListener("change", function () {
        document.getElementById("formFile").submit();
    });
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

    Swal.fire({
        title: 'Detail Data',
        html: `<div class="row">
        <div class="col-md-6">
            <label class="form-label mt-3 mb-3" style="color: black;">Nama Pencipta</label>
            <input class="form-control" type="text" id="editNamaPencipta" class="swal2-input" value="${namaPencipta}" placeholder="Nama Pencipta">

            <label style="color: black" class="form-label mt-3 mb-3">Kewarganegaraan Pencipta</label>
            <input class="form-control" type="text" id="editKewarganegaraanPencipta" class="swal2-input" value="${kewarganegaraanPencipta}" placeholder="Kewarganegaraan Pencipta">

            <label style="color: black" class="form-label mt-3 mb-3">Alamat Pencipta</label>
            <input class="form-control" type="text" id="editAlamatPencipta" class="swal2-input" value="${alamatPencipta}" placeholder="Alamat Pencipta">

            <label style="color: black" class="form-label mt-3 mb-3">Email Pencipta</label>
            <input class="form-control" type="text" id="editEmailPencipta" class="swal2-input" value="${emailPencipta}" placeholder="Email Pencipta">

            <label style="color: black" class="form-label mt-3 mb-3">No. HP Pencipta</label>
            <input class="form-control" type="text" id="editNoHpPencipta" class="swal2-input" value="${noHpPencipta}" placeholder="No. HP Pencipta">

        </div>
        <div class="col-md-6 mb-4">
            <label style="color: black" class="form-label mt-3 mb-3 ">Nama Pemegang Hak</label>
            <input class="form-control" type="text" id="editNamaPemegangHak" class="swal2-input" value="${namaPemegangHak}" placeholder="Nama Pemegang Hak">

            <label style="color: black" class="form-label mt-3 mb-3">Kewarganegaraan Pemegang Hak</label>
            <input class="form-control" type="text" id="editKewarganegaraanPemegangHak" class="swal2-input" value="${kewarganegaraanPemegangHak}" placeholder="Kewarganegaraan Pemegang Hak">

            <label style="color: black" class="form-label mt-3 mb-3">Alamat Pemegang Hak</label>
            <input class="form-control" type="text" id="editAlamatPemegangHak" class="swal2-input" value="${alamatPemegangHak}" placeholder="Alamat Pemegang Hak">

            <label style="color: black" class="form-label mt-3 mb-3">Email Pemegang Hak</label>
            <input class="form-control" type="text" id="editEmailPemegangHak" class="swal2-input" value="${emailPemegangHak}" placeholder="Email Pemegang Hak">

            <label style="color: black" class="form-label mt-3 mb-3">Tanggal & Tempat</label>
            <input class="form-control" type="text" id="editTanggalDanTempat" class="swal2-input" value="${tanggalDanTempat}" placeholder="Tanggal dan Tempat">
        </div>
        <div class="mb-4">
            <label style="color: black" class="form-label mt-3 mb-3">Jenis Ciptaan</label>
            <input class="form-control" type="text" id="editJenisCiptaan" class="swal2-input" value="${jenisCiptaan}" placeholder="Jenis Ciptaan">

            <label style="color: black" class="form-label mt-3 mb-3">Uraian Ciptaan</label>
            <input class="form-control" type="text" id="editUraianCiptaan" class="swal2-input" value="${uraianCiptaan}" placeholder="Uraian Ciptaan">
        </div>
        </div>`,
        customClass: {
            popup: 'my-custom-popup-class',
            content: 'my-custom-content-class',
        },
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Kirim',
        preConfirm: () => {
            $(this).data('nama', $('#editNamaPencipta').val());
            $(this).data('kewarganegaraan', $('#editKewarganegaraanPencipta').val());
            $(this).data('alamat-pencipta', $('#editAlamatPencipta').val());
            $(this).data('email-pencipta', $('#editEmailPencipta').val());
            $(this).data('no-hp-pencipta', $('#editNoHpPencipta').val());
            $(this).data('nama-pemegang-hak', $('#editNamaPemegangHak').val());
            $(this).data('kewarganegaraan-pemegang-hak', $('#editKewarganegaraanPemegangHak').val());
            $(this).data('alamat-pemegang-hak', $('#editAlamatPemegangHak').val());
            $(this).data('email-pemegang-hak', $('#editEmailPemegangHak').val());
            $(this).data('jenis-ciptaan', $('#editJenisCiptaan').val());
            $(this).data('tanggal-dan-tempat', $('#editTanggalDanTempat').val());
            $(this).data('uraian-ciptaan', $('#editUraianCiptaan').val());
        }
    }).then((result) => {
        if (result.isConfirmed) {

            button.removeClass('btn-primary').addClass('btn-success').text('Terkirim').prop('disabled', true);

            var formData = {
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

});
