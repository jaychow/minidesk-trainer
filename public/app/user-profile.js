
$(function () {

    var getDetails = function(){
        $.ajax({
            url:site_url+"/profile/getDetails",
            type:"GET",
            dataType:"json",
            success:function(response){
                $("#d-name").text(response.name);
                $("#d-email").text(response.email);
                $("#name").val(response.name);
                $("#email").val(response.email);
            }
        });
    }

    getDetails();

    var validator = $( "#form1" ).validate( {
        rules: {
            name: "required",
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true,
                remote: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'post',
                    url: site_url+'/profile/checkEmail',
                    data: {
                        email : function(){
                            return $('[name="email"]').val()
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

    var validator2 = $( "#form2" ).validate( {
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
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


    var resetForm2 = function(){
        $('#form2')[0].reset();
        $('#form2 .form-control').removeClass('is-invalid');
        $('#form2 .form-control').removeClass('is-valid');
        validator2.resetForm();
    }

    $("#updateBtn1").click(function(){
        if($("#form1").valid()){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:site_url+"/profile/update",
                type:"POST",
                data:$("#form1").serialize(),
                dataType:"json",
                success:function(response){
                    getDetails();
                    swal("Details updated successfully", {
                        icon: "success",
                    });
                }
            });
        }
    });

    $("#updateBtn2").click(function(){
        if($("#form2").valid()){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:site_url+"/profile/updatePassword",
                type:"POST",
                data:$("#form2").serialize(),
                dataType:"json",
                success:function(response){
                    resetForm2();
                    swal("Password changed successfully", {
                        icon: "success",
                    });
                }
            });
        }
    });


});
