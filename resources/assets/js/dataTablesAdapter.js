/**
 * 
 */


class dataTablesAdapter
{
	
	constructor()
	{
		
		jQuery(function(){
			// Override a few default classes
	        jQuery.extend(jQuery.fn.dataTable.ext.classes, {
	            sWrapper: "dataTables_wrapper dt-bootstrap4",
	            sFilterInput:  "form-control form-control-sm",
	            sLengthSelect: "form-control form-control-sm"
	        });
	
	        // Override a few defaults
	        jQuery.extend(true, jQuery.fn.dataTable.defaults, {
	        	processing: true,
	        	colReorder: true,
                orderCellsTop: true,
	        	pageLength: 25,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                stateSave: true,
                stateSaveCallback: function(settings,data) {
                	localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
                },
                stateLoadCallback: function(settings) {
                	return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
                },
	            language: {
	                lengthMenu: "_MENU_",
	                search: "_INPUT_",
	                searchPlaceholder: "Search..",
	                info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
	                paginate: {
	                    first: '<i class="fa fa-angle-double-left"></i>',
	                    previous: '<i class="fa fa-angle-left"></i>',
	                    next: '<i class="fa fa-angle-right"></i>',
	                    last: '<i class="fa fa-angle-double-right"></i>'
	                }
	            },
	            buttons: [
					{
			            extend: 'print',
			            text: '<i class="si si-printer"></i>'
			        },
			        {
			            extend: 'colvis',
			            text: '<i class="si si-eye mr-1"></i>'
			        },
			    ],
			    dom:"<'row'<'col-sm-12 col-md-1'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
	        });
		});
        
	}
	
	init(obj, filterUrl, tableOptions)
	{
		// Init full DataTable
        var oTable = obj.dataTable(tableOptions);
        var $this = this;
        obj.on( 'column-visibility.dt', function ( e, settings, column, state ) {
        	$this.initFilter(obj, oTable, filterUrl);
        });
        this.initFilter(obj, oTable, filterUrl);
	}
	
	initFilter(obj, oTable, filterUrl)
	{
		console.log('initFilter');
		
		var timerId = null;
        obj.find('thead tr input, thead tr select').off().on( 'keyup keypress cut paste change input clear', function () {
			var control = $(this);
			clearTimeout(timerId);
			timerId = setTimeout(function() {
					var data = {};
					data[control.attr('name')] = control.val();
                	axios.get(filterUrl, {
                			params: data
                		})
                		.then(function (response) {
                			oTable.fnDraw();
                		})
                		.catch(function (error) {
                	  		console.log(error);
                		});
				}, 500);
        });
	}
	
	
}

export const dtAdapter = new dataTablesAdapter()

