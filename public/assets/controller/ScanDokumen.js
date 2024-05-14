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

    Swal.fire({
        title: 'Detail Data',
        html: 
        `<div>
            <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Pencipta</div>
            <input class="form-control" type="text" id="editNamaPencipta" class="swal2-input" value="${namaPencipta}" placeholder="Nama Pencipta">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pencipta</div>
            <input class="form-control" type="text" id="editKewarganegaraanPencipta" class="swal2-input" value="${kewarganegaraanPencipta}" placeholder="Kewarganegaraan Pencipta">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pencipta</div>
            <input class="form-control" type="text" id="editAlamatPencipta" class="swal2-input" value="${alamatPencipta}" placeholder="Alamat Pencipta">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pencipta</div>
            <input class="form-control" type="text" id="editEmailPencipta" class="swal2-input" value="${emailPencipta}" placeholder="Email Pencipta">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">No. HP Pencipta</div>
            <input class="form-control" type="text" id="editNoHpPencipta" class="swal2-input" value="${noHpPencipta}" placeholder="No. HP Pencipta">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Nama Pemegang Hak</div>
            <input class="form-control" type="text" id="editNamaPemegangHak" class="swal2-input" value="${namaPemegangHak}" placeholder="Nama Pemegang Hak">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Kewarganegaraan Pemegang Hak</div>
            <input class="form-control" type="text" id="editKewarganegaraanPemegangHak" class="swal2-input" value="${kewarganegaraanPemegangHak}" placeholder="Kewarganegaraan Pemegang Hak">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Alamat Pemegang Hak</div>
            <input class="form-control" type="text" id="editAlamatPemegangHak" class="swal2-input" value="${alamatPemegangHak}" placeholder="Alamat Pemegang Hak">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Email Pemegang Hak</div>
            <input class="form-control" type="text" id="editEmailPemegangHak" class="swal2-input" value="${emailPemegangHak}" placeholder="Email Pemegang Hak">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Tanggal & Tempat</div>
            <input class="form-control" type="text" id="editTanggalDanTempat" class="swal2-input" value="${tanggalDanTempat}" placeholder="Tanggal dan Tempat">
        
            <div style="color: black" class="form-label mt-3 mb-3 text-start">Jenis Ciptaan</div>
            <input class="form-control" type="text" id="editJenisCiptaan" class="swal2-input" value="${jenisCiptaan}" placeholder="Jenis Ciptaan">

            <div style="color: black" class="form-label mt-3 mb-3 text-start">Uraian Ciptaan</div>
            <input class="form-control" type="text" id="editUraianCiptaan" class="swal2-input" value="${uraianCiptaan}" placeholder="Uraian Ciptaan">
        </div>
        `,
        customClass: {
            popup: 'my-custom-popup-class',
            content: 'my-custom-content-class',
            title: 'pb-4 bg-secondary text-light',
            footer: 'mb-0 pb-4 bg-secondary ',
            
        },
        background: '#a3a3a3',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        footer:
        '<div class="d-flex flex-row-reverse">' + 
        '<button class="btn btn-danger ml-2" style="margin-left: 30px;" id="cancelButton">Cancel</button>'+ 
        '<button class="btn btn-primary ml-2"  id="confirmButton">Send</button>'+ 
        '</div>',
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
    });
    document.getElementById('cancelButton').addEventListener('click', () => {
        Swal.close();
    });
    document.getElementById('confirmButton').addEventListener('click', () => {
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
                    button.removeClass('btn-primary').addClass('btn-success').text('Terkirim').prop('disabled', true);
                    button.next('.btn-delete').removeClass('btn-danger').addClass('btn-success').html('<i class="bi bi-check"></i>').prop('disabled', true);
                    Swal.close();
    });
    // .then((result) => {
    //     if (result.isConfirmed) {
    //         button.removeClass('btn-primary').addClass('btn-success').text('Terkirim').prop('disabled', true);
    //         button.next('.btn-delete').removeClass('btn-danger').addClass('btn-success').html('<i class="bi bi-check"></i>').prop('disabled', true);

    //         var formData = {
    //             'namaPencipta': $('#editNamaPencipta').val(),
    //             'kewarganegaraanPencipta': $('#editKewarganegaraanPencipta').val(),
    //             'alamatPencipta': $('#editAlamatPencipta').val(),
    //             'emailPencipta': $('#editEmailPencipta').val(),
    //             'noHpPencipta': $('#editNoHpPencipta').val(),
    //             'namaPemegangHak': $('#editNamaPemegangHak').val(),
    //             'kewarganegaraanPemegangHak': $('#editKewarganegaraanPemegangHak').val(),
    //             'alamatPemegangHak': $('#editAlamatPemegangHak').val(),
    //             'emailPemegangHak': $('#editEmailPemegangHak').val(),
    //             'jenisCiptaan': $('#editJenisCiptaan').val(),
    //             'tanggalDanTempat': $('#editTanggalDanTempat').val(),
    //             'uraianCiptaan': $('#editUraianCiptaan').val()
    //         };

    //         console.log(formData);
    //         $.ajax({
    //             url: $('#detailForm').attr('action'),
    //             type: $('#detailForm').attr('method'),
    //             data: formData,
    //             success: function (response) {
    //                 console.log('Data berhasil dikirim');
    //             },
    //             error: function (xhr, status, error) {
    //                 console.error('Terjadi kesalahan: ', error);
    //             }
    //         });
    //     }
    // });

});
