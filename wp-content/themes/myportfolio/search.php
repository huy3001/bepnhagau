<?php
/**
 * The template for displaying search results pages.
 */
$mts_options = get_option(MTS_THEME_NAME);
get_header(); ?>
<div id="page">
	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<div class="article">
			<div id="content_box">
				<div class="grid">
					<h1 class="postsby">
						<span><?php _e("Search Results for:", 'myportfolio' ); ?></span> <?php the_search_query(); ?>
					</h1>
					<?php $n = 0; $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
						<article class="latestPost grid__item excerpt<?php echo (++$j % 3 == 0) ? ' last' : ''; ?><?php echo (++$n % 3 == 1) ? ' first' : ''; ?>">
							<?php mts_archive_post(); ?>
						</article><!--.post excerpt-->
					<?php endwhile; else: ?>
						<div class="no-results">
							<h2><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'myportfolio' ); ?></h2>
							<?php get_search_form(); ?>
						</div><!--noResults-->
					<?php endif;

					if ( $j !== 0 ) { // No pagination if there is no posts
						mts_pagination();
					} ?>
				</div>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>