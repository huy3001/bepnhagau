<?php

/**
 * Add a "Sidebar" selection metabox.
 */
function mts_add_sidebar_metabox() {
	$screens = array('post', 'page', 'portfolio');
	foreach ($screens as $screen) {
		add_meta_box(
			'mts_sidebar_metabox',				  // id
			__('Sidebar', 'myportfolio' ),	// title
			'mts_inner_sidebar_metabox',			// callback
			$screen,								// post_type
			'side',								 // context (normal, advanced, side)
			'high'							   // priority (high, core, default, low)
													// callback args ($post passed by default)
		);
	}
}
add_action('add_meta_boxes', 'mts_add_sidebar_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_sidebar_metabox($post) {
	global $wp_registered_sidebars;
	
	// Add an nonce field so we can check for it later.
	wp_nonce_field('mts_inner_sidebar_metabox', 'mts_inner_sidebar_metabox_nonce');
	
	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$custom_sidebar = get_post_meta( $post->ID, '_mts_custom_sidebar', true );
	$sidebar_location = get_post_meta( $post->ID, '_mts_sidebar_location', true );

	// Select custom sidebar from dropdown
	echo '<select name="mts_custom_sidebar" id="mts_custom_sidebar" style="margin-bottom: 10px;">';
	echo '<option value="" '.selected('', $custom_sidebar).'>-- '.__('Default', 'myportfolio' ).' --</option>';
	
	// Exclude built-in sidebars
	$hidden_sidebars = array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar');	
	
	foreach ($wp_registered_sidebars as $sidebar) {
		if (!in_array($sidebar['id'], $hidden_sidebars)) {
			echo '<option value="'.esc_attr($sidebar['id']).'" '.selected($sidebar['id'], $custom_sidebar, false).'>'.$sidebar['name'].'</option>';
		}
	}
	echo '<option value="mts_nosidebar" '.selected('mts_nosidebar', $custom_sidebar).'>-- '.__('No sidebar --', 'myportfolio' ).'</option>';
	echo '</select><br />';
	
	// Select single layout (left/right sidebar)
	echo '<div class="mts_sidebar_location_fields">';
	echo '<label for="mts_sidebar_location_default" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_default" value=""'.checked('', $sidebar_location, false).'>'.__('Default side', 'myportfolio' ).'</label>';
	echo '<label for="mts_sidebar_location_left" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_left" value="left"'.checked('left', $sidebar_location, false).'>'.__('Left', 'myportfolio' ).'</label>';
	echo '<label for="mts_sidebar_location_right" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_right" value="right"'.checked('right', $sidebar_location, false).'>'.__('Right', 'myportfolio' ).'</label>';
	echo '</div>';
	
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			function mts_toggle_sidebar_location_fields() {
				$('.mts_sidebar_location_fields').toggle(($('#mts_custom_sidebar').val() != 'mts_nosidebar'));
			}
			mts_toggle_sidebar_location_fields();
			$('#mts_custom_sidebar').change(function() {
				mts_toggle_sidebar_location_fields();
			});
		});
	</script>
	<?php
	//debug
	//global $wp_meta_boxes;
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_custom_sidebar( $post_id ) {
	
	/*
	* We need to verify this came from our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/
	
	// Check if our nonce is set.
	if ( ! isset( $_POST['mts_inner_sidebar_metabox_nonce'] ) )
	return $post_id;
	
	$nonce = $_POST['mts_inner_sidebar_metabox_nonce'];
	
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'mts_inner_sidebar_metabox' ) )
	  return $post_id;
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return $post_id;
	
	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
	
	if ( ! current_user_can( 'edit_page', $post_id ) )
		return $post_id;
	
	} else {
	
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	}
	
	/* OK, its safe for us to save the data now. */
	
	// Sanitize user input.
	$sidebar_name = sanitize_text_field( $_POST['mts_custom_sidebar'] );
	$sidebar_location = sanitize_text_field( $_POST['mts_sidebar_location'] );
	
	// Update the meta field in the database.
	update_post_meta( $post_id, '_mts_custom_sidebar', $sidebar_name );
	update_post_meta( $post_id, '_mts_sidebar_location', $sidebar_location );
}
add_action( 'save_post', 'mts_save_custom_sidebar' );


/**
 * Add "Post Template" selection meta box
 */
function mts_add_posttemplate_metabox() {
	add_meta_box(
		'mts_posttemplate_metabox',		 // id
		__('Template', 'myportfolio' ),	  // title
		'mts_inner_posttemplate_metabox',   // callback
		'post',							 // post_type
		'side',							 // context (normal, advanced, side)
		'high'							  // priority (high, core, default, low)
	);
}
//add_action('add_meta_boxes', 'mts_add_posttemplate_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_posttemplate_metabox($post) {
	
	// Add an nonce field so we can check for it later.
	wp_nonce_field('mts_inner_posttemplate_metabox', 'mts_inner_posttemplate_metabox_nonce');
	
	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$posttemplate = get_post_meta( $post->ID, '_mts_posttemplate', true );

	// Select post template
	echo '<select name="mts_posttemplate" style="margin-bottom: 10px;">';
	echo '<option value="" '.selected('', $posttemplate).'>'.__('Default Post Template', 'myportfolio' ).'</option>';
	echo '<option value="parallax" '.selected('parallax', $posttemplate).'>'.__('Parallax Template', 'myportfolio' ).'</option>';
	echo '<option value="zoomout" '.selected('zoomout', $posttemplate).'>'.__('Zoom Out Effect Template', 'myportfolio' ).'</option>';
	echo '</select><br />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_posttemplate( $post_id ) {
	
	/*
	* We need to verify this came from our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/
	
	// Check if our nonce is set.
	if ( ! isset( $_POST['mts_inner_posttemplate_metabox_nonce'] ) )
	return $post_id;
	
	$nonce = $_POST['mts_inner_posttemplate_metabox_nonce'];
	
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'mts_inner_posttemplate_metabox' ) )
	  return $post_id;
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return $post_id;
	
	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
	
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	
	} else {
	
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	/* OK, its safe for us to save the data now. */
	
	// Sanitize user input.
	$posttemplate = sanitize_text_field( $_POST['mts_posttemplate'] );
	
	// Update the meta field in the database.
	update_post_meta( $post_id, '_mts_posttemplate', $posttemplate );
}
add_action( 'save_post', 'mts_save_posttemplate' );

// Related function: mts_get_posttemplate( $single_template ) in functions.php

/**
 * Add "Page Header Animation" metabox.
 */
function mts_add_postheader_metabox() {
	$screens = array('page');
	foreach ($screens as $screen) {
		add_meta_box(
			'mts_postheader_metabox',				  // id
			__('Header Animation', 'myportfolio' ),	// title
			'mts_inner_postheader_metabox',			// callback
			$screen,								// post_type
			'side',								 // context (normal, advanced, side)
			'high'							   // priority (high, core, default, low)
													// callback args ($post passed by default)
		);
	}
}
add_action('add_meta_boxes', 'mts_add_postheader_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_postheader_metabox($post) {
	
	// Add an nonce field so we can check for it later.
	wp_nonce_field('mts_inner_postheader_metabox', 'mts_inner_postheader_metabox_nonce');
	
	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$postheader = get_post_meta( $post->ID, '_mts_postheader', true );

	// Select post header effect
	echo '<select name="mts_postheader" style="margin-bottom: 10px;">';
	echo '<option value="" '.selected('', $postheader).'>'.__('None', 'myportfolio' ).'</option>';
	echo '<option value="parallax" '.selected('parallax', $postheader).'>'.__('Parallax Effect', 'myportfolio' ).'</option>';
	echo '<option value="zoomout" '.selected('zoomout', $postheader).'>'.__('Zoom Out Effect', 'myportfolio' ).'</option>';
	echo '</select><br />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 *
 * @see mts_get_post_header_effect
 */
function mts_save_postheader( $post_id ) {
	
	/*
	* We need to verify this came from our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/
	
	// Check if our nonce is set.
	if ( ! isset( $_POST['mts_inner_postheader_metabox_nonce'] ) )
	return $post_id;
	
	$nonce = $_POST['mts_inner_postheader_metabox_nonce'];
	
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'mts_inner_postheader_metabox' ) )
	  return $post_id;
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return $post_id;
	
	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
	
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	
	} else {
	
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	/* OK, its safe for us to save the data now. */
	
	// Sanitize user input.
	$postheader = sanitize_text_field( $_POST['mts_postheader'] );
	
	// Update the meta field in the database.
	update_post_meta( $post_id, '_mts_postheader', $postheader );
}
add_action( 'save_post', 'mts_save_postheader' );


/**
 * Include and setup custom metaboxes and fields for Portfolio post type.
 *
 * @category myPortfolio
 * @package  myPortfolio
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link	 https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool			 True if metabox should show
 */
function mts_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool					 True if metabox should show
 */
function mts_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array	  $field_args Array of field arguments.
 * @param  CMB2_Field $field	  The field object
 */
function mts_render_row_cb( $field_args, $field ) {
	$classes	 = $field->row_classes();
	$id		  = $field->args( 'id' );
	$label	   = $field->args( 'name' );
	$name		= $field->args( '_name' );
	$value	   = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo $classes; ?>">
		<p><label for="<?php echo $id; ?>"><?php echo $label; ?></label></p>
		<p><input id="<?php echo $id; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo $description; ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array	  $field_args Array of field arguments.
 * @param  CMB2_Field $field	  The field object
 */
function mts_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo $field->row_classes(); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo $field->args( 'description' ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array			 $field_args Array of field parameters
 * @param  CMB2_Field object $field	  Field object
 */
function mts_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_init', 'mts_register_portfolio_single_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function mts_register_portfolio_single_metabox() {
	$prefix = 'mts_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'			=> $prefix . 'portfolio_info',
		'title'		 => __( 'Custom Portfolio Info', 'myportfolio' ),
		'object_types'  => array( 'portfolio', ), // Post type
		'context'	  => 'normal',
		'priority'	 => 'high',
		'show_names'   => true, // Show field names on the left
	) );

	$cmb_group->add_field( array(
		'id'   => $prefix . 'portfolio_gallery',
		'name' => __( 'Gallery Images', 'myportfolio' ),
		'desc' => __( 'Upload or Select Gallery Images from here. NOTE: If this option is empty, then slider will show attached images to this post.', 'myportfolio' ),
		'type' => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		'text' => array(
			'add_upload_files_text' => __( 'Add or Upload Images', 'myportfolio' ), // default: "Add or Upload Files"
	    ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'		  => $prefix . 'portfolio_entries',
		'type'		=> 'group',
		'options'	 => array(
			'group_title'   => __( 'Entry {#}', 'myportfolio' ), // {#} gets replaced by row number
			'add_button'	=> __( 'Add Another Entry', 'myportfolio' ),
			'remove_button' => __( 'Remove Entry', 'myportfolio' ),
			'sortable'	  => true, // beta
			'closed'	 => false, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'	   => __( 'Entry Title', 'myportfolio' ),
		'id'		 => 'title',
		'type'	   => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'		=> __( 'Description', 'myportfolio' ),
		'description' => __( 'Write a short description for this entry', 'myportfolio' ),
		'id'		  => 'description',
		'type'		=> 'textarea_small',
	) );

}