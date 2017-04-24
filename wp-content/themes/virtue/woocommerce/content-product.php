<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $virtue_premium;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

$product_column = $woocommerce_loop['columns'];
						if ($product_column == '1') {$itemsize = 'tcol-md-12 tcol-sm-12 tcol-xs-12 tcol-ss-12'; $productimgwidth = 300;}
 						else if ($product_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $productimgwidth = 300;} 
		                else if ($product_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $productimgwidth = 400;} 
		                else if ($product_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $productimgwidth = 240;} 
		                else if ($product_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $productimgwidth = 240;} 
		                else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $productimgwidth = 300;}
// Extra post classes
$classes = array();
if(isset($virtue_premium['shop_hide_action']) && $virtue_premium['shop_hide_action'] == 1) {
$classes[] = 'hidetheaction';
}
$classes[] = 'grid_item';
$classes[] = 'product_item';
$classes[] = 'clearfix';
$classes[] = 'kad_product_fade_in';
$classes[] = 'kt_item_fade_in';
if(isset($virtue_premium['product_img_resize']) && $virtue_premium['product_img_resize'] == 0) {
	$resizeimage = 0;
} else {
	$resizeimage = 1;
		if(isset($virtue_premium['shop_img_ratio'])) {$img_ratio = $virtue_premium['shop_img_ratio'];} else {$img_ratio = 'square';}
		if($img_ratio == 'portrait') {
					$tempproductimgheight = $productimgwidth * 1.35;
					$productimgheight = floor($tempproductimgheight);
		} else if($img_ratio == 'landscape') {
					$tempproductimgheight = $productimgwidth / 1.35;
					$productimgheight = floor($tempproductimgheight);
		} else if($img_ratio == 'widelandscape') {
					$tempproductimgheight = $productimgwidth / 2;
					$productimgheight = floor($tempproductimgheight);
		} else {
					$productimgheight = $productimgwidth;
		}
}
if(isset($virtue_premium['product_img_flip']) && $virtue_premium['product_img_flip'] == 0) {
	$productimgflip = 0;
} else {
	$productimgflip = 1;
}
$terms = get_the_terms( $post->ID, 'product_cat' );
if ( $terms && ! is_wp_error( $terms ) ) : 
	$links = array();
	foreach ( $terms as $term ) {$links[] = $term->slug;}
	$links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
	$links = str_replace(' ', '-', $links);	
	$tax = join( " ", $links );		
	else :	
	$tax = '';	
endif;
?>
<div class="<?php echo esc_attr($itemsize);?> <?php echo strtolower($tax);?> kad_product">
	<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<?php echo woocommerce_show_product_loop_sale_flash($post, $product); ?>
	<a href="<?php the_permalink(); ?>" class="product_item_link product_img_link">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' ); ?> 

			<?php if($productimgflip == 1 && $resizeimage == 1) { 
				$attachment_ids = $product->get_gallery_attachment_ids();
				if ( $attachment_ids ) {$flipclass = "kad-product-flipper";} else {$flipclass = "kad-product-noflipper";}
				echo '<div class="'.$flipclass.'">';
				if ( has_post_thumbnail() ) {
					$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
					$product_image_url = $product_image[0]; 
					$image_product = aq_resize($product_image_url, $productimgwidth, $productimgheight, true);
	            	if(empty($image_product)) {$image_product = $product_image_url;} ?> 
	            	 <div class="kad_img_flip image_flip_front"><img width="<?php echo $productimgwidth;?>" height="<?php echo $productimgheight;?>" src="<?php echo $image_product;?>" class="attachment-shop_catalog wp-post-image" alt="<?php the_title();?>"></div>
	           	
	           	<?php }
					if ( $attachment_ids ) {
						$secondary_image_id = $attachment_ids['0'];
						$second_product_image_url = wp_get_attachment_image_src( $secondary_image_id, 'full');
						$second_product_image_url = $second_product_image_url[0]; 
						$second_image_product = aq_resize($second_product_image_url, $productimgwidth, $productimgheight, true);
		            	if(empty($second_image_product)) {$second_image_product = $second_product_image_url;}
						echo '<div class="kad_img_flip image_flip_back"><img width="'.$productimgwidth.'" height="'.$productimgheight.'" src="'.$second_image_product.'" class="attachment-shop_catalog wp-post-image" alt="'.get_the_title().'"></div>';
					}
					echo '</div>';
			} else if ( $resizeimage == 1 ) {
					echo '<div class="kad-product-noflipper">';
					if ( has_post_thumbnail() ) {
					$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
					$product_image_url = $product_image[0]; 
					$image_product = aq_resize($product_image_url, $productimgwidth, $productimgheight, true);
	            	if(empty($image_product)) {$image_product = $product_image_url;} ?> 
	            	 <img width="<?php echo esc_attr($productimgwidth);?>" height="<?php echo esc_attr($productimgheight);?>" src="<?php echo esc_url($image_product);?>" class="attachment-shop_catalog wp-post-image" alt="<?php the_title();?>">
	           	<?php }
	           	echo '</div>';
			} else { 
				echo '<div class="kad-woo-image-size">';
				echo woocommerce_template_loop_product_thumbnail();
				echo '</div>';
         }?>
             </a>
            <div class="details_product_item">
			<div class="product_details">
				<a href="<?php the_permalink(); ?>" class="product_item_link">
				<?php 
				/**
			 	* woocommerce_shop_loop_item_title hook
			 	*
			 	* @hooked woocommerce_template_loop_product_title - 10
			 	*/
				do_action( 'woocommerce_shop_loop_item_title' );
				?>
				</a>
				<?php if(isset($virtue_premium['shop_excerpt']) && $virtue_premium['shop_excerpt'] == 1) {
				} else { ?>
					<div class="product_excerpt">
						<?php global $post; 
						if ($post->post_excerpt){
							echo apply_filters( 'archive_woocommerce_short_description', $post->post_excerpt );
						} else {
							the_excerpt();
						} ?>
					</div>
				<?php } ?>
			</div>
		
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>


	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>

</div>
</div>