
$(document).ready(function() {
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust();
     });

    $('.dashboard-table').DataTable({
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        searching: false,
        'paging': false,
        fixedColumns:{
            left: 2,
            right: 1
        }
    });

    $('.user-table').DataTable({
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        'paging': false,
        fixedColumns:{
            left: 1,
            right: 1
        }
    });

    $('.unit-table').DataTable({
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        'paging': false,
        fixedColumns: {
            left: 1,
            right: 1
        },
        "columns": [
            { "width": "15%" },
            { "width": "25%" },
            null,
            null,
            null,
            null,
            null
          ]
    });

    $('.customer-table').DataTable({
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        'paging': false,
        fixedColumns:{
            left: 2,
            right: 1
        }
    });

    $('.cust-edit-table').DataTable({
        scrollY: '28vh',
        scrollX: true,
        scrollCollapse: true,
        'paging': false,
        fixedColumns:{
            left: 2,
            right: 1
        }
    });

    $('.item-table').DataTable({
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        'paging': false,
        fixedColumns:{
            left: 2,
            right: 1
        }
    });

    $('input[type="number"]').on('click', function() {
        $(this).select();
    })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $(e.target).attr("href");
    });
})





    // $('.navbar-nav').on('click', 'a', function() {
    //     $('.navbar-nav a.active').removeClass('active');
    //     $(this).addClass('active');
    // }) 