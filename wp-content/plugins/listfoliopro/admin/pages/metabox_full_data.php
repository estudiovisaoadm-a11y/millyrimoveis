<?php
global $wpdb, $post;
global $current_user;
$main_class = new listfoliopro_eplugins;
wp_enqueue_script( "jquery" );
wp_enqueue_style( 'jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css' );
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-ui-datepicker' );
wp_enqueue_style( 'bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css' );
wp_enqueue_style( 'listfoliopro-my-account-css', listfoliopro_ep_URLPATH . 'admin/files/css/my-account.css' );
wp_enqueue_style( 'listfoliopro-my-account-new-css', listfoliopro_ep_URLPATH . 'admin/files/css/my-account-new.css' );
wp_enqueue_style( 'listfoliopro-metabox-style', listfoliopro_ep_URLPATH . 'admin/files/css/metabox-style.css' );
wp_enqueue_script( 'bootstrap.min', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js' );
wp_enqueue_script( 'popper', listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js' );

// Map openstreet
wp_enqueue_script( 'leaflet', listfoliopro_ep_URLPATH . 'admin/files/js/leaflet.js' );
wp_enqueue_style( 'leaflet', listfoliopro_ep_URLPATH . 'admin/files/css/leaflet.css' );
wp_enqueue_script( 'leaflet-geocoder-locationiq', listfoliopro_ep_URLPATH . 'admin/files/js/leaflet-geocoder-locationiq.min.js' );
wp_enqueue_style( 'leaflet-geocoder-locationiq', listfoliopro_ep_URLPATH . 'admin/files/css/leaflet-geocoder-locationiq.min.css' );
$listfoliopro_directory_url = get_option( 'listfoliopro_ep_url' );
if ( $listfoliopro_directory_url == "" ) {
	$listfoliopro_directory_url = 'listing';
}
$curr_post_id = $post->ID;

$current_post = $curr_post_id;
$post_edit    = get_post( $curr_post_id );
?>
    <div class="bootstrap-wrapper">
        <div id="profile-account2" class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="listfoliopro-metabox-section-wrapper logo-banner-metabox-section">
                        <span class="caption-subject">
                            <?php esc_html_e( 'Feature Image', 'listfoliopro' ); ?>
                        </span>
                        <hr>

                        <div class="row">
                            <div class=" col-md-12">
                                <div class=" col-md-6" id="post_image_div10">
			                        <?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $curr_post_id ), 'thumbnail' );
			                        if ( isset( $feature_image[0] ) ) { ?>
                                        <img title="profile image" class=" img-responsive "
                                             src="<?php echo esc_url( $feature_image[0] ); ?>">
				                        <?php
			                        }
			                        $feature_image_id = get_post_thumbnail_id( $curr_post_id );
			                        ?>
                                </div>
                                <div class=" form-group col-md-6">
                                    <div class="" id="post_image_edit">
                                        <button type="button" onclick="listfoliopro_edit_post_image('post_image_div10');"
                                                class="btn btn-small-ar"><?php esc_html_e( 'Feature Image', 'listfoliopro' ); ?> </button>
                                    </div>
                                </div>
                            </div>                 
                        </div>
                    </div>
					<div class="listfoliopro-metabox-section-wrapper image-gallery-metabox-section">
                    <span class="caption-subject">
                        <?php esc_html_e( 'Image Gallery', 'listfoliopro' ); ?>
                    </span>

                        <hr/>

                        <div class="row">
                            <div class="  form-group col-md-12">
								<?php
								$gallery_ids       = get_post_meta( $curr_post_id, 'image_gallery_ids', true );
								$gallery_ids_array = array_filter( explode( ",", $gallery_ids ) );
								?>
                                <input type="hidden" name="gallery_image_ids" id="gallery_image_ids"
                                       value="<?php echo esc_attr( $gallery_ids ); ?>">
                                <div class="row" id="gallery_image_div">
									<?php
									if ( sizeof( $gallery_ids_array ) > 0 ) {
										foreach ( $gallery_ids_array as $slide ) {
											?>
                                            <div id="gallery_image_div<?php echo esc_html( $slide ); ?>" class="col-md-2">
                                                <div class="metabox-img-gallery-item">
                                                    <img class="img-responsive" src="<?php echo esc_url( wp_get_attachment_url( $slide ) ); ?>">
                                                    <button type="button"
                                                            onclick="listfoliopro_remove_gallery_image('gallery_image_div<?php echo esc_html( $slide ); ?>', <?php echo esc_html( $slide ); ?>);"
                                                            class="btn btn-sm btn-danger"><?php esc_html_e( 'X', 'listfoliopro' ); ?>
                                                    </button>
                                                </div>

                                            </div>
											<?php
										}
									}
									?>
                                </div>
                                <button type="button" onclick="listfoliopro_edit_gallery_image('gallery_image_div');"
                                        class="btn btn-small-ar"><?php esc_html_e( 'Add Images', 'listfoliopro' ); ?></button>
                                </label>
                            </div>
                        </div>
						<div class=" row form-group ">	
							<div class=" col-md-12 form-group">
								<label for="text" class=" control-label"><?php  esc_html_e('360 Image URL','listfoliopro'); ?></label>
								<input type="text" class="form-control" name="360_image" id="360_image" value="<?php echo esc_attr(get_post_meta($post_edit->ID,'360_image',true));?>" placeholder="<?php  esc_html_e('Enter 360 image URL','listfoliopro'); ?>">
							</div>
						</div>	
                    </div>
			


                    <div class="listfoliopro-metabox-section-wrapper pricing-metabox-section">
                        <span class="caption-subject">
                            <?php esc_html_e( 'Pricing', 'listfoliopro' ); ?>
                        </span>
                        <hr>

                        <div class="row">
							<div class=" col-md-4 form-group">
								<label for="text" class=" control-label"><?php  esc_html_e('Price Prefix Text','listfoliopro'); ?></label>
								<input type="text" class="form-control" name="price_prefix_text" id="price_prefix_text" value="<?php echo esc_attr(get_post_meta($post_edit->ID,'price_prefix_text',true));?>" placeholder="<?php  esc_html_e('e.g. $/ euro ','listfoliopro'); ?>">
							</div>
                            <div class=" col-md-4 form-group">
                                <label for="text" class=" control-label"><?php esc_html_e( 'Price', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="price" id="price"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'price', true ) ); ?>"
                                       placeholder="<?php esc_html_e( 'Enter Price ', 'listfoliopro' ); ?>">
                            </div>
                            <div class="col-md-4  form-group">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Discount Price', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="discount" id="discount"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'discount', true ) ); ?>"
                                       placeholder="<?php esc_html_e( 'Enter Discount Price', 'listfoliopro' ); ?>">
                            </div>
                        </div>
                    </div>
					<div class="listfoliopro-metabox-section-wrapper business-hour-metabox-section"> 
                        <span class="caption-subject">
					    <?php esc_html_e( 'Listing Details ', 'listfoliopro' ); ?>
                        </span>
                        <hr/>
                         <div id="listfoliopro_fields">
							
							<?php
								$currentCategory = wp_get_object_terms( $post_edit->ID, $listfoliopro_directory_url . '-category' );
							$post_cats       = array();
							foreach ( $currentCategory as $c ) {
								array_push( $post_cats, $c->slug );
							}
							
							echo '' . $main_class->listfoliopro_listing_fields( $post_edit->ID, $post_cats );
							?>
                        </div>
                    </div>

                    <div class="listfoliopro-metabox-section-wrapper contact-info-metabox-section">
                        <span class="caption-subject">
                            <?php esc_html_e( 'Contact Info', 'listfoliopro' ); ?>
                        </span>

                        <hr/>

						<?php
						$listing_contact_source = get_post_meta( $post_edit->ID, 'listing_contact_source', true );
						if ( $listing_contact_source =='' ) {
							$listing_contact_source = 'new_value';
						}
						?>

                        <div class=" form-group">
                            <div class="radio">
                                <label><input type="radio" name="contact_source"
                                              value="user_info" <?php echo( $listing_contact_source == 'user_info' ? 'checked' : '' ); ?> > <?php esc_html_e( ' Use The company Info ->', 'listfoliopro' ); ?> <?php echo ucfirst( $current_user->display_name ); ?><?php esc_html_e( ' : Logo, Email, Phone, Website', 'listfoliopro' ); ?>
                                    <a href="<?php echo get_permalink() . '?profile=setting'; ?>"
                                       target="_blank"> <?php esc_html_e( 'Edit', 'listfoliopro' ); ?> </a></label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="contact_source"
                                              value="new_value" <?php echo( $listing_contact_source == 'new_value' ? 'checked' : '' ); ?>><?php esc_html_e( ' New Contact Info', 'listfoliopro' ); ?>
                                </label>
                            </div>
                        </div>

                        <div class="row"
                             id="new_contact_div" <?php echo( $listing_contact_source == 'user_info' ? 'class="displaynone"' : '' ); ?> >
                            <div class=" form-group col-md-12">
                                <div class="" id="post_image_div">
									<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $curr_post_id ), 'thumbnail' );
									if ( isset( $feature_image[0] ) ) { ?>
                                        <img title="profile image" class=" img-responsive"
                                             src="<?php echo esc_url( $feature_image[0] ); ?>">
										<?php
									} else { ?>
                                        <a href="javascript:void(0);"
                                           onclick="listfoliopro_edit_post_image('post_image_div');">
											<?php echo '<img src="' . esc_url( listfoliopro_ep_URLPATH . 'assets/images/image-add-icon.png' ) . '">'; ?>
                                        </a>
										<?php
									}
									$feature_image_id = get_post_thumbnail_id( $curr_post_id );
									?>
                                </div>

                                <div class="" id="post_image_edit">
                                    <button type="button" onclick="listfoliopro_edit_post_image('post_image_div');"
                                            class="btn btn-small-ar"><?php esc_html_e( 'Add/Edit Agent Image', 'listfoliopro' ); ?> </button>
                                </div>
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Agent Name', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                       value="<?php echo esc_html( get_post_meta( $post_edit->ID, 'company_name', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Agent name', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Phone', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'phone', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Phone Number', 'listfoliopro' ); ?>">
                            </div>

                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'WhatsApp', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'whatsapp', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter WhatsApp Number', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Viber', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="viber" id="viber"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'viber', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Viber Number', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Email Address', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="contact-email" id="contact-email"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'contact-email', true ) ); ?>"
                                       placeholder="<?php esc_html_e( 'Enter Email Address', 'listfoliopro' ); ?>">
                            </div>
                            
							
							<div class=" form-group col-md-12">
									<label for="text" class=" control-label"><?php  esc_html_e('Address (Save in the listing field)','listfoliopro'); ?></label>
									
									<input type="text" class="form-control" name="address" id="address" value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'address', true ) ); ?>"  placeholder="<?php  esc_html_e('Enter Address','listfoliopro'); ?>">
									<div id="autocomplete-results"></div>	
							</div>

                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'City', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="city" id="city"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'city', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter city', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'State', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="state" id="state"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'state', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter State', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Zipcode/Postcode', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="postcode" id="postcode"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'postcode', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Zipcode/Postcode', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Country', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="country" id="country"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'country', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Country', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Latitude ', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'latitude', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Latitude', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Longitude', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'longitude', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Longitude', 'listfoliopro' ); ?>">
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Web Site', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="contact_web" id="contact_web"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'contact_web', true ) ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter Web Site', 'listfoliopro' ); ?>">
                            </div>
                        </div>
                        <input type="hidden" name="feature_image_id" id="feature_image_id"
                               value="<?php echo esc_attr( $feature_image_id ); ?>">
                    </div>


                    <div class="listfoliopro-metabox-section-wrapper video-metabox-section">
                    <span class="caption-subject">
                        <?php esc_html_e( 'Videos ', 'listfoliopro' ); ?>
                    </span>

                        <hr/>

                        <div class="row">
                            <div class=" col-md-6 form-group">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'Youtube', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="youtube" id="youtube"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'youtube', true ) ); ?>"
                                       placeholder="<?php esc_html_e( 'Enter Youtube video ID, e.g : bU1QPtOZQZU ', 'listfoliopro' ); ?>">
                            </div>
                            <div class="col-md-6  form-group">
                                <label for="text"
                                       class=" control-label"><?php esc_html_e( 'vimeo', 'listfoliopro' ); ?></label>
                                <input type="text" class="form-control" name="vimeo" id="vimeo"
                                       value="<?php echo esc_attr( get_post_meta( $post_edit->ID, 'vimeo', true ) ); ?>"
                                       placeholder="<?php esc_html_e( 'Enter vimeo ID, e.g : 134173961', 'listfoliopro' ); ?>">
                            </div>
                        </div>
                    </div>


                    
                    <div class="listfoliopro-metabox-section-wrapper attach-doc-metabox-section">
                <span class="caption-subject">
                    <?php esc_html_e( 'Attached Doc', 'listfoliopro' ); ?>
                </span>
                        <hr/>

						<?php
						$attached_ids       = get_post_meta( $post_edit->ID, 'attached_ids', true );
						$attached_ids_array = array_filter( explode( ",", $attached_ids ) );
						?>
                        <input type="hidden" name="attached_ids" id="attached_ids"
                               value="<?php echo esc_attr( $attached_ids ); ?>">
                        <div id="attached_div">
							<?php
							if ( is_array( $attached_ids_array ) ) {
								foreach ( $attached_ids_array as $slide ) {
									$filename_only = basename( get_attached_file( $slide ) );
									?>
                                    <div id="attached_div<?php echo esc_attr( $slide ); ?>" class="row mb-2">
                                        <label class="col-md-11 control-label"><?php echo esc_html( $filename_only ); ?></label>
                                        <div class="col-md-1">
                                            <button type="button"
                                                    onclick="listfoliopro_remove_attached_doc('attached_div<?php echo esc_attr( $slide ); ?>', <?php echo esc_attr( $slide ); ?>);"
                                                    class="btn btn-small-ar"><?php esc_html_e( 'X', 'listfoliopro' ); ?> </button>
                                        </div>
                                    </div>
									<?php
								}
							}
							?>
                        </div>

                        <div class="row">
                            <div class="  form-group col-md-12">
                                <button type="button" onclick="listfoliopro_attached_doc('attached_div');"
                                        class="btn btn-small-ar mt-2"><?php esc_html_e( 'Add Attachments', 'listfoliopro' ); ?></button>
                                </label>
                            </div>

                        </div>
                    </div>
					

					
                    
					<div class="clearfix"></div>	
					 <div class="listfoliopro-metabox-section-wrapper video-metabox-section">
							<span class="caption-subject">	
								<?php  esc_html_e('What’s Nearby ','listfoliopro'); ?>
							</span>								
							<hr/>
							<datalist id="neat_whats"> 
							  <option value="Shop">
							  <option value="School">
							  <option value="University">
							  <option value="Airport">
							  <option value="City center">
							  <option value="Hospital">
							  <option value="CPT stop">
							 </datalist> 
								<?php					
								$facilities = get_post_meta($post_edit->ID ,'public_facilities',true);
								if($facilities!=''){?>						
								<?php	
									$i=1;
									if(sizeof($facilities)>0){
										foreach($facilities as $key => $item){
											$facilities_one = explode("|", $item);	
											echo '<div  class="row mb-2" id="old_facilities'. esc_attr($i) .'">
											<div class="col-md-6"><span class="caption-subject">'.esc_html($key).'</div> <div class="col-md-5"> <h5>: '.esc_html($facilities_one[0]).'</span></div><div class="col-md-1"> <button type="button" onclick="remove_facilities('.esc_html($i).');"  class="btn btn-xs btn-danger">X</button> 												
											</div>
											<input type="hidden" name="facilities_name[]" id="facilities_name[]" value="'.esc_html($key).'">
											<input type="hidden" name="facilities_value[]" id="facilities_value[]" value="'.esc_attr($facilities_one[0]).'"></div>';
											$i++;
											}	
									}										
								}
							?>	
							
							<div id="public_facilities_div">
								<div class=" row form-group " id="public_facilities_row1" >									
									<div class=" col-md-6"> 
										<input type="text" list="neat_whats"  placeholder="<?php  esc_html_e ('What’s Nearby ','listfoliopro'); ?>" name="facilities_name[]" id="facilities_name[]"  class="form-control" />										
									</div>		
									<div  class=" col-md-6">
										<input type="text" class="form-control"  name="facilities_value[]" id="facilities_value[]"  placeholder="<?php  esc_html_e('Enter KM or time','ivproperty'); ?>">
									</div>
								</div>
							</div>
							<div class=" row  form-group ">
								<div class="col-md-12" >	
									<button type="button" onclick="listfoliopro_add_public_facilities();"  class="btn btn-small-ar"><?php  esc_html_e('Add More','ivproperty'); ?></button>
								</div>
							</div>	
					</div>
					
					<hr/>		
							<div class="clearfix"></div>	
							<span class="caption-subject">	
								<?php  esc_html_e('Time','listfoliopro'); ?>
							</span>								
							<hr/>
							<div class="row mt-2">
								<?php							
									include( listfoliopro_ep_template. 'private-profile/listing-open-close-time.php');
									?>		
							</div>
					<hr/>	
					
					  <div class="listfoliopro-metabox-section-wrapper video-metabox-section">
					<span class="caption-subject">
						<?php esc_html_e( 'Social Profile ', 'listfoliopro' ); ?>
					</span>
                        <hr/>					

                        <div class="row">
							<?php
							include( listfoliopro_ep_template . 'private-profile/profile-social.php' );
							?>
                        </div>
                    </div>
					
					
					
					
					
              
                </div>
            </div>
            <input type="hidden" name="listing_data_submit" id="listing_data_submit" value="yes">
        </div>
    </div>
    <!-- END PROFILE CONTENT -->
<?php
$save_address = get_post_meta( $curr_post_id, 'address', true );

$my_theme     = wp_get_theme();
$theme_name   = strtolower( $my_theme->get( 'Name' ) );
wp_enqueue_script( 'listfoliopro_add-edit-listing', listfoliopro_ep_URLPATH . 'admin/files/js/add-edit-listing.js' );
wp_localize_script( 'listfoliopro_add-edit-listing', 'realpro_data', array(
	'ajaxurl'           => admin_url( 'admin-ajax.php' ),
	'loading_image'     => '<img src="' . listfoliopro_ep_URLPATH . 'admin/files/images/loader.gif">',
	'current_user_id'   => get_current_user_id(),
	'Set_Feature_Image' => esc_html__( 'Set Feature Image', 'listfoliopro' ),
	'Set_plan_Image'    => esc_html__( 'Set Image ', 'listfoliopro' ),
	'Set_Event_Image'   => esc_html__( ' Set Image ', 'listfoliopro' ),
	'Gallery Images'    => esc_html__( 'Gallery Images', 'listfoliopro' ),
	'save_address'      => $save_address,
	'permalink'         => get_permalink(),
	'dirwpnonce'        => wp_create_nonce( "addlisting" ),
	'theme_name'        => $theme_name,
) );
	
	 					