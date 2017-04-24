<?php 
//Shortcode for portfolio Posts
function kad_portfolio_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'orderby' => 'menu_order',
		'cat' => '',
		'order' => '',
		'offset' => null,
		'id' => (rand(10,100)),
		'columns' => '4',
		'lightbox' => '',
		'height' => '',
		'filter' => false,
		'excerpt' => false,
		'showtypes' => '',
		'items' => '4'
), $atts));
	if(!empty($order) ) {
		$order = $order;
	} else if($orderby == 'menu_order') {
		$order = 'ASC';
	} else {
		$order = 'DESC';
	} 
	if(empty($cat)) {
		$cat = '';
		$portfolio_cat_ID = '';
	} else {
		$portfolio_cat = get_term_by ('slug',$cat,'portfolio-type' );
		$portfolio_cat_ID = $portfolio_cat -> term_id;
	}
	if ($columns == '2') {
		$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12';
		$slidewidth = 560;
		$slideheight = 560;
	} else if ($columns == '1') {
		$itemsize = 'tcol-md-12 tcol-sm-12 tcol-xs-12 tcol-ss-12'; 
		$slidewidth = 560; 
		$slideheight = 560;
	} else if ($columns == '3'){
		$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
		$slidewidth = 366;
		$slideheight = 366;
	} else if ($columns == '6'){
		$itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6';
		$slidewidth = 240;
		$slideheight = 240;
	} else if ($columns == '5'){
		$itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6';
		$slidewidth = 240;
		$slideheight = 240;
	} else {
		$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12';
		$slidewidth = 270;
		$slideheight = 270;
	}
	if(!empty($height) && $height == 'none') {
		$slideheight = null;
	} else if(!empty($height)) {
		$slideheight = $height;
	}
	global $virtue_premium; 
	if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {
		$animate = 1;
	} else {
		$animate = 0;
	}
ob_start(); ?>
	<?php if ($filter) { ?>
      	<section id="options" class="clearfix">
			<?php global $virtue_premium; 
			if(!empty($virtue_premium['filter_all_text'])) {
				$alltext = $virtue_premium['filter_all_text'];
			} else {
				$alltext = __('All', 'virtue');
			}
			if(!empty($virtue_premium['portfolio_filter_text'])) {
				$portfoliofiltertext = $virtue_premium['portfolio_filter_text'];
			} else {
				$portfoliofiltertext = __('Filter Projects', 'virtue');
			}
			$termtypes = array( 'child_of' => $portfolio_cat_ID,);
			$categories= get_terms('portfolio-type', $termtypes);
			$count = count($categories);
			
						echo '<a class="filter-trigger headerfont" data-toggle="collapse" data-target=".filter-collapse"><i class="icon-tags"></i> '.$portfoliofiltertext.'</a>';
						echo '<ul id="filters" class="clearfix option-set filter-collapse">';
						echo '<li class="postclass"><a href="#" data-filter="*" title="All" class="selected"><h5>'.$alltext.'</h5><div class="arrow-up"></div></a></li>';
						if ( $count > 0 ){
							foreach ($categories as $category){ 
								$termname = strtolower($category->slug);
								$termname = preg_replace("/[^a-zA-Z 0-9]+/", " ", $termname);
								$termname = str_replace(' ', '-', $termname);
									echo '<li class="postclass"><a href="#" data-filter=".'.esc_attr($termname).'" title="" rel="'.esc_attr($termname).'"><h5>'.$category->name.'</h5><div class="arrow-up"></div></a></li>';
								}
				 		}
				 		echo "</ul>"; ?>
			</section>
            <?php } ?>
				<div class="home-portfolio">
						<div id="portfoliowrapper-<?php echo $id;?>" class="rowtight init-isotope" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".p-item" data-iso-style="masonry" data-iso-filter="true"> 
            <?php $wp_query = null; 
				  $wp_query = new WP_Query();
					  $wp_query->query(array(
					  	'orderby' 			=> $orderby,
					  	'order' 			=> $order,
					  	'offset' 			=> $offset,
					  	'post_type' 		=> 'portfolio',
					  	'portfolio-type'	=> $cat,
					  	'posts_per_page' 	=> $items
					  	)
					  );
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				<?php global $post; $terms = get_the_terms( $post->ID, 'portfolio-type' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();
								foreach ( $terms as $term ) { $links[] = $term->slug;}
							$links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif;
						?>
				
				<div class="<?php echo esc_attr($itemsize);?> <?php echo strtolower($tax); ?> all p-item">
                	<div class="grid_item portfolio_item kad_portfolio_fade_in kt_item_fade_in kad-light-gallery postclass">
					<?php global $post;
					$postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );

						if ($postsummery == 'slider') { ?>
                           	<div class="flexslider kt-flexslider loading imghoverclass clearfix" data-flex-speed="7000" data-flex-initdelay="<?php echo (rand(10,2000));?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                       			<ul class="slides">
                       		<?php 	$image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                          			if(!empty($image_gallery)) {
                    					$attachments = array_filter( explode( ',', $image_gallery ) );
                    					if ($attachments) {
											foreach ($attachments as $attachment) {
												$attachment_url = wp_get_attachment_url($attachment , 'full');
												$image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
													if(empty($image)) {$image = $attachment_url;}
												?>
												<li>
													<a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>">
														<img src="<?php echo esc_url($image); ?>"/>
													</a>
													<?php if($lightbox) {?>
														<a href="<?php echo esc_url($attachment_url); ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" data-rel="lightbox">
															<i class="icon-search"></i>
														</a>
													<?php }?>
												</li>
												<?php
											}
										}
                    				} else {
                    					$attach_args = array('order'=> 'ASC','post_type'=> 'attachment','post_parent'=> $post->ID,'post_mime_type' => 'image','post_status'=> null,'orderby'=> 'menu_order','numberposts'=> -1);
										$attachments = get_posts($attach_args);
										if ($attachments) {
											foreach ($attachments as $attachment) {
												$attachment_url = wp_get_attachment_url($attachment->ID , 'full');
												$image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
													if(empty($image)) {$image = $attachment_url;} ?>
												<li>
													<a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>">
														<img src="<?php echo esc_url($image); ?>"/>
													</a>
													<?php if($lightbox) {?>
														<a href="<?php echo esc_url($attachment_url); ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" data-rel="lightbox">
															<i class="icon-search"></i>
														</a>
													<?php }?>
												</li>
												<?php
											}
                    					}	
									} ?>  
								</ul>
              				</div> <!--Flex Slides-->
              <?php } else {
						if (has_post_thumbnail( $post->ID ) ) {
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
							$thumbnailURL = $image_url[0]; 
							$image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
								if(empty($image)) {$image = $thumbnailURL;} ?>
								<div class="imghoverclass">
	                                <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
	                                    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" class="lightboxhover" style="display: block;">
	                                </a> 
	                           	</div>
	                            <?php if(!empty($lightbox)) {?>
	                            	<a href="<?php echo esc_url($thumbnailURL); ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" data-rel="lightbox">
	                            		<i class="icon-search"></i>
	                            	</a>
	                            <?php }
                           			$image = null; $thumbnailURL = null;?>
                           <?php } 
                        } ?>
			              	<a href="<?php the_permalink() ?>" class="portfoliolink">
			              		<div class="piteminfo">   
			                          <h5><?php the_title();?></h5>
			                           <?php if(empty($showtypes)) { 
			                           	$terms = get_the_terms( $post->ID, 'portfolio-type' ); 
				                           	if ($terms) {?> 
				                           		<p class="cportfoliotag"><?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?></p>
				                           	<?php } 
			                           	} ?>
				                           <?php if($excerpt == true) {?>
				                           		<p><?php echo virtue_excerpt(16); ?></p> 
				                           <?php } ?>
			                    </div>
			                </a>
                </div>
            </div>
			<?php endwhile; else: ?>
				<li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'virtue');?></li>
			<?php endif; ?>
          	</div> <!-- portfoliowrapper -->
            <?php $wp_query = null; wp_reset_query(); ?>
		</div><!-- /.home-portfolio -->

	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}