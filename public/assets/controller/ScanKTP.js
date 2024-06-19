let ScanKTP = {
    module: () => {
        return "ScanKTP";
    },
    moduleApi: () => {
        return `api/${ScanKTP.module()}`;
    },

    getPostData: () => {
        let data = {
            'nik': $('#editnik').val(),
            'nama': $('#editnama').val(),
            'alamat': $('#editalamat').val(),
        };
        return data;
    },

    showDetailModal: function (existingData = {}, scannedData = {}) {
        Swal.fire({
            title: 'Detail Data',
            html: `
            <div class="row">
                <div class="col-md-6">
                    <h5>Data yang sudah ada:</h5>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">NIK</div>
                    <input class="form-control" type="text" value="${existingData.nik || 'Data tidak tersedia'}" disabled>

                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Lengkap</div>
                    <input class="form-control" type="text" value="${existingData.nama || 'Data tidak tersedia'}" disabled>

                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Lengkap</div>
                    <input class="form-control" type="text" value="${existingData.alamat || 'Data tidak tersedia'}" disabled>
                </div>
                <div class="col-md-6">
                    <h5>Data hasil scan baru:</h5>
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">NIK</div>
                    <input class="form-control" type="text" id="editnik" value="${scannedData.nik || ''}" placeholder="NIK">

                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Lengkap</div>
                    <input class="form-control" type="text" id="editnama" value="${scannedData.nama || ''}" placeholder="Nama Lengkap">

                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat Lengkap</div>
                    <input class="form-control mb-3" type="text" id="editalamat" value="${scannedData.alamat || ''}" placeholder="Alamat Lengkap">
                </div>
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
                var nik = $('#editnik').val();
                var nama = $('#editnama').val();
                var alamat = $('#editalamat').val();
                var data = {
                    existingData: existingData,
                    nik: nik,
                    nama: nama,
                    alamat: alamat,
                }
                return $.ajax({
                    url: $('#detailForm').attr('action'),
                    type: $('#detailForm').attr('method'),
                    data: data,
                }).done(function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan atau diperbarui.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }).fail(function (xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menyimpan data.'
                    });
                });
            }
        });
    }
}

$(document).on('click', '.btn-detail', function () {
    var nik = $(this).data('nik');
    var nama = $(this).data('nama');
    var alamat = $(this).data('alamat');

    $.ajax({
        // url: 'http://127.0.0.1:8000/get-data-ktp?nik=' + nik,
        // url: 'https://hkipens.pjjaka.com/get-data-ktp?nik=' + nik,
        url: 'https://sp3hki.pens.pusproset.site/get-data-ktp?nik=' + nik,
        type: 'GET',
        success: function (response) {
            if (response.ktp && response.ktp.length > 0) {
                ScanKTP.showDetailModal(response.ktp[0], {
                    nik: nik,
                    nama: nama,
                    alamat: alamat
                });
            } else {
                ScanKTP.showDetailModal({}, {
                    nik: nik,
                    nama: nama,
                    alamat: alamat
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan: ', error);
        }
    });
});

$(function () {
    ScanKTP.setTextEditor();
    ScanKTP.select2All();
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formFile").addEventListener("change", function () {
        document.getElementById("formFile").submit();
    });
});

$(document).on('click', '.btn-delete', function () {
    $(this).closest('tr').remove();
});

document.addEventListener("DOMContentLoaded", function () {
    const detailButtons = document.querySelectorAll('.btn-detail-form-ktp');

    detailButtons.forEach(button => {
        button.addEventListener('click', function () {
            const detailContent = `
             <div class="form-label text-start" style="color: black;">NIK</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-nik')}" placeholder="NIK">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Nama Lengkap</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-nama')}" placeholder="Nama Lengkap">
                    <div class="form-label mt-3 mb-3 text-start" style="color: black;">Alamat</div>
                    <input class="form-control" readonly disabled type="text" class="swal2-input" value="${button.getAttribute('data-alamat')}" placeholder="Alamat">
            `;

            document.getElementById('detail-content-ktp').innerHTML = detailContent;
        });
    });
});

$(document).ready(function () {
    $('.btn-edit-form-ktp').click(function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var nik = $(this).data('nik');
        var alamat = $(this).data('alamat');

        Swal.fire({
            title: 'Edit Data KTP',
            html: `<input type="hidden" id="edit-id" value="${id}">
                <div class="mb-3">
                   <div class="form-label text-start" style="color: black;">NIK</div>
                    <input type="text" class="form-control" id="edit-nik" value="${nik}">
                </div>
                <div class="mb-3">
                   <div class="form-label text-start" style="color: black;">Nama Lengkap</div>
                    <input type="text" class="form-control" id="edit-nama" value="${nama}">
                </div>
                <div class="mb-3">
                 <div class="form-label text-start" style="color: black;">Alamat</div>
                    <textarea class="form-control" id="edit-alamat">${alamat}</textarea>
                </div>`,
            customClass: {
                popup: 'my-custom-popup-class-edit-ktp',
                content: 'my-custom-content-class',
            },
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                var id = $('#edit-id').val();
                var nama = $('#edit-nama').val();
                var nik = $('#edit-nik').val();
                var alamat = $('#edit-alamat').val();
                return $.ajax({
                    // url: 'http://127.0.0.1:8000/api/submit-edit-ktp',
                    // url: 'https://hkipens.pjjaka.com/api/submit-edit-ktp',
                    url: 'https://sp3hki.pens.pusproset.site/api/submit-edit-ktp',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        nama: nama,
                        nik: nik,
                        alamat: alamat
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
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    location.reload();
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Jika dibatalkan, tidak perlu ada tindakan tambahan
            }
        }).catch((error) => {
            console.error('Terjadi kesalahan:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat menyimpan data.',
                footer: '<a href>Butuh bantuan?</a>'
            });
        });
    });
});
