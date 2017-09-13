<?php
	$quote_meta = get_post_meta( get_the_ID(), '_format_quote_source_name', true );
	$quote_url = get_post_meta( get_the_ID(), '_format_quote_source_url', true );
	$id = get_post_thumbnail_id();
	if( is_singular() ) {
		$image = wp_get_attachment_image_src( $id, 'myportfolio-featuredfull' );
	} else {
		$image = wp_get_attachment_image_src( $id, 'myportfolio-featured' );
	}
	$image_url = $image[0];
	$thumbnail = $image_url;
?>
<div class="blockquote post-media" style="background-image: url(<?php echo $thumbnail;?>);background-position: center center; background-repeat:no-repeat; background-size:cover; width: 100%; max-height:355px; overflow-y: scroll;">
	<blockquote class="quotes">
	<?php if ( $quote_meta == '' ) { ?>
		<div class="message_box warning">
			<div class="quotes"><?php _e( 'Please Insert Some Quote.', 'myportfolio' ); ?></div>
		</div>
	<?php } else {
		$embed_code = esc_attr( $quote_meta );
		echo '<a href="'.$quote_url.'">';
		echo the_content().'<p>- '.$quote_meta.'</p></a>';
	} ?>
	</blockquote>
</div>
