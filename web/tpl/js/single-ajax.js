 jQuery(document).ready(function($){
	 jQuery('#claimform').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });
	 
	  jQuery('#claimformmobile').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });
	 
	 
	 
	 jQuery('#contactOwner').on('submit', function(e){
		
		$this = jQuery(this);
		$this.find('.lp-search-icon').removeClass('fa-send');	
		$this.find('.lp-search-icon').addClass('fa-spinner fa-spin');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_contactowner', 
                'formData': formData, 
			},   
            success: function(res){
				if(res.result==="fail"){
					jQuery.each(res.errors, function (k, v) {
						if(k==="email"){
							jQuery("input[name='email7']").addClass('error-msg');
						}
						if(k==="message"){
							jQuery("textarea[name='message7']").addClass('error-msg');
						}
						if(k==="name7"){
							jQuery("input[name='name7']").addClass('error-msg');
						}
						$this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');	
						$this.find('.lp-search-icon').addClass('fa-cross');
						//$this.append(res.state);
					});
				}
				else{
					$this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');	
					$this.find('.lp-search-icon').addClass('fa-check');
					//$this.append(res.state);
					$this[0].reset();
				}
            }
        });
		//return false;
		 //alert(formData);

	 });
	 
	 
/* jquery ajax code for expired listing plan change */
	jQuery('.lp-change-plan-btn').on('click', function(e){
		var listing_id = '';
		listing_id = jQuery(this).data('listingid');
		jQuery('#select-plan-form input#listing_id' ).val(listing_id);
		e.preventDefault();
	});
	jQuery('#select-plan-form').submit(function(event){
		var plan_id = '';
		listing_id = '';
		plan_id = jQuery("input[name='plans-posts']:checked").val();
		listing_id = jQuery("input[name='listing-id']").val();
		
		if( typeof(plan_id)  !== "undefined" ){
			jQuery("div.lp-expire-update-status").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_change_plan', 
					'plan_id': plan_id, 
					'listing_id': listing_id, 
				},   
				success: function(data){
					jQuery('#select-plan-form')[0].reset();

					if(data.error==="error"){
						var htmldata = '<p class="alert alert-danger">'+data.status+'</p>';
						jQuery("div.lp-expire-update-status").html('');
						jQuery("div.lp-expire-update-status").html(htmldata);
					}
					else{
						var htmldata = '<p class="alert alert-success">'+data.status+'</p>';
						jQuery("div.lp-expire-update-status").html('');
						jQuery("div.lp-expire-update-status").html(htmldata);
					}
				}
			});
			
		}
		event.preventDefault();
	})
	 
 });