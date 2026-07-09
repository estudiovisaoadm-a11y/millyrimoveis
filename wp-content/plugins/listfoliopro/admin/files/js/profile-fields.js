"use strict";
var ajaxurl = profile_data.ajaxurl;
var loader_image = profile_data.loading_image;
var signup_serial= profile_data.signup_field_serial;

jQuery(window).on('load',function(){
		if (jQuery("#all_fieldsdatatable")[0]){	
		jQuery('#all_fieldsdatatable').show();
		
		var oTable = jQuery('#all_fieldsdatatable').dataTable({			
			"pageLength": 25,			
			"language": {
				"sProcessing": 		profile_data.sProcessing ,
				"sSearch": 			'',
				"searchPlaceholder" : profile_data.sSearch,
				"lengthMenu":		profile_data.lengthMenu ,
				"zeroRecords": 		profile_data.zeroRecords,
				"info": 			profile_data.info,
				"infoEmpty": 		profile_data.infoEmpty,
				"infoFiltered":		profile_data.infoFiltered ,
				
				"oPaginate": {
					"sFirst":   	profile_data.sFirst,
					"sLast":    	profile_data.sLast,
					"sNext":   		profile_data.sNext ,
					"sPrevious":	profile_data.sPrevious,
				},
			},
			
			responsive: true,
			}
		);
		
	}
	if (jQuery("#listing_fieldsdatatable")[0]){	
		jQuery('#listing_fieldsdatatable').show();
		var oTable = jQuery('#listing_fieldsdatatable').dataTable({
			 "ordering": false,
			"pageLength": 25,			
			"language": {
				"sProcessing": 		profile_data.sProcessing ,
				"sSearch": 			'',
				"searchPlaceholder" : profile_data.sSearch,
				"lengthMenu":		profile_data.lengthMenu ,
				"zeroRecords": 		profile_data.zeroRecords,
				"info": 			profile_data.info,
				"infoEmpty": 		profile_data.infoEmpty,
				"infoFiltered":		profile_data.infoFiltered ,
				
				"oPaginate": {
					"sFirst":   	profile_data.sFirst,
					"sLast":    	profile_data.sLast,
					"sNext":   		profile_data.sNext ,
					"sPrevious":	profile_data.sPrevious,
				},
			},
			
			responsive: true,
			
			}
		);		
	}
	
});
function listfoliopro_add_listingfield(){
	"use strict";
		var wpdatatable = jQuery('#listing_fieldsdatatable').DataTable();		
		var catall = jQuery('#fieldcat-main').html();
		var inputtypell= jQuery('#fieldtypemainblank').html();	
		
		
		
		wpdatatable.row.add( [
			'<div class="row mt-2">'+
				'<label class="col-md-6 col-6">'+profile_data.InputName+'</label>'+
				'<input type="text" class="form-control col-md-6 col-6" name="meta_name[]" id="meta_name[]" value="">'+ 	
			'</div>'+
			'<div class="row mt-2">'+
				'<label class="col-md-6 col-6">'+profile_data.Label+'</label>'+
				'<input type="text" class="form-control col-md-6 col-6" name="meta_label[]" id="meta_label[]" value="">'+ 	
			'</div>'+
			'<div class="row mt-2">'+
				'<div class="col-md-3 col-6"><button type="button" onclick="return  listfoliopro_field_image_fun('+profile_data.pi+');" class="button button-primary mt-1">'+profile_data.set_image+'</button></div>'+
				'<div class="col-md-3 col-6" id="meta_image_display'+ profile_data.pi+'"></div>'+
				'<input type="text" class="form-control col-md-6 col-12" name="meta_image[]" id="meta_image'+profile_data.pi+'" value="">'+ 	
			'</div>'+
			'<div class="row mt-2">'+
				'<label class="col-md-6 col-6">'+profile_data.Type+'</label>'+
				inputtypell + 	
			'</div>'+
			'<div class="row mt-2">'+
				'<label class="col-md-12 col-12">'+profile_data.ValueDropdownLabel+'</label>'+
				'<textarea class="form-control col-md-12 col-12 ml-3" rows="3" name="field_type_value[]" id="field_type_value[]" ></textarea>'+ 	
			'<div class="col-md-12 mt-2 "> <button type="button" class="btn btn-danger btn-sm"  onclick="return listfoliopro_remove_listingfield('+profile_data.pi+');"  ><span  class="dashicons dashicons-trash ml-1"></span></button></div></div>', catall
			
        ] ).node().id = 'wpdatatablelistingfield_'+profile_data.pi;
		
		
		
		wpdatatable.draw(false );	
	profile_data.pi=profile_data.pi+1;	
}
function listfoliopro_remove_listingfield(div_id){
	"use strict";
		var table = jQuery('#listing_fieldsdatatable').DataTable();
		table.row("#wpdatatablelistingfield_"+div_id).remove().draw();

	
}
function listfoliopro_add_profile_field(){
	"use strict";
		var wpdatatable = jQuery('#all_fieldsdatatable').DataTable();		
		let  roleall = jQuery('#roleall_0').html();				
		var main_role_select_name_new='field_user_role'+signup_serial;		 
		var new_roleall= roleall.replace('field_user_role0', main_role_select_name_new);
		
		var inputtypell= jQuery('#inputtypell_0').html();		
		wpdatatable.row.add( [
            '<div class="row mt-2"><label class="col-md-6 col-6">'+profile_data.Label+'</label><input type="text" class="form-control form-control col-md-6 col-6" name="meta_name[]" id="meta_name[]" value="profile-field'+signup_serial+'"></div>'+
            '<div class="row mt-2"><label class="col-md-6 col-6">'+profile_data.Type+'</label><input type="text" class="form-control  col-md-6 col-6" name="meta_label[]" id="meta_label[]" value="profile-field'+signup_serial+'" >'+
            inputtypell+
            '</div><div class="row mt-2"><label class="col-md-12 col-12">'+profile_data.ValueDropdownLabel+'</label> <textarea class="form-control ml-2 mr-2" rows="3" name="field_type_value[]" id="field_type_value[]" ></textarea></div> <div class="row mt-2"><button class="btn btn-danger btn-xs ml-2" onclick="return listfoliopro_remove_field('+signup_serial+');">X</button></div>',
            '<div class="row"><div class="col-12 col-md-12 col-lg-6 mb-2">'+
			new_roleall+'</div><div class="col-12 col-md-12 col-lg-6 mb-2">'+
			'<p><label><input type="checkbox" name="signup'+signup_serial+'" id="signup'+signup_serial+'" value="yes" > '+profile_data.Registration+'</label></p>'+
			'<p><label><input type="checkbox" name="myaccountprofile'+signup_serial+'" id="myaccountprofile'+signup_serial+'" value="yes"   class="text-center"> '+profile_data.MyAccountProfile+'</label></p>'+
			'<p><label><input type="checkbox" name="srequire'+signup_serial+'" id="srequire'+signup_serial+'" value="yes"   class="text-center"> '+profile_data.Require+'</label></p><div></div>',		
        ] ).node().id = 'wpdatatablefield_'+signup_serial;
		
	wpdatatable.draw(false );	
	signup_serial=parseInt(signup_serial)+1;	
	
	
}

function listfoliopro_update_profile_signup_fields(){
	"use strict";
	var search_params = {
		"action": 		"listfoliopro_update_profile_signup_fields",
		"form_data":	jQuery("#profile_fields_signup").serialize(),
		"_wpnonce":  	profile_data.adminnonce,
	};
	jQuery.ajax({
		url: profile_data.ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {              		
			jQuery('#success_message_profile').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');		   						
				
		}
	});
}

function listfoliopro_remove_field(div_id){
	"use strict";
	jQuery("#wpdatatablefield_"+div_id).fadeOut(500, function(){ jQuery(this).remove();});
	signup_serial=parseInt(signup_serial)-1;
}
function listfoliopro_add_menu(){
	"use strict";
	jQuery('#custom_menu_div').append('<div class="row form-group " id="menu_'+profile_data.pii+'"><div class=" col-sm-3"> <input type="text" class="form-control" name="menu_title[]" id="menu_title[]" value="" placeholder="'+profile_data.EnterMenuTitle+'"> </div>	<div  class=" col-sm-7"><input type="text" class="form-control" name="menu_link[]" id="menu_link[]" value="" placeholder="'+profile_data.EnterMenuLink+'"></div><div  class=" col-sm-2"><button class="btn btn-danger btn-xs" onclick="return listfoliopro_remove_menu('+profile_data.pii+');">'+profile_data.Delete+'</button>');
	profile_data.pii=profile_data.pii+1;		
}
function listfoliopro_remove_menu(div_id){
	"use strict";
	jQuery("#menu_"+div_id).remove();
}	
