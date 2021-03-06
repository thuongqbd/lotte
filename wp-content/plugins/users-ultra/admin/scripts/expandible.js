if(typeof $ == 'undefined'){
	var $ = jQuery;
}
(function($) {
	
    $(document).ready(function () { 
	
	   "use strict";
        /*-------------------- EXPANDABLE PANELS ----------------------*/
        var panelspeed = 500; //panel animate speed in milliseconds
        var totalpanels = 3; //total number of collapsible panels   
        var defaultopenpanel = 1; //leave 0 for no panel open   
        var accordian = false; //set panels to behave like an accordian, with one panel only ever open at once      
 
        var panelheight = new Array();
        var currentpanel = defaultopenpanel;
        var iconheight = parseInt($('.icon-close-open').css('height'));
        var highlightopen = true;
         
        //Initialise collapsible panels
        function panelinit() {
                for (var i=1; i<=totalpanels; i++) {
                    panelheight[i] = parseInt($('#cp-'+i).find('.expandable-panel-content').css('height'));
                    $('#cp-'+i).find('.expandable-panel-content').css('margin-top', -panelheight[i]);
                    if (defaultopenpanel == i) {
                        $('#cp-'+i).find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                        $('#cp-'+i).find('.expandable-panel-content').css('margin-top', 0);
                    }
                }
        }
 
        $('.expandable-panel-heading').click(function() {           
            var obj = $(this).next();
            var objid = parseInt($(this).parent().attr('ID').substr(3,2));  
            currentpanel = objid;
            if (accordian == true) {
                resetpanels();
            }
             
            if (parseInt(obj.css('margin-top')) <= (panelheight[objid]*-1)) {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                obj.animate({'margin-top':0}, panelspeed);
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').addClass('header-active');
                }
            } else {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px 0px');
                obj.animate({'margin-top':(panelheight[objid]*-1)}, panelspeed); 
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').removeClass('header-active');   
                }
            }
        });
         
        function resetpanels() {
            for (var i=1; i<=totalpanels; i++) {
                if (currentpanel != i) {
                    $('#cp-'+i).find('.icon-close-open').css('background-position', '0px 0px');
                    $('#cp-'+i).find('.expandable-panel-content').animate({'margin-top':-panelheight[i]}, panelspeed);
                    if (highlightopen == true) {
                        $('#cp-'+i + ' .expandable-panel-heading').removeClass('header-active');
                    }
                }
            }
        }
		
		//add new gallery
		
		$('#add_gallery').click(function() {			
			fadeIn();
			$( "#new_gallery_div" ).slideDown( "slow", function() {			
				// Animation complete.			
			});								 
			 return false; 
    		e.preventDefault();				
        });
					
		$('body').on('click', '.display_gallery_pictures', function() {						
			var gal_id =  jQuery(this).attr("data-id");
			var page_id_val =   $('#page_id').val(); 		
					
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "reload_photos", "gal_id": gal_id  , "page_id": page_id_val },				
				success: function(data){					
					$('#xoouserultra_current_gal').text(gal_id);					
					$("#usersultra-gallerylist").html(data);														
				}
			});
		});
		
		
		$('#close_add_gallery').click(function() {					
			$( "#new_gallery_div" ).slideUp( "slow", function() {			
				// Animation complete.			
			});			
			fadeOut();	 
			 return false; 
    		e.preventDefault();				
        });
		
		//thuongqbd album video
		
		$('#add_video_gallery').click(function() {			
			fadeIn();
			$( "#new_video_gallery_div" ).slideDown( "slow", function() {			
			});								 
			 return false; 
    		e.preventDefault();				
        });
		
		$('#close_add_video_gallery').click(function() {						
			$( "#new_video_gallery_div" ).slideUp( "slow", function() {	});			
			fadeOut();
			 return false; 
    		e.preventDefault();				
        });
		
		$('#new_video_gallery_add').click(function() {	
			var gall_name = $('#new_video_gallery_name').val();
			var gall_desc = $('#new_video_gallery_desc').val();
			var user_id = $('#new_video_user_id').val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "add_new_video_gallery", "gall_name": gall_name , "gall_desc": gall_desc,"user_id":user_id },				
				success: function(data){
					fadeOut();
					$('#new_video_gallery_name').val("");
					$('#new_video_gallery_desc').val("");					
					reload_video_gallery_list();
				}
			});			
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		//end thuong 		
		$('#close_add_video').click(function() {	
			fadeOut();
			$( "#new_video_div" ).slideUp( "slow", function() {			
				// Animation complete.			
			});								 
			 return false; 
    		e.preventDefault();				
        });
		
		$('#add_new_video').click(function() {			
			fadeIn();
			$( "#new_video_div" ).slideDown( "slow", function() {			
				// Animation complete.			
			});								 
			 return false; 
    		e.preventDefault();
				
        });  
		$('#add_new_files').click(function() {			
			fadeIn();
			$( "#resp_t_image_list" ).slideDown( "slow", function() {			
				// Animation complete.			
			});								 
			 return false; 
    		e.preventDefault();
				
        });  
				
		$('#new_gallery_add').click(function() {	
			var gall_name = $('#new_gallery_name').val();
			var gall_desc = $('#new_gallery_desc').val();
			var gall_user_id = $('#new_gallery_user_id').val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "add_new_gallery", "gall_name": gall_name , "gall_desc": gall_desc,"gall_user_id":gall_user_id },				
				success: function(data){					
					$( "#new_gallery_div" ).slideUp( "slow", function() {});
					$('#new_gallery_name').text("");
					$('#new_gallery_desc').text("");
					fadeOut();					
					reload_gallery_list();						
				}
			});			
			 // Cancel the default action
			 return false;
    		e.preventDefault();							
        });
		
		//add new video confirm		
		$(document).on("click", "#new_video_add_confirm", function(e) {			
			e.preventDefault();				
			var video_name = $('#new_video_name').val();
			var video_id = $('#new_video_unique_vid').val();
			var video_desc = $('#new_video_desc').val();
			var video_gal_id = $('#new_video_gal_id').val();
			var video_image = $('#new_video_image').val();
			var video_thumb = $('#new_video_thumb').val();
			if(video_name==""){alert(video_empy_field_name);return}
			if(video_id==""){alert(video_empy_field_id);return}
			
			jQuery.getJSON('https://www.googleapis.com/youtube/v3/videos?id='+video_id+'&key=AIzaSyAB9gosCKBgclRg8urdjgyvy4RClORGrBg&part=snippet&callback=?',
					function(data){
						if (typeof(data.items[0]) != "undefined") {
							video_name = video_name?video_name:data.items[0].snippet.title;
							$('#new_video_unique_vid').closest('p').find('.error').remove();
								jQuery.ajax({
									type: 'POST',
									url: ajaxurl,
									data: {"action": "add_new_video", "video_name": video_name , "video_id": video_id , "video_desc": video_desc,"video_gal_id":video_gal_id,'video_thumb':video_thumb,'video_image':video_image },
									success: function(data){
										fadeOut();
										$('#new_video_name').val("");
										$('#new_video_unique_vid').val("");
										$('#new_video_image').val("");
										$('#new_video_thumb').val("");
										$('#new_video_div #uploadContainer').html(data);
										reload_video_list(video_gal_id);					
										}
								});
						  }else{
							  $('#new_video_unique_vid').closest('p').append('<span class="error"> Video not exits </>');
						  }   
				});						
			 // Cancel the default action
			return false;
    		e.preventDefault();			 				
        });
									
		jQuery(document).on("click", "a[href='#resp_del_photo']", function(e) {			
			e.preventDefault();			
			var photo_id =  jQuery(this).attr("id");
			var gal_id =  jQuery(this).attr("data-id");									
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "delete_photo", "photo_id": photo_id },				
				success: function(data){
					reload_photo_list(gal_id);										
				}
			});			
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
				
		//delete video		
		jQuery(document).on("click", "a[href='#resp_del_video']", function(e) {			
			e.preventDefault();			
			var doIt = false;			
			doIt=confirm(video_delete_confirmation_message);		  
			if(doIt)
			{				
				var video_id =  jQuery(this).attr("id");	
				var video_gal_id =  jQuery(this).attr("data-id");						
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "delete_video", "video_id": video_id ,"video_gal_id":video_gal_id},					
					success: function(data){
						//reload_photo_list(gal_id);
						reload_video_list(video_gal_id);												
					}
				});						
			}			
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		//close edit box
		jQuery(document).on("click", ".btn-photo-close", function(e) {			
			e.preventDefault();				
			var photo_id =  jQuery(this).attr("data-id");						
			jQuery( "#photo-edit-div-"+photo_id ).slideUp();								
			fadeOut();			
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		jQuery("body").on("click", ".btn-photo-conf", function(e) {			
			e.preventDefault();								
			var photo_id =  jQuery(this).attr("data-id");	
			var photo_name= $("#uultra_photo_name_edit_"+photo_id).val()	;
			var photo_desc =  $("#uultra_photo_desc_edit_"+photo_id).val();
			var photo_gal_id =  $("#uultra_photo_gal_id_edit_"+photo_id).val();
			var photo_tags =  $("#uultra_photo_tags_edit_"+photo_id).val();				
			var photo_category =  $("#uultra_photo_category_edit_"+photo_id).val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_photo_confirm", "photo_id": photo_id , "photo_name": photo_name , "photo_desc": photo_desc , "photo_tags": photo_tags , "photo_category": photo_category ,"photo_gal_id":photo_gal_id},
				success: function(data){										
					jQuery( "#photo-edit-div-"+photo_id ).slideUp();
					fadeOut();
					//reload_gallery_list();
				}
			});						
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		//edit photo
		jQuery(document).on("click", "a[href='#resp_edit_photo']", function(e) {			
			e.preventDefault();							
			var photo_id =  jQuery(this).attr("data-id");	
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_photo", "photo_id": photo_id },
				success: function(data){
					fadeIn();
					jQuery("#photo-edit-div-"+photo_id).html(data);						
					jQuery( "#photo-edit-div-"+photo_id ).slideDown();
				}
			});									
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
				
		//close video edit box
		jQuery(document).on("click", ".btn-video-close-conf", function(e) {			
			e.preventDefault();				
			var p_id =  jQuery(this).attr("data-id");									
			jQuery( "#video-edit-div-"+p_id ).slideUp();
			fadeOut();
			return false;
    		e.preventDefault();			 				
        });
		
		//edit video
		
		jQuery(document).on("click", "a[href='#resp_edit_video']", function(e) {			
			e.preventDefault();									
			var video_id =  jQuery(this).attr("id");	
			var video_gal_id =  jQuery(this).attr("data-id");							
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_video", "video_id": video_id,"video_gal_id":video_gal_id },
				success: function(data){
					fadeIn();
					jQuery("#video-edit-div-"+video_id).html(data);						
					jQuery( "#video-edit-div-"+video_id ).slideDown();					
					}
			});									
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
						
		//edit gallery
		jQuery(document).on("click", "a[href='#resp_edit_gallery']", function(e) {			
			e.preventDefault();									
			var gal_id =  jQuery(this).attr("data-id");	
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_gallery", "gal_id": gal_id },
				success: function(data){
					fadeIn();
					jQuery("#gallery-edit-div-"+gal_id).html(data);
					jQuery( "#gallery-edit-div-"+gal_id ).slideDown();
					}
			});									
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		//edit gallery confirm					
		jQuery(document).on("click", ".btn-gallery-conf", function(e) {		
			e.preventDefault();					
			var gal_id =  jQuery(this).attr("data-id");	
			var gal_name= $("#uultra_gall_name_edit_"+gal_id).val()	;
			var gal_desc =  $("#uultra_gall_desc_edit_"+gal_id).val();
			var gall_user_id =  $("#uultra_gall_user_id_edit_"+gal_id).val();

			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_gallery_confirm", "gal_id": gal_id , "gal_name": gal_name , "gal_desc": gal_desc , "gall_user_id": gall_user_id },
				success: function(data){																							
					$( "#gallery-edit-div-"+gal_id ).slideUp();
					fadeOut();
					reload_gallery_list();												
				}
			});						
			 // Cancel the default action
			 return false;
    		e.preventDefault();							
        });
		
		//close gallery edit box
		jQuery(document).on("click", ".btn-gallery-close-conf", function(e) {			
			e.preventDefault();				
			var p_id =  jQuery(this).attr("data-id");									
			jQuery( "#gallery-edit-div-"+p_id ).slideUp();
			fadeOut();
			return false;
    		e.preventDefault();			 				
        });
		
		//edit video gallery
		jQuery(document).on("click", "a[href='#resp_edit_video_gallery']", function(e) {			
			e.preventDefault();				
				var gal_id =  jQuery(this).attr("data-id");	
				var li = jQuery(this).closest('li');					
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "edit_video_gallery", "gal_id": gal_id },					
					success: function(data){						
						jQuery("#video-gallery-edit-div-"+gal_id).html(data);
						fadeIn();
						li.find("#video-gallery-edit-div-"+gal_id ).slideDown();												
						}
				});									
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		jQuery(document).on("click", "a[href='#resp_play_video_gallery']", function(e) {
			var gal_id =  jQuery(this).attr("data-id");	
			$('#list-video-'+gal_id+' a').first().trigger('click');
			e.preventDefault();							 				
        });
		jQuery(document).on("click", "a[href='#resp_play_gallery']", function(e) {
			var gal_id =  jQuery(this).attr("data-id");	
			$('#list-photo-'+gal_id+' a').first().trigger('click');
			e.preventDefault();							 				
        });
		//edit video gallery confirm					
		jQuery(document).on("click", ".btn-video-gallery-conf", function(e) {			
			e.preventDefault();								
			var gal_id =  jQuery(this).attr("data-id");	
			var gal_name= $("#uultra_video_gall_name_edit_"+gal_id).val()	;
			var gal_desc =  $("#uultra_video_gall_desc_edit_"+gal_id).val();
			var gal_user_id =  $("#uultra_video_gall_user_id_edit_"+gal_id).val();

			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "edit_video_gallery_confirm", "gal_id": gal_id , "gal_name": gal_name , "gal_desc": gal_desc , "gal_user_id": gal_user_id },
				success: function(data){					
					$( "#video-gallery-edit-div-"+gal_id ).slideUp();
					fadeOut();
					reload_video_gallery_list();
					}
			});			
			 // Cancel the default action
			 return false;
    		e.preventDefault();			 				
        });
		
		//close video gallery edit box
		jQuery(document).on("click", ".btn-video-gallery-close-conf", function(e) {			
			e.preventDefault();				
			var p_id =  jQuery(this).attr("data-id");									
			jQuery( "#video-gallery-edit-div-"+p_id ).slideUp();
			fadeOut();
			return false;
    		e.preventDefault();			 				
        });
		
		//edit gallery confirm					
		jQuery(document).on("click", ".btn-video-edit-conf", function(e) {
			
			e.preventDefault();		
			
			var container = $(this).closest('.uultra-video-edit');
			var video_id =  jQuery(this).attr("id");	
			var video_gal_id = jQuery(this).attr("data-id");
			var video_name= $("#uultra_video_name_edit_"+video_id).val()	;
			var video_unique_id =  $("#uultra_video_id_edit_"+video_id).val();
			var video_desc =  $("#uultra_video_desc_edit_"+video_id).val();
			var video_thumb = container.find('#new_video_thumb').val();
			var video_image = container.find('#new_video_image').val();

			jQuery.getJSON('https://www.googleapis.com/youtube/v3/videos?id='+video_unique_id+'&key=AIzaSyAB9gosCKBgclRg8urdjgyvy4RClORGrBg&part=snippet&callback=?',
				function(data){
					if (typeof(data.items[0]) != "undefined") {
						video_name = video_name?video_name:data.items[0].snippet.title;
						$("#uultra_video_id_edit_"+video_id).closest('p').find('.error').remove();
							jQuery.ajax({
								type: 'POST',
								url: ajaxurl,
								data: {
									"action": "edit_video_confirm", "video_id": video_id , 
									"video_name": video_name , "video_unique_id": video_unique_id , 
									"video_desc": video_desc ,"video_gal_id":video_gal_id,
									"video_thumb":video_thumb,"video_image":video_image
								},					
								success: function(data){																	
									$( "#video-edit-div-"+video_id ).slideUp();
									reload_video_list(video_gal_id);

									}
							});
					  }else{
						  $("#uultra_video_id_edit_"+video_id).closest('p').append('<span class="error"> Video not exits </>');
					  }   
			});
			// Cancel the default action
			return false;
			e.preventDefault();			 				
        });
		
		
		jQuery(document).on("click", "a[href='#resp_del_gallery']", function(e) {
			
			e.preventDefault();
			
			var doIt = false;
			
			doIt=confirm(gallery_delete_confirmation_message);
		  
			if(doIt)
			{
				
				var gal_id =  jQuery(this).attr("data-id");	
									
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "delete_gallery", "gal_id": gal_id },
					
					success: function(data){
						//reload_photo_list(gal_id);
						
						reload_gallery_list();
						
						
						}
				});
			
			
			}
			
			 // Cancel the default action
			 return false;
    		e.preventDefault();
			 
				
        });
		
		jQuery(document).on("click", "a[href='#resp_set_main']", function(e) {
		
			
			e.preventDefault();
			
			var photo_id =  jQuery(this).attr("id");
			var gal_id =  jQuery(this).attr("data-id");	
			
								
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "set_as_main_photo", "photo_id": photo_id , "gal_id": gal_id },
				
				success: function(data){
					reload_photo_list(gal_id);
					
					
					}
			});
			
			 // Cancel the default action
			 return false;
    		e.preventDefault();
			 
				
        });
		
		jQuery(document).on("click", "a[href='#resp_del_video_gallery']", function(e) {
			
			e.preventDefault();
			
			var doIt = false;
			
			doIt=confirm(gallery_delete_confirmation_message);
		  
			if(doIt)
			{
				
				var gal_id =  jQuery(this).attr("data-id");	
				console.log(jQuery(this),jQuery(this).attr("data-id"));					
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "delete_video_gallery", "gal_id": gal_id },
					
					success: function(data){
						//reload_photo_list(gal_id);
						
						reload_video_gallery_list();
						
						
						}
				});
			
			
			}
			
			 // Cancel the default action
			 return false;
    		e.preventDefault();
			 
				
        });
		
		jQuery(document).on("click", "a[href='#resp_set_main_video']", function(e) {
		
			
			e.preventDefault();
			
			var video_id =  jQuery(this).attr("id");
			var gal_id =  jQuery(this).attr("data-id");	
			
								
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "set_as_main_video", "video_id": video_id , "gal_id": gal_id },
				
				success: function(data){
					reload_video_list(gal_id);
					
					
					}
			});
			
			 // Cancel the default action
			 return false;
    		e.preventDefault();
			 
				
        });
		
		jQuery(document).on("click", "#btn-delete-user-avatar", function(e) {
			
			e.preventDefault();
			
    		jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "delete_user_avatar" },
					
					success: function(data){
												
						refresh_my_avatar();
						
						
						}
				});
			
			
			 // Cancel the default action
			 return false;
    		e.preventDefault();
			 
				
        });
		
		function refresh_my_avatar ()
		{
			
			 jQuery.post(ajaxurl, {
							action: 'refresh_avatar'}, function (response){									
																
							jQuery("#uu-backend-avatar-section").html(response);
									
									
					
			});
			
		}
		
 
        $(window).load(function() {
 			panelinit();
        }); //END LOAD
    }); //END READY
})(jQuery);

function reload_video_gallery_list ()
{

	var page_id_val =   jQuery('#page_id').val(); 
	 jQuery.post(ajaxurl, {
					action: 'reload_video_galleries', 'page_id':  page_id_val 

					}, function (response){


					jQuery("#usersultra-video-gallerylist").html(response);



	});



}

function reload_gallery_list ()
{

	var page_id_val =   jQuery('#page_id').val(); 
	 jQuery.post(ajaxurl, {
					action: 'reload_galleries', 'page_id':  page_id_val 

					}, function (response){


					jQuery("#usersultra-gallerylist").html(response);



	});



}

function reload_photo_list (gal_id)
{
	var page_id_val =   jQuery('#page_id').val(); 	

	 jQuery.post(ajaxurl, {
					action: 'reload_photos', 'gal_id':  gal_id,  'page_id':  page_id_val 

					}, function (response){									

					jQuery("#usersultra-photolist").html(response);

	});
}


function reload_video_list (video_gal_id)
{

	 jQuery.post(ajaxurl, {
							action: 'reload_videos','video_gal_id':video_gal_id

							}, function (response){																

							jQuery("#usersultra-videolist").html(response);


					});
}
//-------USERS PHOTO SORTABLE

function sortable_list ()
{
	 var itemList = jQuery('#usersultra-photolist');

    itemList.sortable({
        update: function(event, ui) {

            opts = {
                url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'sort_photo_list', // Tell WordPress how to handle this ajax request
                    order: itemList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
                },
                success: function(response) {
                    jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                },
                error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
                    alert(e);
                    // alert('There was an error saving the updates');
                    jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                }
            };
            $.ajax(opts);
        }
    }); 
	
}

//-------USERS GALLERY SORTABLE
function sortable_gallery_list ()
{
	 var itemList = jQuery('#usersultra-gallerylist');

    itemList.sortable({
        update: function(event, ui) {
           // $('#loading-animation').show(); // Show the animate loading gif while waiting

            opts = {
                url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'sort_gallery_list', // Tell WordPress how to handle this ajax request
                    order: itemList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
                },
                success: function(response) {
                   jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                },
                error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
                    alert(e);
                    // alert('There was an error saving the updates');
                   jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                }
            };
            jQuery.ajax(opts);
        }
    }); 
	
}

//-------USERS VIDEO SORTABLE

function sortable_video_list ()
{
	 var itemList = jQuery('#usersultra-videolist');

    itemList.sortable({
        update: function(event, ui) {

            opts = {
                url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'sort_video_list', // Tell WordPress how to handle this ajax request
                    order: itemList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
                },
                success: function(response) {
                    jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                },
                error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
                    alert(e);
                    // alert('There was an error saving the updates');
                    jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                }
            };
            $.ajax(opts);
        }
    }); 
	
}

//-------USERS VIDEO GALLERY SORTABLE
function sortable_video_gallery_list ()
{
	 var itemList = jQuery('#usersultra-video-gallerylist');

    itemList.sortable({
        update: function(event, ui) {
           // $('#loading-animation').show(); // Show the animate loading gif while waiting

            opts = {
                url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'sort_video_gallery_list', // Tell WordPress how to handle this ajax request
                    order: itemList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
                },
                success: function(response) {
                   jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                },
                error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
                    alert(e);
                    // alert('There was an error saving the updates');
                   jQuery('#loading-animation').hide(); // Hide the loading animation
                    return; 
                }
            };
            jQuery.ajax(opts);
        }
    }); 
	
}

function fadeIn(){
	jQuery('#fade').attr('style','display:block');
	jQuery( ".ui-sortable" ).sortable({disabled: true});
}
function fadeOut(){
	jQuery('#fade').attr('style','display:none');
	jQuery( ".ui-sortable" ).sortable({disabled: false});
}
jQuery(document).ready(function($) 
{ 
   if (jQuery('#usersultra-photolist').length > 0) {
	    sortable_list();
	}
	
	if (jQuery('#usersultra-gallerylist').length > 0) {
	    sortable_gallery_list();
	}
	
	if (jQuery('#usersultra-videolist').length > 0) {
	    sortable_video_list();
	}
   if (jQuery('#usersultra-video-gallerylist').length > 0) {
	    sortable_video_gallery_list();
	}
});