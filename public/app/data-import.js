var table;

$(function () {

    table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:site_url+'/data-import/anyData',
            type:"POST"
        },
        columns: [
            { data: 'trade_date', name: 'trade_date' },
            { data: 'open_bid', name: 'open_bid' },
            { data: 'high_bid', name: 'high_bid' },
            { data: 'low_bid', name: 'low_bid' },
            { data: 'close_bid', name: 'close_bid' },
            { data: 'volume', name: 'volume' },
        ],
        columnDefs: [
            {
                targets: [1, 2, 3, 4, -1],
                className: 'dt-body-right'
            },
            {
                targets: [0, 1, 2, 3, 4, -1],
                className: 'dt-head-center'
            }
        ]
    });

    $("#openBtn").click(function(){
        resetForm();
        $("#input-modal").modal("show");
    });

    validator = $( "#form" ).validate( {
        rules: {
            sample_file: {
                required: true,
                extension: "xls|xlsx|csv"
            }
        },
        messages: {
            sample_file: {
                required: "Please choose a file",
                extension: "File must be xlsx, xls, or csv file"
            }
        },
        errorElement: "div",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "invalid-feedback" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
    } );

    $("#importBtn").click(function(){
        if($("#form").valid()){
            var formData = new FormData($("#form")[0]);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: site_url+"/data-import/import-file",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend: function(){
                    $("#importBtn").html('<i class="fa fa-spinner fa-spin"></i> Import');
                    $("#closeBtn, #importBtn").attr('disabled', 'disabled');
                },
                success: function (response) {
                    $("#importBtn").html('Import');
                    $("#closeBtn, #importBtn").removeAttr('disabled');
                    $("#input-modal").modal("hide");
                    swal("Data imported successfully", {
                        icon: "success",
                    });
                },

            });
        }
    });


  })

function reload_table(){
    table.ajax.reload();
}

function resetForm(){
    $('#form')[0].reset();
    $('#form .form-control').removeClass('is-invalid');
    $('#form .form-control').removeClass('is-valid');
    validator.resetForm();
}
