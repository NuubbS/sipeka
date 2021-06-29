// $(document).ready(function() {
        $('.select_buku').select2({
            ajax: {
                url: "<?= base_url('administrator/getDataBuku_Select'); ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    console.log(params.term)
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Buku yang Akan Dipinjam',
            minimumInputLength: 3,
        });
    // });