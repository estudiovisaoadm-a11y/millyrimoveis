<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<?php
$user_ID    = get_current_user_id();
$favourites = 'no';
if ( $user_ID > 0 ) {
	$my_favorite = get_post_meta( $listingid, '_favorites', true );
	$all_users   = explode( ",", $my_favorite );
	if ( in_array( $user_ID, $all_users ) ) {
		$favourites = 'yes';
	}
}

if ( $favourites != 'yes' ) {
	?>
	<label class=" btn-add-favourites listingbookmark mt-2 pr-2"
		   id="listingbookmark<?php echo esc_html( $listingid ); ?>"><i class="fa-regular fa-heart"></i></label>
	<?php
} else {
	?>
	<label class=" btn-added-favourites listingbookmark mt-2 pr-2"
		   id="listingbookmark<?php echo esc_html( $listingid ); ?>"><i class="fa-solid fa-heart"></i></label>
	<?php
}
	