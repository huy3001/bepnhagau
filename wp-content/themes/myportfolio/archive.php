<?php
/**
 * The template for displaying archive pages.
 *
 * Used for displaying archive-type pages. These views can be further customized by
 * creating a separate template for each one.
 *
 * - author.php (Author archive)
 * - category.php (Category archive)
 * - date.php (Date archive)
 * - tag.php (Tag archive)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$mts_options = get_option(MTS_THEME_NAME);
get_header(); ?>
<div id="page">
	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<div class="<?php mts_article_class(); ?>">
			<div id="content_box">
				<div class="grid">
					<h1 class="postsby">
						<span><?php the_archive_title(); ?></span>
					</h1>
					<?php $n = 0; $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
						<article class="latestPost grid__item excerpt<?php echo (++$j % 3 == 0) ? ' last' : ''; ?><?php echo (++$n % 3 == 1) ? ' first' : ''; ?>">
							<?php mts_archive_post(); ?>
						</article><!--.post excerpt-->
					<?php endwhile; endif;

					if ( $j !== 0 ) { // No pagination if there is no posts
						mts_pagination();
					} ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>