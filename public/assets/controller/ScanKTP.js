let ScanKTP = {
    module: () => {
        return "ScanKTP";
    },
    moduleApi: () => {
        return `api/${ScanKTP.module()}`;
    },

    getPostData: () => {
        let data = {
            'data': {
                'id': $('input#id').val(),
                'ScanKTP': $('input#ScanKTP').val(),
                'keterangan': quill.root.innerHTML,
            },

        };
        return data;
    },

    // submit: (elm, e) => {
    //     e.preventDefault();
    //     let form = $(elm).closest('div.row');
    //     let params = ScanKTP.getPostData(); // Menggunakan ScanKTP.getPostData() untuk mendapatkan data
    //     if (validation.runWithElement(form)) {
    //         $.ajax({
    //             type: 'POST',
    //             dataType: 'json',
    //             data: params,
    //             url: url.base_url(ScanKTP.module()) + "/submit",
    //             beforeSend: () => {
    //                 message.loadingProses('Proses Simpan Data...');
    //             },
    //             error: function () {
    //                 message.closeLoading();
    //                 Toast.error('Informasi', "Gagal");
    //             },
    //             success: function (resp) {
    //                 message.closeLoading();
    //                 if (resp.is_valid) {
    //                     Toast.success('Informasi', 'Data Berhasil Disimpan');
    //                     // Tidak perlu refresh halaman, karena Anda ingin pindah ke halaman hasil
    //                     // setTimeout(function () {
    //                     //     window.location.reload();
    //                     // }, 1000);
    //                     // Redirect ke halaman hasil scan KTP
    //                     window.location.href = '/Scan-KTP/hasil';
    //                 } else {
    //                     bootbox.dialog({
    //                         message: resp.message
    //                     });
    //                 }
    //             }
    //         });
    //     }
    // },
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
