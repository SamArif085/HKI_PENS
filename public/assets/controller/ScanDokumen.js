let ScanDokumen = {
    module: () => {
        return "ScanDokumen";
    },
    moduleApi: () => {
        return `api/${ScanDokumen.module()}`;
    },

    getPostData: () => {
        let data = {
            'data': {
                'id': $('input#id').val(),
                'ScanDokumen': $('input#ScanDokumen').val(),
                'keterangan': quill.root.innerHTML,
            },

        };
        return data;
    },

    submit: (elm, e) => {
        e.preventDefault();
        // let params = ScanDokumen.getPostData();
        let form = $(elm).closest('div.row');
        // console.log(params);
        if (validation.runWithElement(form)) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: params,
                url: url.base_url(ScanDokumen) + "/submit",
                // url: 'http://127.0.0.1:8000/Scan-KTP/submit',
                beforeSend: () => {
                    message.loadingProses('Proses Simpan Data...');
                },
                error: function () {
                    message.closeLoading();
                    Toast.error('Informasi', "Gagal");
                },

                success: function (resp) {
                    message.closeLoading();
                    if (resp.is_valid) {
                        Toast.success('Informasi', 'Data Berhasil Disimpan');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    } else {
                        bootbox.dialog({
                            message: resp.message
                        });
                    }
                }
            });
        }
    },

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
