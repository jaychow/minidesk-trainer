$(function () {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: site_url+'/data-import/anyData',
        columns: [
            { data: 'trade_date', name: 'trade_date' },
            { data: 'open_bid', name: 'open_bid' },
            { data: 'high_bid', name: 'high_bid' },
            { data: 'low_bid', name: 'low_bid' },
            { data: 'close_bid', name: 'close_bid' }
        ],
        columnDefs: [
            {
                targets: [1, 2, 3, 4],
                className: 'text-right'
            }
        ]
    })
  })
