<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version	 3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

?>
<div class="rd_woo_image_ctn">
		<script type="text/javascript" charset="utf-8">
	
		var j$ = jQuery;
		j$.noConflict();
	//setup up Carousel
		j$(window).load(function() {

				var j$carousel = j$('.single_product_main_image'),
					j$pager = j$('.single_products_thumbnails');
					
j$('.single_products_thumbnails img').each(function(i) {
		j$(this).addClass( 'itm'+i );
		
		/* add onclick event to thumbnail to make the main 
		carousel scroll to the right slide*/
		j$(this).click(function() {
			j$('.single_product_main_image').trigger( 'slideTo', [i, 0, true] );
			return false;
		});
	});

		j$('.single_products_thumbnails img.itm0').addClass( 'selected' );
	

				j$carousel.carouFredSel({
					synchronise: ['.single_products_thumbnails', false], 
					responsive: true,
					auto: false,
					height:"variable",
					prev: ".product_nav_left",
					next: ".product_nav_right",
					scroll: {
			fx: 'directscroll',
			onBefore: function() {
				/* Everytime the main slideshow changes, it check to 
					make sure thumbnail and page are displayed correctly */
				/* Get the current position */
				var pos = j$(this).triggerHandler( 'currentPosition' );
				
				/* Reset and select the current thumbnail item */
				j$('.single_products_thumbnails img').removeClass( 'selected' );
				j$('.single_products_thumbnails img.itm'+pos).addClass( 'selected' );

				/* Move the thumbnail to the right page */
			}},
					width: "100%",
					height:"variable",
					items: {
						visible: 1,
					height:"variable",
						}
					
					
					
				});
				j$pager.carouFredSel({
					width: '100%',  
					auto: false,
					height: "92%",
					items: {
						min:4,
					},
                    direction:"up",
				});
				
				j$('.single_product_main_image').css('opacity','1' );
				j$('.single_products_thumbnails').css('opacity', '1' );
				
				j$('.single_product_main_image').find('div').eq(0).addClass('images' );
			
j$(".woo_img_next").click(function() { 
			j$(".single_products_thumbnails, .single_product_main_image").trigger( "next" ); 
		});
		j$(".woo_img_prev").click(function() { 
			j$(".single_products_thumbnails, .single_product_main_image").trigger( "prev" ); 
		});
				});
	
	</script>
	<div class="product_image_wrapper <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
    <div class="product_nav_left"></div>
    <div class="product_nav_right"></div>
	<div class="single_product_main_image woocommerce-product-gallery__wrapper">
		<?php
		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		if ( has_post_thumbnail() ) {
			$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '"  rel="prettyPhoto[rel-666]">';
			$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
			$html .= '</a></div>';
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
							$attachment_ids = $product->get_gallery_image_ids();

					$loop = 0;

					foreach ( $attachment_ids as $attachment_id ) {
						$classes[] = 'image-'.$attachment_id;

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( ! $image_link )
							continue;

						$image	   = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_thumbnail_size', 'shop_single' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );

						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" rel="prettyPhoto[rel-666]">%s</a></div>', $image_link, $image_title, $image ), $attachment_id, $post->ID, $image_class );
						//echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

						$loop++;
					}

		?>
</div>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
