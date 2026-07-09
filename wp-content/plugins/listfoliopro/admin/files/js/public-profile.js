 "use strict";
 jQuery(document).ready(function(){   
	jobbank_profile_block_resize();
	
	jQuery(window).on('resize', function(){
		jobbank_profile_block_resize();
	});   
})
function jobbank_profile_block_resize(){ 
		var listingdata_width= jQuery("#iv_prifile_div").width();
		
	   if(listingdata_width<700 ){
			jQuery( ".profile-col1" ).removeClass( "col-lg-8" );
			jQuery( ".profile-col1" ).addClass( "col-xl-12 col-md-12 col-lg-12 " );	
			
			jQuery( ".profile-col2" ).removeClass( "col-lg-4" );
			jQuery( ".profile-col2" ).addClass( "col-xl-12 col-md-12 col-lg-12 " );	
	   }
}
jQuery(document).ready(function(){
	
	 jQuery('#authorbookmark').on('click', function(e){ 
	   var isLogged =listfoliopro1.current_user_id;
	   var p_id =jQuery("#profileID").val();
	   
		if (isLogged=="0") {
			alert(listfoliopro1.Please_login);
		} else {
			  if(jQuery('#authorbookmark').hasClass('btn btn-big')){
				var search_params={
						"action" 	: 	"listfoliopro_author_bookmark_delete",
						"data"	 	: 	"id="+p_id,
						"_wpnonce"	: listfoliopro1.dirwpnonce,
					};
					jQuery.ajax({
						url : listfoliopro1.ajaxurl,
						dataType : "json",
						type : "post",
						data : search_params,
						success : function(response){						
							if (response.msg=="success") {
								jQuery("#authorbookmark").removeClass('btn btn-big').addClass('btn btn-border');
								jQuery('#authorbookmark').prop('title', listfoliopro1.Add_to_Boobmark);		
							}
						}
					});
							
			  }else if(jQuery('#authorbookmark').hasClass('btn btn-border')){			
						
					var search_params={
						"action" 	: 	"listfoliopro_author_bookmark",
						"data"	 	: 	"id="+p_id,
						"_wpnonce"	: listfoliopro1.dirwpnonce,
					};
					jQuery.ajax({
						url : listfoliopro1.ajaxurl,
						dataType : "json",
						type : "post",
						data : search_params,
						success : function(response){						
							if (response.msg=="success") {
								jQuery("#authorbookmark").removeClass('btn btn-border').addClass('btn btn-big');
								jQuery('#authorbookmark').prop('title', listfoliopro1.Added_to_Boobmark);		
							}
						}
					});
			  } 
	  
		}
	 });
	  
	 
	 

 });
 function listfoliopro_contact_close(){
	  "use strict";
		jQuery.colorbox.close();
} 
function listfoliopro_author_email_popup(user_id){	
	"use strict";
		var contactform =listfoliopro1.ajaxurl+'?action=listfoliopro_author_email_popup&user_id='+user_id;
		jQuery.colorbox({href: contactform,opacity:"0.70",closeButton:false,});
}

