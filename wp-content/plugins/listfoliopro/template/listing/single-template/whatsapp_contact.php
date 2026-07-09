<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	$whatsapp=get_post_meta($listingid, 'whatsapp', true);
	$viber= get_post_meta($listingid, 'viber', true);
if($whatsapp!='' OR  $viber!=''){	
?>
<div class="sidebar-border">	
<?php			
	if(array_key_exists('whatsapp',$active_single_fields_saved)){ 				
	?>	
	<span class="card-time ml-3">
		<?php
		if($whatsapp!='' ){
		?>
		<p>
		<img class="whatsapp-size mr-1" src="<?php echo esc_url(listfoliopro_ep_URLPATH."/assets/images/whatsapp.png"); ?>">
			<a class="font-md " href="https://wa.me/<?php echo esc_html($whatsapp); ?>?text=<?php esc_html_e( "I'm interested in services", 'listfoliopro' ); ?>"><?php esc_html_e( 'Chat via WhatsApp', 'listfoliopro' ); ?></a>
		</p>
		<?php
		}
		?>
		<?php
		if($viber!='' ){
		?>
		<p><img class="whatsapp-size mr-2" src="<?php echo esc_url(listfoliopro_ep_URLPATH."/assets/images/viber.png"); ?>"><a class="font-md " href="viber://chat?number=<?php echo esc_html($viber); ?>&amp;text=<?php esc_html_e( "I'm interested in services", 'listfoliopro' ); ?>"><?php esc_html_e( 'Chat via Viber', 'listfoliopro' ); ?></a></p>
		<?php
		}
		?>
	</span>
	<?php
		}
	?>	
</div>
<?php
}
?>