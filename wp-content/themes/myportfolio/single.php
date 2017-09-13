<?php
/**
 * The template for displaying all single posts.
 */
get_header();
$mts_options = get_option(MTS_THEME_NAME); ?>
<div id="page" class="<?php mts_single_page_class(); ?>">	

	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<article class="<?php mts_article_class(); ?>">
			<div id="content_box" >
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
						<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
							<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
						<?php }
						// Single post parts ordering
						if ( isset( $mts_options['mts_single_post_layout'] ) && is_array( $mts_options['mts_single_post_layout'] ) && array_key_exists( 'enabled', $mts_options['mts_single_post_layout'] ) ) {
							$single_post_parts = $mts_options['mts_single_post_layout']['enabled'];
						} else {
							$single_post_parts = array( 'content' => 'content', 'related' => 'related', 'author' => 'author' );
						}
						foreach( $single_post_parts as $part => $label ) { 
							switch ($part) {
								case 'content': ?>
									<div class="single_post">
										<?php
										echo '<div class="featured-post-format post-formate-container clearfix">';
											get_template_part( 'post-format/format', get_post_format() );
										echo '</div>'; ?>
										<header>
											<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
											<?php mts_the_postinfo( 'single' ); ?>
										</header><!--.headline_area-->
										<div class="post-single-content mark-links entry-content">
											<?php if (isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] == 'top') mts_social_buttons();
											if ($mts_options['mts_posttop_adcode'] != '') {
												$toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
													<div class="topad">
														<?php echo do_shortcode($mts_options['mts_posttop_adcode']); ?>
													</div>
												<?php }
											} ?>
											<div class="thecontent">
												<?php the_content(); ?>
											</div>
											<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => '<i class="fa fa-angle-right"></i>', 'previouspagelink' => '<i class="fa fa-angle-left"></i>', 'pagelink' => '%','echo' => 1 ));
											if ($mts_options['mts_postend_adcode'] != '') {
												$endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
													<div class="bottomad">
														<?php echo do_shortcode($mts_options['mts_postend_adcode']); ?>
													</div>
												<?php }
											}
											if (isset($mts_options['mts_social_button_position']) && $mts_options['mts_social_button_position'] !== 'top') mts_social_buttons(); ?>
										</div><!--.post-single-content-->
									</div><!--.single_post-->
									<?php $next_post = get_next_post();
									$previous_post = get_previous_post();
									if( $next_post || $previous_post ) : ?>
										<div class="single-prev-next">
											<?php if($previous_post) { ?>
												<div class="previous_post">
													<a class="previous_full_post" href="<?php echo esc_url( get_permalink($previous_post->ID) ); ?>" title="<?php echo $previous_post->post_title; ?>" <?php if(empty($next_post)) echo 'style="left:36px;"' ?>>
														<?php if(has_post_thumbnail( $previous_post->ID )) { ?>
															<div class="featured-thumbnail">
																<?php echo get_the_post_thumbnail( $previous_post->ID, 'myportfolio-widgetthumb' ); ?>
															</div>
														<?php } ?>
														<header>
															<span><?php _e('Previous Article', 'myportfolio') ?></span>
															<h3 class="title front-view-title"><?php echo substr($previous_post->post_title, 0, 40)." ..."; ?></h3>
														</header>
													</a>
													<div class="prev"><?php previous_post_link('%link', '<i class="fa fa-angle-left"></i>'); ?></div>
												</div>
											<?php } ?>
											<?php if($next_post) { ?>
												<div class="next_post">
													<a class="next_full_post" href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" title="<?php echo $next_post->post_title; ?>" style="right: 36px;">
														<?php if(has_post_thumbnail( $next_post->ID )) { ?>
															<div class="featured-thumbnail">
																<?php echo get_the_post_thumbnail( $next_post->ID, 'myportfolio-widgetthumb' ); ?>
															</div>
														<?php } ?>
														<header>
															<span><?php _e('Next Article', 'myportfolio') ?></span>
															<h3 class="title front-view-title"><?php echo substr($next_post->post_title, 0, 40)." ..."; ?></h3>
														</header>
													</a>
													<div class="next"><?php next_post_link('%link', '<i class="fa fa-angle-right"></i>'); ?></div>
												</div>
											<?php } ?>
										</div>
									<?php endif;
								break;

								case 'tags':
									mts_the_tags('<div class="tags"><span class="tagtext">'.__('Tags', 'myportfolio' ).':</span>',', ');
								break;

								case 'author': ?>
									<div class="postauthor">
										<div class="author-thumbnail">
											<div class="author-container">
												<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '112' );  } ?>
											</div>
											<h5 class="vcard author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="fn"><?php the_author_meta( 'display_name' ); ?></a></h5>
										</div>
										<h4><?php _e('The Author', 'myportfolio' ); ?></h4>
										<p><?php the_author_meta('description') ?></p>
										<div class="author-posts">
											<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="" rel="nofollow"><?php _e('Posts by this Author', 'myportfolio' ); ?></a>
										</div>
									</div>
									<?php
								break;
							}
						} ?>
					</div><!--.g post-->
					<?php comments_template( '', true );
				endwhile; /* end loop */; ?>
			</div>
		</article>
		<?php get_sidebar();
		if( $mts_options['mts_related_posts'] == 1 ) : mts_related_posts(); endif; ?>
	</div><!-- .container -->
<?php get_footer(); ?>
