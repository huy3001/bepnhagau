<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: MTS About Author
	Description: A widget for Author Box
	Version: 1.0

-----------------------------------------------------------------------------------*/
class mts_about_author_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'mts_about_author_widget', // Base ID
			__( 'MTS About Author ', 'myportfolio' ), // Name
			array( 'description' => __( 'Author box widget', 'myportfolio' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args	 Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$title = $instance['title'];
		$tagline = $instance['tagline'];
		$bg_img = $instance['bg_img'];

		if(is_single()) {
			$mts_options = get_option(MTS_THEME_NAME); 
			echo $args['before_widget']; ?>
				<div id="about-author" class="postauthor">
					<div class="author-thumbnail" style="background: url('<?php echo $bg_img; ?>') center center no-repeat;">
						<div class="author-container">
							<span class="title"><?php echo $title; ?></span>
							<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '130' );  } ?>
						</div>
						<h5 class="vcard author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="fn"><?php the_author_meta( 'display_name' ); ?></a></h5>
						<span><?php echo $tagline; ?></span>
					</div>
					<p><?php the_author_meta('description') ?></p>
					<?php if ( !empty($mts_options['mts_about_author_buttons']) && is_array($mts_options['mts_about_author_buttons']) ) : ?>
						<div class="author-post-buttons">
							<?php foreach( $mts_options['mts_about_author_buttons'] as $about_me ) :
								if( !empty( $about_me['mts_about_author_buttons_link'] ) && isset( $about_me['mts_about_author_buttons_link'] ) ) : ?>
									<a href="<?php print $about_me['mts_about_author_buttons_link'] ?>" title="<?php print isset( $about_me['mts_about_author_buttons_text'] ) ? $about_me['mts_about_author_buttons_text'] : "" ?>" style="background: <?php print isset( $about_me['mts_about_author_buttons_bg'] ) ? $about_me['mts_about_author_buttons_bg'] : "" ?>;"><span class="<?php print isset( $about_me['mts_about_author_buttons_icon'] ) ? "fa fa-".$about_me['mts_about_author_buttons_icon'] : "" ?>"></span><?php print isset( $about_me['mts_about_author_buttons_text'] ) ? $about_me['mts_about_author_buttons_text'] : "" ?></a>
							<?php endif; endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php
			// After widget (defined by theme functions file)
			echo $args['after_widget'];
		}
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About Me', 'myportfolio' );
		$tagline = ! empty( $instance['tagline'] ) ? $instance['tagline'] : __( 'Web Designer | Photographer', 'myportfolio' );
		$bg_img = ! empty( $instance['bg_img'] ) ? $instance['bg_img'] : get_template_directory_uri()."/images/about-author-bg.jpg";
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','myportfolio' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tagline' ); ?>"><?php _e( 'Tagline:','myportfolio' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'tagline' ); ?>" name="<?php echo $this->get_field_name( 'tagline' ); ?>" type="text" value="<?php echo esc_attr( $tagline ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'bg_img' ); ?>"><?php _e( 'Background Image:','myportfolio' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'bg_img' ); ?>" name="<?php echo $this->get_field_name( 'bg_img' ); ?>" type="text" value="<?php echo esc_attr( $bg_img ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['tagline'] = ( ! empty( $new_instance['tagline'] ) ) ? strip_tags( $new_instance['tagline'] ) : '';
		$instance['bg_img'] = ( ! empty( $new_instance['bg_img'] ) ) ? strip_tags( $new_instance['bg_img'] ) : '';

		return $instance;
	}

} // class mts_about_author_Widget

// register mts_about_author_Widget widget
function register_mts_about_author_widget() {
	register_widget( 'mts_about_author_Widget' );
}
add_action( 'widgets_init', 'register_mts_about_author_widget' );
?>