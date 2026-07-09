<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );
wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
$id=$dir_id;
$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
?>
<div id="popup-contact">		
    <div class="row" >
        <div class="col-md-12" id="listing-contact">
           
                <form action="#" id="message-pop" name="message-pop"   method="POST" >
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <input  class="form-control" id="name" name="name" type="text" placeholder="<?php esc_html_e('Name*', 'listfoliopro');?>">
                        </div>

                        <div class="form-group col-lg-12">
                            <input class="form-control"  name="email_address" id="email_address" type="text"placeholder="<?php esc_html_e('Email*', 'listfoliopro');?>">
                        </div>

                        <div class="form-group col-lg-12">
                            <input  class="form-control" id="visitorphone" name="visitorphone" type="text" placeholder="<?php esc_html_e('Phone*', 'listfoliopro');?>">
                        </div>

                        <div class="form-group col-12">
                            
                            <textarea class="col-md-12 form-control" name="message-content" id="message-content"  cols="50" rows="4" placeholder="<?php esc_html_e('Message*', 'listfoliopro');?>"></textarea>
                        </div>

                        <div class="col-12 text-right">
                            <button type="button" class="listfoliopro-button"  onclick="listfoliopro_contact_send_message_iv();" ><?php  esc_html_e( 'Send Message', 'listfoliopro' ); ?>
                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
							<input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_attr($listingid);?>">
                            <div class="ml-2" id="update_message_popup"></div>
                        </div>
                    </div>
                </form>
         
        </div>
    </div>
</div>