<?php $video_meta = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
<?php if ( $video_meta == '' ) { ?>
	<div class="message_box warning post-media">
		<p><?php _e( 'Please add valid embed Code.', 'myportfolio' ); ?></p>
	</div>
<?php } elseif ( strpos( $video_meta, 'iframe' ) !== false || strpos( $video_meta, 'embed' ) !== false ) {
	echo '<div class="flex-video post-media">'. $video_meta . '</div>';
} else {
	$embed_code = wp_oembed_get( $video_meta );
	echo '<div class="flex-video post-media">'. $embed_code . '</div>';
} ?>
