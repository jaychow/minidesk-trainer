var action;
var table;
var validator;

$(function () {
    table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:site_url+'/manage-admin/anyData',
            type:"POST"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            {
                mRender: function (data, type, row) {
                    return '<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit" onclick=edit("' + row.id + '")><i class="fas fa-edit"></i></button> '+
                           '<button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Reset Password" onclick=resetPassword("' + row.id + '")><i class="fas fa-key"></i></button> '+
                           '<button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick=remove("' + row.id + '")><i class="fas fa-trash-alt"></i></button>'
                }
            },
        ],
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false
            },
            {
                targets: [ 1, 2, 3, 4, -1],
                className: 'dt-head-center'
            }
        ]
    })

    validator = $( "#form" ).validate( {
        rules: {
            name: "required",
            name: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true,
                remote: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'post',
                    url: site_url+'/manage-admin/checkEmail',
                    data: {
                        email : function(){
                            return $('[name="email"]').val()
                        },
                        id : function () {
                            return $('[name="id"]').val()
                        }
                    },
                    dataType: 'json',

                }

            }
        },
        messages: {
            name: "Please enter your firstname",
            name: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: {
                required: "Please provide an email",
                email: "Please enter a valid email address",
                remote: "Email already in use"
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

    $("#addBtn").click(function(){
        action = "Add";
        $("[name='id']").val("");
        resetForm();
        $("#modal-title").text("Add User");
        $('#pass-div').show();
        $("form").trigger("reset");
        $("#input-modal").modal("show");
    });

    $("#saveBtn").click(function () {

        var url = site_url+"/manage-admin/add";
        if(action == "Edit"){
            url = site_url+"/manage-admin/update";
        }

        if($("#form").valid()){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:url,
                type:"POST",
                data:$("#form").serialize(),
                dataType:"json",
                success:function(response){
                    reload();
                    $("#input-modal").modal("hide");
                }
            });
        }

    });

});

function reload(){
    table.ajax.reload();
}

function edit(id){
    action = "Edit";
    resetForm();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:site_url+"/admin/getDetailsById",
        type:"POST",
        data:{
            id:id
        },
        dataType:"json",
        success:function(response){
            $("#modal-title").text("Edit User");
            $("#input-modal").modal("show");
            $.each(response, function(k, v){
                if(k == "name" || k == "email"){
                    $('[name="'+k+'"]').val(v);
                }
            });
            $('[name="id"]').val(id);
            $('[name="password"]').val("12345678");
            $('#pass-div').hide();
        }
    });
}

function remove(id){
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this user!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:site_url+"/manage-admin/delete",
                type:"POST",
                data:{id:id},
                dataType:"json",
                success:function(response){
                    reload();
                }
            });
        }
      });
}

function resetPassword(id){
    swal({
        title: "Are you sure?",
        text: "Password will be reset to 12345678!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:site_url+"/manage-admin/resetPassword",
                type:"POST",
                data:{id:id},
                dataType:"json",
                success:function(response){
                    swal("Password reset to 12345678", {
                        icon: "success",
                    });
                }
            });
        }
      });
}

function resetForm(){
    $('#form')[0].reset();
    $('#form .form-control').removeClass('is-invalid');
    $('#form .form-control').removeClass('is-valid');
    validator.resetForm();
}
