<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
	wp_enqueue_script("jquery");
wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
wp_enqueue_style('listfoliopro_style-login', listfoliopro_ep_URLPATH . 'admin/files/css/login.css');

?>

  <div id="login-2" class="bootstrap-wrapper">
   <div class="menu-toggler sidebar-toggler">
   </div>   
   <div class="content-real">
   
    <form id="login_form" class="login-form" action="" method="post">
      <h3 class="form-title"><?php   esc_html_e('Sign In','listfoliopro');?></h3>
      <div class="display-hide" id="error_message">

      </div>
      <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php   esc_html_e('Username','listfoliopro');?></label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php esc_attr_e('Username','listfoliopro'); ?>" name="username" id="username"/>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9"><?php   esc_html_e('Password','listfoliopro');?></label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php esc_attr_e('Password','listfoliopro'); ?>" name="password" id="password"/>
      </div>
      <div class="form-actions row">
      <div class="col-md-4">
        <button type="button" class="btn btn-custom uppercase pull-left" onclick="return listfoliopro_chack_login();" ><?php   esc_html_e('Login','listfoliopro');?></button>
      </div>
      <p class="pull-left  margin-20 para col-md-4">
      
      </p>
        <p class="pull-left margin-20 para col-md-4">
        <a href="javascript:;" class="forgot-link"><?php   esc_html_e('Forgot Password?','listfoliopro');?> </a>
        </p>
      </div>
    <div class="create-account">
          <p><?php
			$iv_redirect = get_option('listfoliopro_price_table');
			$reg_page= get_permalink( $iv_redirect);
			?>
            <a  href="<?php echo esc_url($reg_page);?>" id="register-btn" class="uppercase"><?php   esc_html_e('Create an account','listfoliopro');?>  </a>
          </p>
        </div>

    </form>
    
    <form id="forget-password" name="forget-password" class="forget-form" action="" method="post" >
      <h3><?php   esc_html_e('Forget Password ?','listfoliopro');?>  </h3>
	  <div id="forget_message">
		<p>
        <?php   esc_html_e('Enter your e-mail address','listfoliopro');?>
      </p>

      </div>
      <div class="form-group">
        <input class="form-control form-control-solid placeholder-no-fix" type="text"  placeholder="<?php esc_attr_e('Email','listfoliopro'); ?>" name="forget_email" id="forget_email"/>
      </div>
      <div class="">
        <button type="button" id="back-btn" class="btn margin-b-30"><?php   esc_html_e('< Back','listfoliopro');?> </button>
        <button type="button" onclick="return listfoliopro_forget_pass();"  class="btn btn-custom uppercase pull-right margin-b-30"><?php   esc_html_e('Submit','listfoliopro');?> </button>
      </div>
    </form>
    </div>
    </div>
<?php
wp_enqueue_script('listfoliopro_login', listfoliopro_ep_URLPATH . 'admin/files/js/login.js');
wp_localize_script('listfoliopro_login', 'real_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'forget_sent'=> esc_html__('Password Sent. Please check your email.','listfoliopro'),
		'login_error'=> esc_html__('Invalid Username & Password.','listfoliopro'),
		'login_validator'=> esc_html__('Enter Username & Password.','listfoliopro'),
		'forget_validator'=> esc_html__('Enter Email Address','listfoliopro'),
		'listfoliopro'=> wp_create_nonce("listfoliopro"),
		
		) );
  
?>	
  
