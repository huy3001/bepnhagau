<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop, $virtue_premium;
if(!empty($virtue_premium['related_item_column'])) {$product_related_column = $virtue_premium['related_item_column'];} else {$product_related_column = '4';}
$woocommerce_loop['columns'] = $product_related_column;
						if ($product_related_column == '2') {$md = 2; $sm = 2; $xs = 1; $ss = 1;} 
				        else if ($product_related_column == '3'){ $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
			            else if ($product_related_column == '6'){ $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
				        else if ($product_related_column == '5'){ $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
				        else { $md = 4; $sm = 3; $xs = 2; $ss = 1;} 

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

if ( $products->have_posts() ) : ?>

	<div class="upsells products carousel_outerrim">
		<h3><?php _e( 'You may also like&hellip;', 'woocommerce' ) ?></h3>
	<div class="fredcarousel">
		<div id="carouselcontainer" class="rowtight">
			<div id="upsale-product-carousel" class="products clearfix">
				<?php //woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php woocommerce_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php //woocommerce_product_loop_end(); ?>
				</div>
			</div>
			<div class="clearfix"></div>
            <a id="prevport_upsaleproduct" class="prev_carousel icon-arrow-left" href="#"></a>
			<a id="nextport_upsaleproduct" class="next_carousel icon-arrow-right" href="#"></a>
		</div>
			<script type="text/javascript">
	 jQuery( window ).load(function () {
	 	var $wcontainer = jQuery('#carouselcontainer');
	 	var $container = jQuery('#upsale-product-carousel');
	 				setWidths();
	 				$container.carouFredSel({
							scroll: { items:1,easing: "swing", duration: 700, pauseOnHover : true},
							auto: {play: true, timeoutDuration: 9000},
							prev: '#prevport_upsaleproduct',
							next: '#nextport_upsaleproduct',
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
