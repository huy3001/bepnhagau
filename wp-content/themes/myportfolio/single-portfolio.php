<?php
/**
 * The template for displaying all single posts.
 */
get_header();
$mts_options = get_option(MTS_THEME_NAME);
$entries = get_post_meta( get_the_ID(), 'mts_portfolio_entries', true );
?>
<div id="page" class="<?php mts_single_page_class(); ?>">

	<div class="container page-container">
		<?php mts_post_loader(); ?>
		<article class="<?php mts_article_class(); ?>">
			<div id="content_box" >
				<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
					<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
				<?php }

				if ( empty($entries)) {
					$classes = 'g post single-portfolio-full';
				} else {
					$classes = 'g post';
				} ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
					<div class="single_post">
						<?php 
						// Get the list of files
						$files = get_post_meta( get_the_ID(), 'mts_portfolio_gallery', 1 );
						$args = array(
							'post_type'   => 'attachment',
							'numberposts' => -1,
							'post_parent' => get_the_ID(),
							'order' => 'ASC',
							'orderby' => 'menu_order',
							'post_mime_type' => 'image'
						);
						$args = apply_filters( 'myportfolio_single_project_images_args', $args, get_the_ID() );
						$attachments = get_posts( $args );
						if($files) {

							echo '<div class="portfolio-slider-container clearfix loading">';
								echo '<div id="slider" class="portfolio-slider">';
									// Loop through them and output an image
									foreach ( (array) $files as $attachment_id => $attachment_url ) {
										$check_sidebar = mts_custom_sidebar();
										if( is_singular() && $check_sidebar == 'mts_nosidebar' ) {
											$src = wp_get_attachment_image_src($attachment_id, 'full');
										} else {
											$src = wp_get_attachment_image_src($attachment_id, 'myportfolio-fullwidth');
										}
										echo '<div class="slide" style="background-image: url('.$src[0].');background-position: center center; background-repeat:no-repeat; background-size:cover; width: 100%; padding-bottom: 69%;"></div>';
									}
								echo '</div>';
							echo '</div>';

						} elseif ( $attachments && count($attachments) > 1 ) { ?>

							<div class="portfolio-slider-container clearfix loading">
								<div id="slider" class="portfolio-slider">
									<?php foreach ( $attachments as $attachment ) {
										$id = $attachment->ID;
										$check_sidebar = mts_custom_sidebar();
										if( is_singular() && $check_sidebar == 'mts_nosidebar' ) {
											$src = wp_get_attachment_image_src($id, 'full');
										} else {
											$src = wp_get_attachment_image_src($id, 'myportfolio-fullwidth');
										} ?>
										<div class="slide" style="background-image: url('<?php echo $src[0]; ?>');background-position: center center; background-repeat:no-repeat; background-size:cover; width: 100%; padding-bottom: 69%;"></div>
									<?php } ?>
								</div>
							</div><!-- .portfolio-slider-container -->

						<?php } elseif(has_post_thumbnail()) { ?>

							<div class="featured-thumbnail" style="margin-bottom: 30px;">
								<?php
								$check_sidebar = mts_custom_sidebar();
								if( is_singular() && $check_sidebar == 'mts_nosidebar' ) {
									the_post_thumbnail( 'full', array( 'title' => '' ) );
								} else {
									the_post_thumbnail( 'myportfolio-fullwidth', array( 'title' => '' ) );
								} ?>
							</div>

						<?php }
						
						if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
						<div class="left-half">
							<header>
								<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
								<div class="post-info">
									<span class="thetime date updated"><span><?php the_time( get_option( 'date_format' ) ); ?></span></span>
								</div>
								<?php if( count($entries) >= 1 ) : ?>
									<div class="portfolio-info">
										<ul>
										 	<?php foreach ( $entries as $entry ) {

												$title = $description = '';
												if ( isset( $entry['title'] ) ) $title = esc_html( $entry['title'] );
												if ( isset( $entry['description'] ) ) $description = $entry['description'];

												if ( !empty( $title ) || !empty( $description ) ) { ?>
													<li class="cat-item">
														<h5 class="title"><?php echo isset($title) ? $title : ''; ?></h5>
														<p><?php echo isset($description) ? $description : ''; ?></p>
													</li>
												<?php }
											} ?>
										</ul>
									</div>
								<?php endif; ?>
							</header><!--.headline_area-->
						</div><!--.left-half-->
						<div class="right-half">
							<div class="post-single-content mark-links entry-content">
								<div class="thecontent">
									<?php the_content(); ?>
								</div>
							</div><!--.post-single-content-->								
						</div><!-- .right-half -->
						<?php endwhile; /* end loop */ ?>
					</div><!--.single_post-->

					<!-- similar-projects -->
					<?php if( isset($mts_options['mts_similar_projects_section']) && $mts_options['mts_similar_projects_section'] == 1 ) :
						global $post;
						$custom_taxterms = wp_get_object_terms( $post->ID, 'mts_categories', array('fields' => 'ids') );
						$cat = isset($category->cat_ID);
						// arguments
						$args = array(
							'cat' => $cat,
							'post_type' => 'portfolio',
							'post_status' => 'publish',
							'posts_per_page' => 3, // you may edit this number
							'orderby' => 'rand',
							'tax_query' => array(
								array(
									'taxonomy' => 'mts_categories',
									'field' => 'id',
									'terms' => $custom_taxterms
								)
							),
							'post__not_in' => array ($post->ID),
						);
						$args = apply_filters( 'myportfolio_similar_projects_args', $args, $post->ID );
						$my_query = new WP_Query( $args );
						if( $my_query->have_posts() ) {
							echo '<div class="similar-projects">';
							echo '<h4>'.__('Similar Projects', 'myportfolio' ).'</h4>';
							$j = 0;
							while( $my_query->have_posts() ) { $my_query->the_post(); ?>
							<article class="view latestPost excerpt">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left">
									<?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('myportfolio-portfolio',array('title' => '')); echo '</div>'; ?>
								</a>
								<div class="icons">
									<?php if( $mts_options['mts_lightbox'] == 1 ) : ?>
										<a class="popup-link" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>"><i class="fa fa-search"></i></a>
									<?php endif; ?>
									<a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="nofollow"><i class="fa fa-link"></i></a>
								</div>
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="nofollow">
									<div class="post-caption">
									</div>
								</a>
							</article>
					<?php } echo '</div>'; } wp_reset_postdata(); endif; ?>
					<!-- .similar-projects -->

				</div><!--.g post-->
				<?php comments_template( '', true ); ?>
				
			</div>
		</article>
		<?php get_sidebar(); ?>
	</div><!-- .container -->
<?php get_footer(); ?>