<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $virtue_premium;
if(!empty($virtue_premium['related_item_column'])) {$product_related_column = $virtue_premium['related_item_column'];} else {$product_related_column = '4';}
$woocommerce_loop['columns'] = $product_related_column;
						if ($product_related_column == '2') {$md = 2; $sm = 2; $xs = 1; $ss = 1;} 
				        else if ($product_related_column == '3'){ $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
			            else if ($product_related_column == '6'){ $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
				        else if ($product_related_column == '5'){ $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
				        else { $md = 4; $sm = 3; $xs = 2; $ss = 1;} 

$related = $product->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );
						
$products = new WP_Query( $args );


if ( $products->have_posts() ) : ?>

	<div class="related products carousel_outerrim">
		<?php global $virtue_premium; if(!empty($virtue_premium['related_products_text'])) {$relatedtext = $virtue_premium['related_products_text'];} else {$relatedtext = __( 'Related Products', 'virtue' );} ?>
		<h3><?php echo $relatedtext; ?></h3>
	<div class="fredcarousel">
		<div id="carouselcontainer" class="rowtight">
			<div id="related-product-carousel" class="products caroufedselclass clearfix">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

				</div>
			</div>
			<div class="clearfix"></div>
            <a id="prevport_product" class="prev_carousel icon-arrow-left" href="#"></a>
			<a id="nextport_product" class="next_carousel icon-arrow-right" href="#"></a>
		</div>
			<script type="text/javascript">
	 jQuery( window ).load(function () {
	 	var $wcontainer = jQuery('#carouselcontainer');
	 	var $container = jQuery('#related-product-carousel');
	 				setWidths();
	 				$container.carouFredSel({
							scroll: { items:1,easing: "swing", duration: 700, pauseOnHover : true},
							auto: {play: true, timeoutDuration: 9000},
							direction: "right",
							prev: '#prevport_product',
							next: '#nextport_product',
							pagination: false,
							swipe: true,
								items: {visible: null
								}
						});
		 				jQuery(window).on("debouncedresize", function( event ) {
						// set the widths on resize
						setWidths();
							$container.trigger("updateSizes");
						});

					function getUnitWidth() {
					var width;
					if(jQuery(window).width() <= 480) {
					width = $wcontainer.width() / <?php echo $ss;?>;
					} else if(jQuery(window).width() <= 767) {
					width = $wcontainer.width() / <?php echo $xs;?>;
					} else if(jQuery(window).width() <= 990) {
					width = $wcontainer.width() / <?php echo $sm;?>;
					} else {
					width = $wcontainer.width() / <?php echo $md;?>;
					}
					return width;
					}

					// set all the widths to the elements
					function setWidths() {
					var unitWidth = getUnitWidth() -1;
					$container.children().css({ width: unitWidth });
					}

});
</script>
	</div>
<?php endif;

wp_reset_postdata();
