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
            'alamat': $('#editalamat').val(),
            // 'rtRw': $('#editrtRw').val(),
            // 'kelDesa': $('#editkelDesa').val(),
            // 'kecamatan': $('#editkecamatan').val(),
        };
        return data;
    },

    showDetailModal: function (_nik, _nama, _alamat, _rtRw, _kelDesa, _kecamatan) {}
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

$(document).on('click', '.btn-delete', function () {
    $(this).closest('tr').remove();
});

$(document).on('click', '.btn-detail', function () {
    var nik = $(this).data('nik');
    var nama = $(this).data('nama');
    var alamat = $(this).data('alamat');
    // var rtRw = $(this).data('rtrw');
    // var kelDesa = $(this).data('desa');
    // var kecamatan = $(this).data('kecamatan');
    var button = $(this);
    console.log('alamat :', alamat);
    Swal.fire({
        title: 'Detail Data',
        html: `<div class="row">
        <div class=" mb-4">
            <label class="form-label mt-3 mb-3" style="color: black;">NIK</label>
            <input class="form-control" type="text" id="editnik" class="swal2-input" value="${nik}" placeholder="NIK">

            <label style="color: black" class="form-label mt-3 mb-3">Nama</label>
            <input class="form-control" type="text" id="editnama" class="swal2-input" value="${nama}" placeholder="Nama">

            <label style="color: black" class="form-label mt-3 mb-3">Alamat Lengkap</label>
            <input class="form-control" type="text" id="editalamat" class="swal2-input" value="${alamat}" placeholder="Alamat Lengkap">

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
            $(this).data('nik', $('#editnik').val());
            $(this).data('nama', $('#editnama').val());
            $(this).data('alamat', $('#editalamat').val());
            // $(this).data('rtRw', $('#editrtRw').val());
            // $(this).data('kelDesa', $('#editkelDesa').val());
            // $(this).data('kecamatan', $('#editkecamatan').val());
        }
    }).then((result) => {
        if (result.isConfirmed) {
            button.removeClass('btn-primary').addClass('btn-success').text('Terkirim').prop('disabled', true);
            button.next('.btn-delete').removeClass('btn-danger').addClass('btn-success').html('<i class="bi bi-check"></i>').prop('disabled', true);

            var formData = {
                'nik': $('#editnik').val(),
                'nama': $('#editnama').val(),
                'alamat': $('#editalamat').val(),
                // 'rtRw': $('#editrtRw').val(),
                // 'kelDesa': $('#editkelDesa').val(),
                // 'kecamatan': $('#editkecamatan').val(),
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
