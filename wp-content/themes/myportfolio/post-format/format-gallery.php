<?php
if ( $images = get_children( array( 'post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ) ) ) { ?>
	<div class="full-slider-container loading post-media">
		<div class="gallery-container">
			<div id="gallery" class="gallery-slider">
				<?php $check_sidebar = mts_custom_sidebar();
				foreach( $images as $image ) {
					if ( is_singular() && $check_sidebar == 'mts_nosidebar' ) {
						$attachment_img = wp_get_attachment_image_src( $image->ID, 'myportfolio-fullwidth' );
					} elseif( is_singular() ) {
						$attachment_img = wp_get_attachment_image_src( $image->ID, 'myportfolio-featuredfull' );
					} else {
						$attachment_img = wp_get_attachment_image_src( $image->ID, 'myportfolio-featured' );
					}
					$attachment_url = $attachment_img[0];
					$image_src	  = $attachment_url;
					echo '<div><img src="'.$image_src.'"></div>';
				} ?>
			</div>
		</div>
	</div>	
<?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper');
} ?>