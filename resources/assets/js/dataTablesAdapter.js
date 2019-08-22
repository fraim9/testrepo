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
	        	scrollX: true,
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
			            text: '<i class="si si-printer"></i>',
			            className: 'd-none d-sm-inline-block',
			        },
			        {
			            extend: 'colvis',
			            text: '<i class="si si-eye mr-1"></i>'
			        },
			    ],
			    dom:"<'row'<'col-6 col-sm-2'l><'col-6 col-md-5 text-sm-left text-right'B><'col-12 col-sm-5'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
        
        var resizeTimerId = null;
        window.addEventListener('resize', function(){
        	clearTimeout(resizeTimerId);
        	resizeTimerId = setTimeout(function(){
        		oTable.fnDraw();
        	}, 500);
        });
        
        jQuery(window).on('sidebarMiniStateChanged', function(state) {
        	oTable.fnDraw();
        });
	}
	
	initFilter(obj, oTable, filterUrl)
	{
		// из-за scrollX: true таблица разделяется на две таблицы - шапка отдельно и тело отдельно
		var elements = obj.parents('.dataTables_scroll').find('.dataTables_scrollHead input, .dataTables_scrollHead select');
		
		var timerId = null;
		elements.off().on( 'keyup keypress cut paste change input clear', function () {
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
		
		One.helpers(['select2']);
	}
	
	
}

export const dtAdapter = new dataTablesAdapter()

