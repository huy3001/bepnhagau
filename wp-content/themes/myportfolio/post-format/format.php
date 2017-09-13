<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail" class="post-image post-image-left post-media">
	<div class="featured-thumbnail">
		<?php
		$check_sidebar = mts_custom_sidebar();
		if( is_singular() && $check_sidebar == 'mts_nosidebar' ) {
			$thumbnail = mts_get_thumbnail_url( 'myportfolio-fullwidth' );
		} elseif(is_singular()) {
			$thumbnail = mts_get_thumbnail_url( 'myportfolio-featuredfull' );
		} else {
			$thumbnail = mts_get_thumbnail_url( 'myportfolio-featured' );
		}
		echo '<img src="'.$thumbnail.'" class="wp-post-image">'; ?>
	</div>
	<?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
</a>