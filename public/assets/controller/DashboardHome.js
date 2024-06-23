let DashboardHome = {
    module: () => {
        return "DashboardHome";
    },
    moduleApi: () => {
        return `api/${DashboardHome.module()}`;
    },

    getPostData: () => {
        let data = {
            'data': {
                'id': $('input#id').val(),
                'DashboardHome': $('input#DashboardHome').val(),
                'keterangan': quill.root.innerHTML,
            },

        };
        return data;
    },

    // submit: (elm, e) => {
    //     e.preventDefault();
    //     let form = $(elm).closest('div.row');
    //     let params = DashboardHome.getPostData(); // Menggunakan DashboardHome.getPostData() untuk mendapatkan data
    //     if (validation.runWithElement(form)) {
    //         $.ajax({
    //             type: 'POST',
    //             dataType: 'json',
    //             data: params,
    //             url: url.base_url(DashboardHome.module()) + "/submit",
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
    DashboardHome.getData();
    DashboardHome.setTextEditor();
    // DashboardHome.setDate();
    DashboardHome.select2All();
});
// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("formFile").addEventListener("change", function () {
//         document.getElementById("formFile").submit();
//     });
// });
