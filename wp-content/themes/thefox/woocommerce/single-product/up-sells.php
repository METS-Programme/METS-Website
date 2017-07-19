<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop;



if ( $upsells ) : ?>

	<div class="upsells products">
    	<div class="upsells_nav">
  <p class="upsells_left"></p>
  <p class="upsells_right"></p>
</div>

		<h2><?php _e( '<strong>You may</strong> also like&hellip;', 'thefoxwp' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
