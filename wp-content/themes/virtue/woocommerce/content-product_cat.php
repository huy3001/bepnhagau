<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $virtue_premium;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}
// Increase loop count
$woocommerce_loop['loop']++;
if(is_shop() || is_product_category() || is_product_tag()) {
	if(isset($virtue_premium['product_cat_layout'])) {$product_cat_column = $virtue_premium['product_cat_layout'];} else { $product_cat_column = 4; }
} else {
	 if ( empty( $woocommerce_loop['columns'] ) )
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	$product_cat_column = $woocommerce_loop['columns'];
}

						   if ($product_cat_column == '1') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $catimgwidth = 600; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
 						   else if ($product_cat_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $catimgwidth = 600; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
		                   else if ($product_cat_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $catimgwidth = 400; $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
		                   else if ($product_cat_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $catimgwidth = 240; $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
		                   else if ($product_cat_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $catimgwidth = 240; $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
		                   else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-4 tcol-ss-6'; $catimgwidth = 300; $md = 4; $sm = 3; $xs = 3; $ss = 2;}
		                   if(!is_shop() && !is_product_category() && !is_product_tag()) {
							$woocommerce_loop['columns'] = $product_cat_column;
							}
		if(isset($virtue_premium['product_cat_img_ratio'])) {$img_ratio = $virtue_premium['product_cat_img_ratio'];} else {$img_ratio = 'widelandscape';}
		if($img_ratio == 'portrait') {
					$tempcatimgheight = $catimgwidth * 1.35;
					$catimgheight = floor($tempcatimgheight);
		} else if($img_ratio == 'landscape') {
					$tempcatimgheight = $catimgwidth / 1.35;
					$catimgheight = floor($tempcatimgheight);
		} else if($img_ratio == 'square') {
					$catimgheight = $catimgwidth;
		} else {
			$tempcatimgheight = $catimgwidth / 2;
			$catimgheight = floor($tempcatimgheight);
		}
		?> 

<div class="<?php echo esc_attr($itemsize); ?> kad_product">
<div class="product-category grid_item">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_subcategory_title', $category );
		?>
		<?php
		if($img_ratio == 'off') {
					do_action( 'woocommerce_before_subcategory_title', $category );
				} else {
					$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
			 
			        if ( $thumbnail_id ) {
			            $image_cat_url = wp_get_attachment_image_src( $thumbnail_id, 'full');
			            $image_cat_url = $image_cat_url[0];
			            $cat_image = aq_resize($image_cat_url, $catimgwidth, $catimgheight, true);
			            if(empty($cat_image)) {$cat_image = $image_cat_url;}
			        } else {
			            $cat_image = virtue_img_placeholder_cat();
			         }
			 
			        if ( $cat_image ) {
			            echo '<img src="' . $cat_image . '" alt="' . $category->name . '" />';
			        }
    	}
     ?>

		<h5>
			<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h5>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>
</div>