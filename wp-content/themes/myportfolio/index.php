<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */
$mts_options = get_option(MTS_THEME_NAME);
get_header(); ?>
<div id="home-page" class="<?php echo ( is_home() && 'posts' === get_option('show_on_front') && '1' == $mts_options['mts_loading'] ) ? "home-animation" : ""; ?>">
	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<div class="article">
			<div id="content_box">
				<div class="portfolio clearfix grid">
					<?php
					global $wp_query;
					$j = 0; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<article class="view latestPost excerpt grid__item">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left mts-portfolio-loader-link">
								<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('myportfolio-portfolio',array('title' => '')); echo '</div>'; ?>
							</a>
							<div class="icons">
								<?php if( $mts_options['mts_lightbox'] == 1 ) : ?>
									<a class="popup-link" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>"><i class="fa fa-search"></i></a>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="mts-portfolio-loader-link" rel="nofollow"><i class="fa fa-link"></i></a>
							</div>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="mts-portfolio-loader-link" rel="nofollow">
								<div class="post-caption">
								</div>
							</a>
						</article>
					<?php $j++; endwhile; endif; ?>
				</div>
				<?php if ( $j !== 0 && $wp_query->max_num_pages > 1 ) { // No pagination if there is no results
					mts_pagination('', 3, 'mts_pagenavigation_type');
				}
				?>
			</div>
		</div>

	</div><!-- .container -->
<?php get_footer(); ?>