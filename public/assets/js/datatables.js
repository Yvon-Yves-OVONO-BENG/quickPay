$(function(e) {
	//file export datatable
	var table = $('#example').DataTable({
		lengthChange: true,
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
		language: {
			searchPlaceholder: 'Search...',
			scrollX: "100%",
			sSearch: '',
			lengthMenu: '_MENU_ ',
		}
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );		
	
	$('#example1').DataTable({
		language: {
			searchPlaceholder: 'Search...',
			scrollX: "100%",
			sSearch: '',
			lengthMenu: '_MENU_',
		}
	});
	$('#example2').DataTable({
		language: {
			searchPlaceholder: 'Search...',
			scrollX: "100%",
			sSearch: '',
			lengthMenu: '_MENU_',
		}
	});
	$('#Invoicedatatable').DataTable({
		language: {
			searchPlaceholder: 'Search...',
			scrollX: "100%",
			sSearch: '',
			lengthMenu: '_MENU_',
		}
	});
	//______Delete Data Table
	var table = $('#delete-datatable').DataTable({
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
		}
	}); 
    $('#delete-datatable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
	
	//Details display datatable
	$('#example-1').DataTable( {
		language: {
			searchPlaceholder: 'Search...',
			scrollX: "100%",
			sSearch: '',
			lengthMenu: '_MENU_',
		},
	} );
});