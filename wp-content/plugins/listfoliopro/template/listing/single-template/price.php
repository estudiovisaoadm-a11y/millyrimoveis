<?php
if (!defined('ABSPATH')) exit;

if (get_post_meta($listingid, 'price', true) != '') {
	?>
    <div class="listfoliopro-listing-price">

		<?php if (get_post_meta($listingid, 'discount', true) != '') { ?>
			<?php
			$previousPrice = floatval(preg_replace('/[^\d.]/', '', get_post_meta($listingid, 'price', true)));
			$currentPrice = floatval(preg_replace('/[^\d.]/', '', get_post_meta($listingid, 'discount', true)));

			// Calculate the discount
			$discount = $previousPrice - $currentPrice;

			if ($discount > 0) {
				$discountPercentage = ($discount / $previousPrice) * 100;
				?>
                <strike class="listfoliopro-main-price"><?php echo esc_html(get_post_meta($listingid, 'price', true)); ?></strike>
                <span class="listfoliopro-discount-price"><?php echo esc_html(get_post_meta($listingid, 'discount', true)); ?></span>
                <span class="saved-percentage">
                    <?php
                    echo __('Save ', 'listfoliopro') . number_format($discountPercentage, 2) . "% " . __('Now', 'listfoliopro');
                    ?>
                </span>
			<?php } ?>
		<?php } else { ?>
			<?php echo esc_html(get_post_meta($listingid, 'price', true)); ?>
		<?php } ?>

    </div>
	<?php
}
?>

