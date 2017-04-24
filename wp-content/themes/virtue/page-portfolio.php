	<?php
/*
Template Name: Portfolio Grid
*/
?>
	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo kadence_main_class(); ?>" id="ktmain" role="main">
      	  <?php if ( ! post_password_required() ) { ?>
			<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
			</div>
      	<?php global $post, $virtue_premium; 
      	if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {$animate = 1;} else {$animate = 0;}
      	$portfolio_category = get_post_meta( $post->ID, '_kad_portfolio_type', true );
			   				   $portfolio_items = get_post_meta( $post->ID, '_kad_portfolio_items', true );
			   				   $portfolio_order = get_post_meta( $post->ID, '_kad_portfolio_order', true ); 
			   				   	if(isset($portfolio_order)) {$p_orderby = $portfolio_order;} else {$p_orderby = 'menu_order';}
			   				   	if($p_orderby == 'menu_order' || $p_orderby == 'title') {$p_order = 'ASC';} else {$p_order = 'DESC';}
								if($portfolio_category == '-1' || empty($portfolio_category)) { $portfolio_cat_slug = ''; $portfolio_cat_ID = ''; } else {
								 $portfolio_cat = get_term_by ('id',$portfolio_category,'portfolio-type' );
							$portfolio_cat_slug = $portfolio_cat -> slug;
							  $portfolio_cat_ID = $portfolio_cat -> term_id;
							}
					
					   		$portfolio_category = $portfolio_cat_slug;
							if($portfolio_items == 'all') { $portfolio_items = '-1'; }
					?>
      
      <?php global $post; $portfolio_filter = get_post_meta( $post->ID, '_kad_portfolio_filter', true ); 
	  	if ($portfolio_filter == 'yes') { ?>
      		<section id="options" class="clearfix">
			<?php global $virtue_premium; if(!empty($virtue_premium['filter_all_text'])) {$alltext = $virtue_premium['filter_all_text'];} else {$alltext = __('All', 'virtue');}
			if(!empty($virtue_premium['portfolio_filter_text'])) {$portfoliofiltertext = $virtue_premium['portfolio_filter_text'];} else {$portfoliofiltertext = __('Filter Projects', 'virtue');}
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
							echo '<li class="postclass"><a href="#" data-filter=".'.$termname.'" title="" rel="'.$termname.'"><h5>'.$category->name.'</h5><div class="arrow-up"></div></a></li>';
								}
				 		}
				 		echo "</ul>"; ?>
			</section>
            <?php } ?>
                   <?php 
                   global $post; $portfolio_column = get_post_meta( $post->ID, '_kad_portfolio_columns', true ); 
		                   if ($portfolio_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 560; $slideheight = 560; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
		                   else if ($portfolio_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366; $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
		                   else if ($portfolio_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
		                   else if ($portfolio_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
		                   else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 270; $slideheight = 270; $md = 4; $sm = 3; $xs = 2; $ss = 1;}
		            ?> 
                   <?php $portfolio_item_excerpt = get_post_meta( $post->ID, '_kad_portfolio_item_excerpt', true ); $portfolio_item_types = get_post_meta( $post->ID, '_kad_portfolio_item_types', true );  ?>
                   <?php $crop = true; ?>
                   <?php $portfolio_cropheight = get_post_meta( $post->ID, '_kad_portfolio_img_crop', true ); if ($portfolio_cropheight != '') $slideheight = $portfolio_cropheight; ?>
                   <?php $portfolio_crop = get_post_meta( $post->ID, '_kad_portfolio_crop', true ); if ($portfolio_crop == 'no') $slideheight = ''; $crop = false;?>
                   <?php $portfolio_lightbox = get_post_meta( $post->ID, '_kad_portfolio_lightbox', true ); if ($portfolio_lightbox == 'yes'){$plb = true;} else {$plb = false;}?>
               <div id="portfoliowrapper" class="init-isotope rowtight" data-fade-in="<?php echo $animate;?>" data-iso-selector=".p-item" data-iso-style="masonry" data-iso-filter="true"> 
   
            <?php 
				$temp = $wp_query; 
				  $wp_query = null; 
				  $wp_query = new WP_Query();
				  $wp_query->query(array(
					'paged' => $paged,
					'orderby' => $p_orderby,
					'order' => $p_order,
					'post_type' => 'portfolio',
					'portfolio-type'=>$portfolio_cat_slug,
					'posts_per_page' => $portfolio_items));
					$count =0;
					?>
					<?php if ( $wp_query ) : 
							 
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						$terms = get_the_terms( $post->ID, 'portfolio-type' );
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
					<div class="<?php echo $itemsize;?> <?php echo strtolower($tax); ?> all p-item">
                	<div class="portfolio_item grid_item postclass kad-light-gallery kt_item_fade_in kad_portfolio_fade_in">
                        <?php global $post; $postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );
						     if ($postsummery == 'slider') { ?>
                           <div class="flexslider kt-flexslider loading imghoverclass clearfix" data-flex-speed="7000" data-flex-initdelay="<?php echo (rand(10,2000));?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                       <ul class="slides kad-light-gallery">
                          <?php 
                          global $post;
	                      $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
	                          if(!empty($image_gallery)) {
	                            $attachments = array_filter( explode( ',', $image_gallery ) );
	                              if ($attachments) {
	                              foreach ($attachments as $attachment) {
	                                $attachment_url = wp_get_attachment_url($attachment , 'full');
	                                $image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
	                                  if(empty($image)) {$image = $attachment_url;}?>
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo esc_url($image); ?>" class="" /></a>
										<?php if($plb) {?><a href="<?php echo $attachment_url; ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" rel="lightbox"><i class="icon-search"></i></a><?php }?>
	                                  </li>
	                                <?php }
	                            }
	                          } else {
	                            $attach_args = array('order'=> 'ASC','post_type'=> 'attachment','post_parent'=> $post->ID,'post_mime_type' => 'image','post_status'=> null,'orderby'=> 'menu_order','numberposts'=> -1);
	                            $attachments = get_posts($attach_args);
	                              if ($attachments) {
	                                foreach ($attachments as $attachment) {
	                                  $attachment_url = wp_get_attachment_url($attachment->ID , 'full');
	                                  $image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
	                                    if(empty($image)) {$image = $attachment_url;} ?>
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo esc_url($image); ?>" class="" /></a></li>
	                                <?php }
	                              } 
	                          }  ?>                            
					</ul>
              	</div> <!--Flex Slides-->
              <?php } else {
								if (has_post_thumbnail( $post->ID ) ) {
									$image_url = wp_get_attachment_image_src( 
									get_post_thumbnail_id( $post->ID ), 'full' ); 
									$thumbnailURL = $image_url[0]; 
									 $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);

									if(empty($image)) {$image = $thumbnailURL;} ?>
									<div class="imghoverclass">
	                                       <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
	                                       <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="lightboxhover" style="display: block;">
	                                       </a> 
	                                </div>
	                                <?php if($plb) {?><a href="<?php echo $thumbnailURL; ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" rel="lightbox"><i class="icon-search"></i></a><?php }?>
                           				<?php $image = null; $thumbnailURL = null;?>
                           <?php } } ?>
              	<a href="<?php the_permalink() ?>" class="portfoliolink">

              		<div class="piteminfo">   
                          <h5><?php the_title();?></h5>
                           <?php if($portfolio_item_types == true) { $terms = get_the_terms( $post->ID, 'portfolio-type' ); if ($terms) {?> <p class="cportfoliotag"><?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?></p> <?php } } ?>
                          <?php if($portfolio_item_excerpt == true) {?> <p><?php echo virtue_excerpt(16); ?></p> <?php } ?>
                    </div>
                </a>
                </div>
                    </div>
					<?php endwhile; else: ?>
					 
					<li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'virtue');?></li>
						
				<?php endif; ?>
                </div> <!--portfoliowrapper-->
                                    
                    <?php if ($wp_query->max_num_pages > 1) : ?>
                            <?php if(function_exists('kad_wp_pagenavi')) { ?>
                            <?php kad_wp_pagenavi(); ?>   
                            <?php } else { ?>      
                            <nav id="post-nav" class="pager">
                                <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'virtue')); ?></div>
                                <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'virtue')); ?></div>
                              </nav>
                            <?php } ?> 
                    <?php endif; ?>
                    <?php 
                      $wp_query = null; 
                      $wp_query = $temp;  // Reset
                    ?>
                    <?php wp_reset_query(); ?>
                    <?php global $virtue_premium; if(isset($virtue_premium['page_comments']) && $virtue_premium['page_comments'] == '1') { comments_template('/templates/comments.php');} ?>

<?php } else { ?>
      <?php echo get_the_password_form();
    }?>

</div><!-- /.main -->