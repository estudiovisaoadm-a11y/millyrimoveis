<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
 $post_edit_ID = (isset($post_edit->ID)?$post_edit->ID: '0' );
?>

	<div class="col-md-6  form-group">
		<label for="text" class="col-md-12 control-label"><?php  esc_html_e('Facebook','listfoliopro'); ?></label>
		<input type="text" class=" col-md-12 form-control" name="facebook" id="facebook" value="<?php echo esc_url(get_post_meta($post_edit_ID,'facebook',true));?>" placeholder="<?php  esc_attr_e('Enter Facebook link ','listfoliopro'); ?>">
	</div>
	<div class="col-md-6  form-group">
		<label for="text" class="col-md-12 control-label"><?php  esc_html_e('Linkedin','listfoliopro'); ?></label>
		<input type="text" class="col-md-12 form-control" name="linkedin" id="linkedin" value="<?php echo esc_url(get_post_meta($post_edit_ID,'linkedin',true));?>" placeholder="<?php  esc_html_e('Enter linkedin link','listfoliopro'); ?>">
	</div>
	<div class="col-md-6  form-group">
		<label for="text" class="col-md-12 control-label"><?php  esc_html_e('Instagram','listfoliopro'); ?></label>
		<input type="text" class="col-md-12 form-control" name="instagram" id="instagram" value="<?php echo esc_url(get_post_meta($post_edit_ID,'instagram',true));?>" placeholder="<?php  esc_html_e('Enter instagram link','listfoliopro'); ?>">
	</div>
	<div class="col-md-6  form-group">
		<label for="text" class="col-md-12 control-label"><?php  esc_html_e('Twitter','listfoliopro'); ?></label>
		<input type="text" class="col-md-12 form-control" name="twitter" id="twitter" value="<?php echo esc_url(get_post_meta($post_edit_ID,'twitter',true));?>" placeholder="<?php  esc_html_e('Enter twitter link','listfoliopro'); ?>">
	</div>
	



