 <?php

global $post;
    $id = $post->ID;
      $slides = array();
		$max_height = get_post_meta( $id, '_kt_slider_max_height', true );
		$max_width = get_post_meta( $id, '_kt_slider_max_width', true );
		$fullwidth = get_post_meta( $id, '_kt_slider_fullwidth', true );
		$fullheight = get_post_meta( $id, '_kt_slider_fullheight', true );
		$pause_time = get_post_meta( $id, '_kt_slider_pause_time', true );
		$auto_play = get_post_meta( $id, '_kt_slider_auto_play', true );
		$btn_txt_color = get_post_meta( $id, '_kt_slider_btn_txt_color', true );
		$btn_bg_color = get_post_meta( $id, '_kt_slider_btn_bg_color', true );
		$btn_txt_color_2 = get_post_meta( $id, '_kt_slider_btn_txt_color_2', true );
		$btn_bg_color_2 = get_post_meta( $id, '_kt_slider_btn_bg_color_2', true );
		$btn_txt_color_h = get_post_meta( $id, '_kt_slider_btn_txt_color_h', true );
		$btn_bg_color_h = get_post_meta( $id, '_kt_slider_btn_bg_color_h', true );
		$btn_txt_color_2_h = get_post_meta( $id, '_kt_slider_btn_txt_color_2_h', true );
		$btn_bg_color_2_h = get_post_meta( $id, '_kt_slider_btn_bg_color_2_h', true );
		$caption_head_font = get_post_meta( $id, '_kt_slider_head_font', true );
		$caption_header_txt_color = get_post_meta( $id, '_kt_slider_header_txt_color', true );
		$caption_text_font = get_post_meta( $id, '_kt_slider_text_font', true );
		$caption_caption_txt_color = get_post_meta( $id, '_kt_slider_caption_txt_color', true );
		$caption_caption_bg_color = get_post_meta( $id, '_kt_slider_caption_bg_color', true );
		$caption_caption_align = get_post_meta( $id, '_kt_slider_caption_align', true );
		$caption_head_font_tb = get_post_meta( $id, '_kt_slider_head_font_tb', true );
		$caption_text_font_tb = get_post_meta( $id, '_kt_slider_text_font_tb', true );
		$caption_head_font_pn = get_post_meta( $id, '_kt_slider_head_font_pn', true );
		$caption_text_font_pn = get_post_meta( $id, '_kt_slider_text_font_pn', true );


		$slides = get_post_meta( $id, '_kt_slider_slides', true );
		if(!empty($pause_time)) {$pause_data = $pause_time;} else{$pause_data = '9000';} 
		if(!empty($auto_play)) {$auto_play_data = $auto_play;} else{$auto_play_data = 'true';} 
		if($fullwidth) {$max_width = 'none';} else {$max_width = $max_width.'px';}
		if($fullheight) {$max_height = '600px'; $data_height = "full";} else {$max_height = $max_height.'px'; $data_height = $max_height;}
		$custom_slider_css = '';
		if(!empty($btn_txt_color)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-01 {color:'.$btn_txt_color.';}'; }
		if(!empty($btn_bg_color)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-01 {background:'.$btn_bg_color.'; border-color:'.$btn_bg_color.';}'; }
		if(!empty($btn_txt_color_2)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-02 {color:'.$btn_txt_color_2.';}'; }
		if(!empty($btn_bg_color_2)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-02 {border-color:'.$btn_bg_color_2.';}'; }
		if(!empty($btn_txt_color_h)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-01:hover {color:'.$btn_txt_color_h.';}'; }
		if(!empty($btn_bg_color_h)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-01:hover {background:'.$btn_bg_color_h.'; border-color:'.$btn_bg_color_h.';}'; }
		if(!empty($btn_txt_color_2_h)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-02:hover {color:'.$btn_txt_color_2_h.';}'; }
		if(!empty($btn_bg_color_2_h)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kad-slider-btn-02:hover {border-color:'.$btn_bg_color_2_h.';}'; }
		if(!empty($caption_head_font)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontitle {font-size:'.$caption_head_font.'px;}'; }
		if(!empty($caption_header_txt_color)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontitle {color:'.$caption_header_txt_color.';}'; }
		if(!empty($caption_text_font)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontext p {font-size:'.$caption_text_font.'px;}'; }
		if(!empty($caption_caption_txt_color)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontext p {color:'.$caption_caption_txt_color.';}'; }
		if(!empty($caption_caption_align)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .caption-case-inner {text-align:'.$caption_caption_align.';}'; }
		if(!empty($caption_caption_bg_color)) { $cc_bg_rgb = ktslidehex2rgb($caption_caption_bg_color);
			$custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontext p, .kad-slider-'.$id.' .kad-slider .kadcaptiontitle {background-color: rgba('.$cc_bg_rgb[0].', '.$cc_bg_rgb[1].', '.$cc_bg_rgb[2].', 0.3);}'; }
 		$custom_slider_css .= '@media (max-width: 992px) {';
 		if(!empty($caption_text_font_tb)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontext p {font-size:'.$caption_text_font_tb.'px;}'; }
 		if(!empty($caption_head_font_tb)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontitle {font-size:'.$caption_head_font_tb.'px;}'; }
 		
 		$custom_slider_css .= '} @media (max-width: 767px) {';
 		if(!empty($caption_head_font_pn)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontitle {font-size:'.$caption_head_font_pn.'px;}'; }
 		if(!empty($caption_text_font_pn)) { $custom_slider_css .= '.kad-slider-'.$id.' .kad-slider .kadcaptiontext p {font-size:'.$caption_text_font_pn.'px;}'; }
 		$custom_slider_css .= '}';
?>
                	<style type="text/css">
                	<?php echo $custom_slider_css; ?>
                	</style>
			  	<div class="kad-slider-wrapper kad-slider-<?php echo $id;?>" data-ktslider-auto-play="<?php echo $auto_play_data;?>" data-ktslider-pause-time="<?php echo $pause_data;?>" data-ktslider-height="<?php echo $data_height;?>" style="max-width:<?php echo $max_width;?>">
			    	<div class="kad-slider kad-loading" style="margin-left: auto; margin-right:auto; height:<?php echo $max_height;?>; ">

						<div id="kadence_load">
							<div id="kadence_load_1" class="kadence_load">
							</div>
							<div id="kadence_load_2" class="kadence_load">
							</div>
							<div id="kadence_load_3" class="kadence_load">
							</div>
						</div>
			        	<ul class="kad-slider-canvas sequence-canvas" style="height:<?php echo $max_height;?>;" >
			            <?php foreach ($slides as $slide) : ?>
			                      <li class=""> 
			                              <div class="kad-slide" style="background-image: url('<?php echo $slide['image'];?>'); background-size:cover; background-repeat: no-repeat;">
			                              	<div class="caption-case kad-placement-<?php echo $slide["caption_placement"];?>">
			                                	<div class="kad-slide-caption animated <?php echo $slide["caption_animation_in"].' '.$slide["caption_animation_out"];?>">
			                                		<div class="caption-case-inner">
					                                <?php if (!empty($slide['title'])) echo '<div class="kadcaptiontitle headerfont">'.$slide['title'].'</div>'; ?>
					                                <?php if (!empty($slide['description'])) echo '<div><div class="kadcaptiontext headerfont"><p>'.$slide['description'].'</p></div></div>';?>
					                                <?php if(!empty($slide['button_link'])) echo '<a href="'.$slide['button_link'].'" class="kad-slider-btn headerfont kad-slider-btn-01">'.$slide['button_txt'].'</a>'; ?>
					                                <?php if(!empty($slide['button_link_2'])) echo '<a href="'.$slide['button_link_2'].'" class="kad-slider-btn headerfont kad-slider-btn-02">'.$slide['button_txt_2'].'</a>'; ?>
			                                		</div> 
			                                	</div> 
			                            	</div>
			                            </div>
			                      	</li> 
			            <?php endforeach; ?>
			        	</ul>
			        	<ul class="kad-slider-pagination">
			        		<?php foreach ($slides as $slide) : ?>
						    <li class="kad-slider-dot"></li>
						    <?php endforeach; ?>
						</ul>
			        	<a class="kad-slider-next kad-slider-navigate"></a>
			        	<a class="kad-slider-prev kad-slider-navigate"></a>
			      </div> <!--kad-slides-->
			  </div> <!--kad-slider-->
            		