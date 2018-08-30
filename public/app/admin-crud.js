var action;
var table;

$(function () {

    table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:site_url+'/admin-crud/anyData',
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
                    return '<button class="btn btn-xs btn-success" onclick=edit("' + row.id + '")><i class="fa fa-edit"></i></button> '+
                           '<button class="btn btn-xs btn-danger" onclick=remove("' + row.id + '")><i class="fa fa-remove"></i></button>'
                }
            },
        ],
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    })

    $("#addBtn").click(function(){
        action = "Add";
        $("#modal-title").text("Add User");
        $('#pass-div').show();
        $("form").trigger("reset");
        $("#input-modal").modal("show");
    });

    $("#saveBtn").click(function () {
        var url = site_url+"/admin-crud/add";
        if(action == "Edit"){
            url = site_url+"/admin-crud/update";
        }

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
    });

    $("#confirmBtn").click(function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:site_url+"/admin-crud/delete",
            type:"POST",
            data:{id:$('[name="deleteId"]').val()},
            dataType:"json",
            success:function(response){
                reload();
                $("#confirm-modal").modal("hide");
            }
        });
    });

});

function reload(){
    table.ajax.reload();
}

function edit(id){
    action = "Edit";
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
    $('[name="deleteId"]').val(id);
    $("#confirm-modal").modal("show");
}
