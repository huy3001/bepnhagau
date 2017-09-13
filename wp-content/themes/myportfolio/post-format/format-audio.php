<?php $audio_meta = get_post_meta( get_the_ID(), '_format_audio_embed', true );
if ( $audio_meta == '' ) { ?>
	<div class="message_box warning post-media">
		<p><?php _e( 'Please add valid embed Code.', 'myportfolio' ); ?></p>
	</div>
<?php
} elseif ( strpos( $audio_meta, 'iframe' ) !== false || strpos( $audio_meta, 'embed' ) !== false ) {
	echo '<div class="myportfolio-audio post-media">'. $audio_meta . '</div>';
} else {
	$embed_code = wp_oembed_get( $audio_meta );
	echo '<div class="myportfolio-audio post-media">'. $embed_code . '</div>';
} ?>
