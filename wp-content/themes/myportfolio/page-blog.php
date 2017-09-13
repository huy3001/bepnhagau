<?php
/**
 * Template Name: Blog Page
 */
$mts_options = get_option(MTS_THEME_NAME);
get_header(); ?>
<div id="page" class="<?php /*echo (is_front_page()) ? "home-animation" : "";*/ ?>">
	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<div class="article">
			<div id="content_box">
				<div class="grid">
					<?php
					if ( get_query_var('paged') && get_query_var('paged') > 1 ){
						$paged = get_query_var('paged');
					} elseif (  get_query_var('page') && get_query_var('page') > 1  ){
						$paged = get_query_var('page');
					} else {
						$paged = 1;
					}
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'orderby' => 'post_date',
						'paged' => $paged,
						'ignore_sticky_posts'=> 1,
					);
					$latest_posts_query = new WP_Query( $args );

					global $wp_query;
					// Put default query object in a temp variable
					$tmp_query = $wp_query;
					// Now wipe it out completely
					$wp_query = null;
					// Re-populate the global with our custom query
					$wp_query = $latest_posts_query;

					if ( !is_paged() ) {
						$featured_categories = array();
						if ( !empty( $mts_options['mts_featured_categories'] ) ) {
							foreach ( $mts_options['mts_featured_categories'] as $section ) {
								$category_id = $section['mts_featured_category'];
								$featured_categories[] = $category_id;
								$posts_num = $section['mts_featured_category_postsnum'];
								if ( 'latest' == $category_id ) {
									$n = 0; $j = 0;
									 if ( $latest_posts_query->have_posts() ) : while ( $latest_posts_query->have_posts() ) : $latest_posts_query->the_post(); ?>
										<article class="latestPost grid__item excerpt<?php echo (++$j % 3 == 0) ? ' last' : ''; ?><?php echo (++$n % 3 == 1) ? ' first' : ''; ?>">
											<?php mts_archive_post(); ?>
										</article>
									<?php endwhile; endif; wp_reset_postdata();
									if ( $j !== 0 ) { // No pagination if there is no posts
										mts_pagination('', 3, 'mts_blog_pagenavigation_type');
									}
									
								} else { // if $category_id != 'latest': ?>
									<h3 class="featured-category-title"><a href="<?php echo esc_url( get_category_link( $category_id ) ); ?>" title="<?php echo esc_attr( get_cat_name( $category_id ) ); ?>"><?php echo esc_html( get_cat_name( $category_id ) ); ?></a></h3>
									<?php
									$j = 0;
									$cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$posts_num);
									if ( $cat_query->have_posts() ) : while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
										<article class="latestPost grid__item excerpt <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>">
											<?php mts_archive_post(); ?>
										</article>
									<?php endwhile; endif; wp_reset_postdata();
								}
							}
						}
					} else { //Paged
						$n = 0; $j = 0; if ( $latest_posts_query->have_posts() ) : while ( $latest_posts_query->have_posts() ) : $latest_posts_query->the_post(); ?>
						<article class="latestPost grid__item excerpt<?php echo (++$j % 3 == 0) ? ' last' : ''; ?><?php echo (++$n % 3 == 1) ? ' first' : ''; ?>">
							<?php mts_archive_post(); ?>
						</article>
						<?php endwhile; endif;
						if ( $j !== 0 ) { // No pagination if there is no posts
							mts_pagination('', 3, 'mts_blog_pagenavigation_type');
						}
						
					}
					// Restore original query object
					$wp_query = $tmp_query;
					// Be kind; rewind
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div><!-- .container -->
<?php get_footer(); ?>