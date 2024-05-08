let ScanKTP = {
    module: () => {
        return "ScanKTP";
    },
    moduleApi: () => {
        return `api/${ScanKTP.module()}`;
    },

    getPostData: () => {
        let data = {
            'id': $('input#id').val(),
            'nik': $('#editnik').val(),
            'nama': $('#editnama').val(),
            'alamat_lkp': $('#editalamat_lkp').val(),
            'rtrw': $('#editrtrw').val(),
            'keldesa': $('#editkeldesa').val(),
            'kecamatan': $('#editkecamatan').val(),
        };
        return data;
    },

    showDetailModal: function (_nik, _nama, _alamat_lkp, _rtrw, _keldesa, _kecamatan) {}
}

$(function () {
    ScanKTP.getData();
    ScanKTP.setTextEditor();
    // ScanKTP.setDate();
    ScanKTP.select2All();
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formFile").addEventListener("change", function () {
        document.getElementById("formFile").submit();
    });
});

$(document).on('click', '.btn-detail', function () {
    var nik = $(this).data('nik');
    var nama = $(this).data('nama');
    var alamat_lkp = $(this).data('alamat_lkp');
    var rtrw = $(this).data('rtrw');
    var keldesa = $(this).data('keldesa');
    var kecamatan = $(this).data('kecamatan');
    var button = $(this);

    Swal.fire({
        title: 'Detail Data',
        html: `<div class="row">
        <div class=" mb-4">
            <label class="form-label mt-3 mb-3" style="color: black;">NIK</label>
            <input class="form-control" type="text" id="editnik" class="swal2-input" value="${nik}" placeholder="NIK">

            <label style="color: black" class="form-label mt-3 mb-3">Nama</label>
            <input class="form-control" type="text" id="editnama" class="swal2-input" value="${nama}" placeholder="Nama">

            <label style="color: black" class="form-label mt-3 mb-3">Alamat Lengkap</label>
            <input class="form-control" type="text" id="editalamat_lkp" class="swal2-input" value="${alamat_lkp}" placeholder="Alamat Lengkap">

            <label style="color: black" class="form-label mt-3 mb-3">RT/RW</label>
            <input class="form-control" type="text" id="editrtrw" class="swal2-input" value="${rtrw}" placeholder="RT/RW">

            <label style="color: black" class="form-label mt-3 mb-3">Kel/Desa</label>
            <input class="form-control" type="text" id="editkeldesa" class="swal2-input" value="${keldesa}" placeholder="Kel/Desa">

            <label style="color: black" class="form-label mt-3 mb-3 ">Kecamatan</label>
            <input class="form-control" type="text" id="editkecamatan" class="swal2-input" value="${kecamatan}" placeholder="Kecamatan">
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
            $(this).data('nama', $('#editnik').val());
            $(this).data('kewarganegaraan', $('#editnama').val());
            $(this).data('alamat-pencipta', $('#editalamat_lkp').val());
            $(this).data('email-pencipta', $('#editrtrw').val());
            $(this).data('no-hp-pencipta', $('#editkeldesa').val());
            $(this).data('nama-pemegang-hak', $('#editkecamatan').val());
            $(this).data('kewarganegaraan-pemegang-hak', $('#editKewarganegaraanPemegangHak').val());
            $(this).data('alamat-pemegang-hak', $('#editAlamatPemegangHak').val());
            $(this).data('email-pemegang-hak', $('#editEmailPemegangHak').val());
            $(this).data('jenis-ciptaan', $('#editJenisCiptaan').val());
            $(this).data('tanggal-dan-tempat', $('#editTanggalDanTempat').val());
            $(this).data('uraian-ciptaan', $('#editUraianCiptaan').val());
        }
    }).then((result) => {
        if (result.isConfirmed) {

            button.removeClass('btn-primary').addClass('btn-success').text('Selesai').prop('disabled', true);

            var formData = {
                'nik': $('#editnik').val(),
                'nama': $('#editnama').val(),
                'alamat_lkp': $('#editalamat_lkp').val(),
                'rtrw': $('#editrtrw').val(),
                'keldesa': $('#editkeldesa').val(),
                'kecamatan': $('#editkecamatan').val(),
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
