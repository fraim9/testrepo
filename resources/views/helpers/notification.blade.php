
@push('scripts')
	
	<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
	
	<script>
		jQuery(function(){ 
			
          @if(session()->has('success'))
        	  One.helpers("notify", {
            	  type: "success", 
            	  icon: "fa fa-check mr-1", 
            	  message: "{{ session()->get('success') }}",
            	  delay: 2000,
              });
          @endif
        
          @if(session()->has('info'))
        	  One.helpers("notify", {
            	  type: "info", 
            	  icon: "fa fa-info-circle mr-1", 
            	  message: "{{ session()->get('success') }}",
            	  delay: 2000,
              });
          @endif
        
          @if(session()->has('warning'))
        	  One.helpers("notify", {
            	  type: "warning", 
            	  icon: "fa fa-exclamation mr-1", 
            	  message: "{{ session()->get('success') }}",
            	  delay: 2000,
              });
          @endif
        
          @if(session()->has('error'))
        	  One.helpers("notify", {
            	  type: "danger", 
            	  icon: "fa fa-exclamation mr-1", 
            	  message: "{{ session()->get('success') }}",
            	  delay: 2000,
              });
          @endif

		});
	</script>
@endpush