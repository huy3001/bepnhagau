<?php
/**
 * The template for displaying the footer.
 */
$mts_options = get_option(MTS_THEME_NAME);
$brands_heading = isset( $mts_options['mts_myclients_heading'] ) ? $mts_options['mts_myclients_heading'] : '';
$brands_text = isset( $mts_options['mts_myclients_text'] ) ? $mts_options['mts_myclients_text'] : '';
?>
	</div><!--#page-->
	<footer id="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
		<?php if( get_post_type() == 'portfolio' && !is_single('portfolio') ) {
				$style = "max-width: 100%; padding-right: 30px;";
		} else {
			$style = "";
			echo '<div class="container">';
				if (function_exists('wp_subscribe_shortcode')) echo wp_subscribe_shortcode();
			echo '</div>';
		}

		if ( !empty($mts_options['mts_myclients_images']) && is_array($mts_options['mts_myclients_images']) ) { ?>
			<div class="myclients-section clearfix">
				<div class="container clearfix" style="<?php echo ($style) ? $style : "" ?>">
					<div class="brand-controls">
						<?php if ( !empty( $brands_heading ) ) { ?><div class="featured-category-title"><h3><?php echo $brands_heading; ?></h3></div><?php }
						if ( !empty( $brands_text ) ) { ?><p><?php echo $brands_text; ?></p><?php } ?>
						<div class="custom-nav">
							<a class="btn brand-prev"><i class="fa fa-angle-left"></i></a>
							<a class="btn brand-next"><i class="fa fa-angle-right"></i></a>
						</div>
					</div>
					<?php if ( !empty( $mts_options['mts_myclients_images'] ) ) { ?>
						<div class="brand-container clearfix loading">
							<div id="brands-slider" class="brand-category">
							<?php foreach ( $mts_options['mts_myclients_images'] as $image ) {
								extract($image);
								if ( !empty( $mts_myclients_image ) ) { ?>
									<div class="brand-slider">
										<?php if(!empty($mts_myclients_link)) { ?><a href="<?php echo esc_url( $mts_myclients_link );?>"><?php } ?>
										<img src="<?php echo $mts_myclients_image ?>" alt="<?php echo $mts_myclients_title; ?>">
										<?php if(!empty($mts_myclients_link)) { ?></a><?php } ?>
									</div>
								<?php }
							} ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div><!--.myclients-section-->
		<?php } ?>
		
		<div class="footer-nav">
			<div class="container" style="<?php echo ($style) ? $style : "" ?>">
				<a href="#blog" class="toplink"><?php _e('Back to Top', 'myportfolio' ); ?><i class=" fa fa-chevron-up"></i></a>
				<?php if ( has_nav_menu( 'footer-menu' ) && $mts_options['mts_show_footer_nav'] == '1' ) {
					wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) );
				} ?>

			</div>
		</div>

	</footer><!--#site-footer-->
</div><!--.main-container-->
<?php mts_footer();
wp_footer(); ?>
</body>
</html>