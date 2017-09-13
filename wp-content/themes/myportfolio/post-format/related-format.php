<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail" class="post-image post-image-left post-media">
	<div class="featured-thumbnail">
		<?php $thumbnail = mts_get_thumbnail_url( 'myportfolio-featured' );
		echo '<img src="'.$thumbnail.'" class="wp-post-image">'; ?>
	</div>
	<?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
</a>