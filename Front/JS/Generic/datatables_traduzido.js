$(document).ready( function () {

    $('#report-buildings').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
        ],
        "pageLength": 200,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        }
    } );
} );