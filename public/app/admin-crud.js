$(function () {
    $(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:site_url+'/admin-crud/anyData',
                type:"POST"
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' }
            ]
        })
      })
  })
