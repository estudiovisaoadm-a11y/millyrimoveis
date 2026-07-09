"use strict";
var ajaxurl = listfoliopro_data_message.ajaxurl;
var loader_image =listfoliopro_data_message.loading_image;
function listfoliopro_user_message(){
	"use strict";
	var formc = jQuery("#message-pop");

		if (jQuery.trim(jQuery("#email_address",formc).val()) == "" || jQuery.trim(jQuery("#message-content",formc).val()) == "") {
				alert(listfoliopro_data_message.Please_put_your_message);
		} else {
		var ajaxurl = listfoliopro_data_message.ajaxurl;
		var loader_image =listfoliopro_data_message.loading_image;
		jQuery('#update_message_popup').html(loader_image);
		var search_params={
			"action"  : 	"listfoliopro_message_send",
			"form_data":	jQuery("#message-pop").serialize(),
			"_wpnonce":  	listfoliopro_data_message.contact,
		};
		jQuery.ajax({
			url : ajaxurl,
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				jQuery('#update_message_popup').html(response.msg );
				jQuery("#message-pop").trigger('reset');
			}
		});
	}
}