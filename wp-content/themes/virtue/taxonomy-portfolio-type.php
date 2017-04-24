	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo kadence_main_class(); ?>" role="main">
      	<?php echo category_description(); ?> 
      	<?php if (!have_posts()) : ?>
		<div class="alert">
		    <?php _e('Sorry, no results were found.', 'virtue'); ?>
		</div>
		  <?php get_search_form(); ?>
		<?php endif; ?>
		 <?php global $virtue_premium;
		 if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {$animate = 1;} else {$animate = 0;}
		 if(!empty($virtue_premium['portfolio_tax_items'])) {$portfolio_items = $virtue_premium['portfolio_tax_items'];} else {$portfolio_items = '12';}
		 if(!empty($virtue_premium['portfolio_tax_column'])) {$portfolio_column = $virtue_premium['portfolio_tax_column'];} else {$portfolio_column = 4;}
		                   if ($portfolio_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 559; $slideheight = 559; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
		                   else if ($portfolio_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366; $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
		                   else if ($portfolio_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
		                   else if ($portfolio_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
		                   else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 269; $slideheight = 269; $md = 4; $sm = 3; $xs = 2; $ss = 1;}
		            ?> 
		<div id="portfoliowrapper" class="rowtight init-isotope" data-fade-in="<?php echo $animate;?>" data-iso-selector=".p-item" data-iso-style="masonry" data-iso-filter="false"> 
		<?php global $wp_query;
				// get the query object
					$cat_obj = $wp_query->get_queried_object();
		 $termslug = $cat_obj->slug;
		query_posts(array( 'paged' => $paged, 'posts_per_page' => $portfolio_items, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'portfolio', 'portfolio-type' => $termslug) );
		 while (have_posts()) : the_post(); ?>
		<div class="<?php echo $itemsize;?> p-item">
                	<div class="grid_item portfolio_item postclass kt_item_fade_in kad_portfolio_fade_in">
				<?php global $post; $postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );
						     if ($postsummery == 'slider') { ?>
                <div class="flexslider kt-flexslider loading imghoverclass clearfix" data-flex-speed="7000" data-flex-initdelay="<?php echo (rand(10,2000));?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                       <ul class="slides">
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
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo $image ?>" class="" /></a></li>
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
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo $image ?>" class="" /></a></li>
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
                           				<?php $image = null; $thumbnailURL = null;?>
                           <?php } } ?>
	              	<a href="<?php the_permalink() ?>" class="portfoliolink">
	              		<div class="piteminfo">   
	                          <h5><?php the_title();?></h5>
	                    </div>
	                </a>
            	</div>
            </div>
		<?php endwhile; ?>
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
                    ?>
                    <?php wp_reset_query(); ?>
</div><!-- /.main -->