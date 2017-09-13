<?php
$mts_options = get_option(MTS_THEME_NAME);
if ( ! function_exists( 'mts_meta' ) ) {
	/**
	 * Display necessary tags in the <head> section.
	 */
	function mts_meta(){
		global $mts_options, $post;
		?>

		<?php if ( !empty( $mts_options['mts_favicon'] ) ) { ?>
			<link rel="icon" href="<?php echo esc_url( $mts_options['mts_favicon'] ); ?>" type="image/x-icon" />
		<?php } elseif ( function_exists( 'has_site_icon' ) && has_site_icon() ) { ?>
			<?php printf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( get_site_icon_url( 32 ) ) ); ?>
			<?php sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( get_site_icon_url( 192 ) ) ); ?>
		<?php } ?>

		<?php if ( !empty( $mts_options['mts_metro_icon'] ) ) { ?>
			<!-- IE10 Tile.-->
			<meta name="msapplication-TileColor" content="#FFFFFF">
			<meta name="msapplication-TileImage" content="<?php echo esc_url( $mts_options['mts_metro_icon'] ); ?>">
		<?php } elseif ( function_exists( 'has_site_icon' ) && has_site_icon( ) ) { ?>
			<?php printf( '<meta name="msapplication-TileImage" content="%s">', esc_url( get_site_icon_url( 270 ) ) ); ?>
		<?php } ?>

		<?php if ( !empty( $mts_options['mts_touch_icon'] ) ) { ?>
			<!--iOS/android/handheld specific -->
			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( $mts_options['mts_touch_icon'] ); ?>" />
		<?php } elseif ( function_exists( 'has_site_icon' ) && has_site_icon() ) { ?>
			<?php printf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( get_site_icon_url( 180 ) ) ); ?>
		<?php } ?>

		<?php if ( ! empty( $mts_options['mts_responsive'] ) ) { ?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<?php } ?>

		<?php if($mts_options['mts_prefetching'] == '1') { ?>
			<?php if (is_front_page()) { ?>
				<?php $my_query = new WP_Query('posts_per_page=1'); while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<link rel="prefetch" href="<?php the_permalink(); ?>">
				<link rel="prerender" href="<?php the_permalink(); ?>">
				<?php endwhile; wp_reset_postdata(); ?>
			<?php } elseif (is_singular()) { ?>
				<link rel="prefetch" href="<?php echo esc_url( home_url() ); ?>">
				<link rel="prerender" href="<?php echo esc_url( home_url() ); ?>">
			<?php } ?>
		<?php } ?>

		<meta itemprop="name" content="<?php bloginfo( 'name' ); ?>" />
		<meta itemprop="url" content="<?php echo esc_url( site_url() ); ?>" />

		<?php if ( is_singular() ) { ?>
			<?php $user_info = get_userdata($post->post_author); ?>
			<?php if ( $user_info && ! empty( $user_info->first_name ) && ! empty( $user_info->last_name ) ) : ?>
				<meta itemprop="creator accountablePerson" content="<?php echo $user_info->first_name.' '.$user_info->last_name; ?>" />
			<?php endif; ?>
		<?php } ?>
<?php
	}
}

if ( ! function_exists( 'mts_head' ) ){
	/**
	 * Display header code from Theme Options.
	 */
	function mts_head() {
	global $mts_options;
?>
<?php echo $mts_options['mts_header_code']; ?>
<?php }
}
add_action('wp_head', 'mts_head');

if ( ! function_exists( 'mts_copyrights_credit' ) ) {
	/**
	 * Display the footer copyright.
	 */
	function mts_copyrights_credit() { 
	global $mts_options;
?>
<!--start copyrights-->
<div class="row" id="copyright-note">
<?php $copyright_text = '<a href=" ' . esc_url( trailingslashit( home_url() ) ). '" title=" ' . get_bloginfo('description') . '">' . get_bloginfo('name') . '</a> Copyright &copy; ' . date("Y") . '.'; ?>
<span><?php echo apply_filters( 'mts_copyright_content', $copyright_text ); echo '<br/>'.$mts_options['mts_copyrights']; ?></span>
</div>
<!--end copyrights-->
<?php }
}

if ( ! function_exists( 'mts_footer' ) ) {
	/**
	 * Display the analytics code in the footer.
	 */
	function mts_footer() { 
	global $mts_options;
?>
	<?php if ($mts_options['mts_analytics_code'] != '') { ?>
	<!--start footer code-->
		<?php echo $mts_options['mts_analytics_code']; ?>
	<!--end footer code-->
	<?php }
	}
}

if (!function_exists('mts_the_breadcrumb')) {
	/**
	 * Display the breadcrumbs.
	 */
	function mts_the_breadcrumb() {
		if ( is_front_page() ) {
			return;
		}
		echo '<div typeof="v:Breadcrumb" class="root"><a rel="v:url" property="v:title" href="';
		echo esc_url( home_url() );
		echo '">'.esc_html(sprintf( __( "Home", 'myportfolio' )));
		echo '</a></div><div>/</div>';
		if (is_single()) {
			$categories = get_the_category();
			if ( $categories ) {
				$level = 0;
				$hierarchy_arr = array();
				foreach ( $categories as $cat ) {
					$anc = get_ancestors( $cat->term_id, 'category' );
					$count_anc = count( $anc );
					if (  0 < $count_anc && $level < $count_anc ) {
						$level = $count_anc;
						$hierarchy_arr = array_reverse( $anc );
						array_push( $hierarchy_arr, $cat->term_id );
					}
				}
				if ( empty( $hierarchy_arr ) ) {
					$category = $categories[0];
					echo '<div typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></div><div>/</div>';
				} else {
					foreach ( $hierarchy_arr as $cat_id ) {
						$category = get_term_by( 'id', $cat_id, 'category' );
						echo '<div typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></div><div>/</div>';
					}
				}
			}
			echo "<div><span>";
			the_title();
			echo "</span></div>";
		} elseif (is_page()) {
			$parent_id  = wp_get_post_parent_id( get_the_ID() );
			if ( $parent_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = '<div typeof="v:Breadcrumb"><a href="'.esc_url( get_permalink( $page->ID ) ).'" rel="v:url" property="v:title">'.esc_html( get_the_title($page->ID) ). '</a></div><div>/</div>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) { echo $crumb; }
			}
			echo "<div><span>";
			the_title();
			echo "</span></div>";
		} elseif (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$this_cat_id = $cat_obj->term_id;
			$hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
			if ( $hierarchy_arr ) {
				$hierarchy_arr = array_reverse( $hierarchy_arr );
				foreach ( $hierarchy_arr as $cat_id ) {
					$category = get_term_by( 'id', $cat_id, 'category' );
					echo '<div typeof="v:Breadcrumb"><a href="'.esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></div><div>/</div>';
				}
			}
			echo "<div><span>";
			single_cat_title();
			echo "</span></div>";
		} elseif (is_author()) {
			echo "<div><span>";
			if(get_query_var('author_name')) :
				$curauth = get_user_by('slug', get_query_var('author_name'));
			else :
				$curauth = get_userdata(get_query_var('author'));
			endif;
			echo esc_html( $curauth->nickname );
			echo "</span></div>";
		} elseif (is_search()) {
			echo "<div><span>";
			the_search_query();
			echo "</span></div>";
		} elseif (is_tag()) {
			echo "<div><span>";
			single_tag_title();
			echo "</span></div>";
		}
	}
}

/**
 * Display schema-compliant the_category()
 *
 * @param string $separator
 */
function mts_the_category( $separator = ', ' ) {
	$categories = get_the_category();
	$count = count($categories);
	foreach ( $categories as $i => $category ) {
		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . sprintf( __( "View all posts in %s", 'myportfolio' ), esc_attr( $category->name ) ) . '">' . esc_html( $category->name ).'</a>';
		if ( $i < $count - 1 )
			echo $separator;
	}
}

/**
 * Display schema-compliant the_tags()
 *
 * @param string $before
 * @param string $sep
 * @param string $after
 */
function mts_the_tags($before = '', $sep = ', ', $after = '</div>') {
	if ( empty( $before ) ) {
		$before = '<div class="tags border-bottom">'.__('Tags: ', 'myportfolio' );
	}

	$tags = get_the_tags();
	if (empty( $tags ) || is_wp_error( $tags ) ) {
		return;
	}
	$tag_links = array();
	foreach ($tags as $tag) {
		$link = get_tag_link($tag->term_id);
		$tag_links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $tag->name . '</a>';
	}
	echo $before.join($sep, $tag_links).$after;
}

/*------------[ pagination ]-------------*/
if (!function_exists('mts_pagination')) {
	/**
	 * Display the pagination.
	 *
	 * @param string $pages
	 * @param int $range
	 */
	function mts_pagination( $pages = '', $range = 3, $pagenavigation_type = 'mts_pagenavigation_type' ) {
		$mts_options = get_option(MTS_THEME_NAME);
		if (isset($mts_options[$pagenavigation_type]) && $mts_options[$pagenavigation_type] == '1' ) { // numeric pagination
			the_posts_pagination( array(
				'mid_size' => 3,
				'prev_text' => '<i class="fa fa-angle-left"></i>',
				'next_text' => '<i class="fa fa-angle-right"></i>',
			) );
		} else { // traditional or ajax pagination ?>
			<div class="pagination pagination-previous-next">
				<ul>
					<li class="nav-previous"><?php next_posts_link( '<i class="fa fa-angle-left"></i> '. __( 'Previous', 'myportfolio' ) ); ?></li>
					<li class="nav-next"><?php previous_posts_link( __( 'Next', 'myportfolio' ).' <i class="fa fa-angle-right"></i>' ); ?></li>
				</ul>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mts_cart' ) ) {
	/**
	 * Display the woo-commerce login/register link and the cart.
	 */
	function mts_cart() { 
	   if (mts_is_wc_active()) {
	   global $mts_options;
?>
<div class="mts-cart">
	<?php global $woocommerce; ?>
		<?php if ( is_user_logged_in() ) { ?>
			<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php _e('My Account', 'myportfolio' ); ?>"><i class="fa fa-user"></i> <?php _e('My Account', 'myportfolio' ); ?></a>
		<?php } 
		else { ?>
			<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php _e('Login / Register', 'myportfolio' ); ?>"><i class="fa fa-user"></i> <?php _e('Login ', 'myportfolio' ); ?></a>
		<?php } ?>

		<a class="cart-contents" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e('View your shopping cart', 'myportfolio' ); ?>"><i class="fa fa-shopping-cart"></i>  <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'myportfolio' ), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
</div>
<?php } 
	}
}

if (!function_exists('mts_related_posts')) {
	/**
	 * Display the related posts.
	 */
	function mts_related_posts() {
		$post_id = get_the_ID();
		$mts_options = get_option(MTS_THEME_NAME);
		$post_format = get_post_format();
		//if(!empty($mts_options['mts_related_posts'])) { ?>	
			<!-- Start Related Posts -->
			<?php 
			$empty_taxonomy = false;
			if (empty($mts_options['mts_related_posts_taxonomy']) || $mts_options['mts_related_posts_taxonomy'] == 'tags') {
				// related posts based on tags
				$tags = get_the_tags($post_id);
				if (empty($tags)) { 
					$empty_taxonomy = true;
				} else {
					$tag_ids = array(); 
					foreach($tags as $individual_tag) {
						$tag_ids[] = $individual_tag->term_id; 
					}
					$args = array( 'tag__in' => $tag_ids, 
						'post__not_in' => array($post_id),
						'posts_per_page' => isset( $mts_options['mts_related_postsnum'] ) ? $mts_options['mts_related_postsnum'] : 3,
						'ignore_sticky_posts' => 1, 
						'orderby' => 'rand' 
					);
				}
			 } else {
				// related posts based on categories
				$categories = get_the_category($post_id);
				if (empty($categories)) { 
					$empty_taxonomy = true;
				} else {
					$category_ids = array(); 
					foreach($categories as $individual_category) 
						$category_ids[] = $individual_category->term_id; 
					$args = array( 'category__in' => $category_ids, 
						'post__not_in' => array($post_id),
						'posts_per_page' => $mts_options['mts_related_postsnum'],  
						'ignore_sticky_posts' => 1, 
						'orderby' => 'rand' 
					);
				}
			 }
			if (!$empty_taxonomy) {
			$my_query = new WP_Query( $args ); if( $my_query->have_posts() ) {
				echo '<div class="related-posts">';
				echo '<h4>'.__('Posts you may also like', 'myportfolio' ).'</h4>';
				echo '<div class="clear">';
				$posts_per_row = 3;
				$n = 0; $j = 0;
				while( $my_query->have_posts() ) { $my_query->the_post(); ?>
				<article class="latestPost excerpt<?php echo (++$j % 3 == 0) ? ' last' : ''; ?><?php echo (++$n % 3 == 1) ? ' first' : ''; ?>">
					<?php get_template_part( 'post-format/related-format', get_post_format() ); ?>
					<header>
						<?php $post_format = (get_post_format()) ? get_post_format() : 'standard';
						$icon_default = array('standard' => 'fa-thumb-tack', 'audio' => 'fa-volume-down', 'video' => 'fa-video-camera','quote' => 'fa-quote-left', 'link' => 'fa-link', 'gallery' => 'fa-th-large');
						$icon = isset( $icon_default[$post_format] ) ? $icon_default[$post_format] : 'fa-thumb-tack';
						echo '<div class="center"><div class="format-icon"><i class="fa '.$icon.'"></i></div></div>'; ?>
						<h3 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h3>
					</header>
					<div class="front-view-content">
						<?php echo mts_excerpt(15); ?>
					</div>
					<div class="post-info">
						<span class="thetime date updated"><i class="fa fa-clock-o"></i> <span><?php the_time('M j, Y'); ?></span></span>
						<?php mts_readmore(); ?>
					</div>
				</article>
				<?php } echo '</div></div>'; }} wp_reset_postdata(); ?>
			<!-- .related-posts -->
		<?php //}
	}
}

/*------------[ Post Meta Info ]-------------*/
if ( ! function_exists('mts_the_postinfo' ) ) {
	/**
	 * Display the post info block.
	 *
	 * @param string $section
	 */
	function mts_the_postinfo( $section = 'home' ) {
		$mts_options = get_option( MTS_THEME_NAME );
		$opt_key = 'mts_'.$section.'_headline_meta_info';
		
		if ( isset( $mts_options[ $opt_key ] ) && is_array( $mts_options[ $opt_key ] ) && array_key_exists( 'enabled', $mts_options[ $opt_key ] ) ) {
			$headline_meta_info = $mts_options[ $opt_key ]['enabled'];
		} else {
			$headline_meta_info = array();
		}
		if ( ! empty( $headline_meta_info ) ) { ?>
			<div class="post-info">
				<?php foreach( $headline_meta_info as $key => $meta ) { mts_the_postinfo_item( $key ); } ?>
			</div>
		<?php }
	}
}
if ( ! function_exists('mts_the_postinfo_item' ) ) {
	/**
	 * Display information of an item.
	 * @param $item
	 */
	function mts_the_postinfo_item( $item ) {
		switch ( $item ) {
			case 'author':
			?>
				<span class="theauthor"><i class="fa fa-user"></i> <span><?php the_author_posts_link(); ?></span></span>
			<?php
			break;
			case 'date':
			?>
				<span class="thetime date updated"><i class="fa fa-clock-o"></i> <span><?php the_time('M j, Y'); ?></span></span>
			<?php
			break;
			case 'category':
			?>
				<span class="thecategory"><i class="fa fa-tags"></i> <?php mts_the_category(', ') ?></span>
			<?php
			break;
			case 'comment':			
				if( is_single() ) { ?>
					<span class="thecomment"><i class="fa fa-comments-o"></i> <a href="<?php echo esc_url( get_comments_link() ); ?>" itemprop="interactionCount"><?php comments_number();?></a></span>
				<?php } else { ?>
					<span class="thecomment"><i class="fa fa-comments-o"></i> <a href="<?php echo esc_url( get_comments_link() ); ?>" itemprop="interactionCount"><?php comments_number(__('0', 'myportfolio' ), __('1', 'myportfolio' ),  __('%', 'myportfolio' ) );?></a></span>
				<?php }
			break;
			case 'readmore':
				mts_readmore();
			break;
		}
	}
}

if (!function_exists('mts_social_buttons')) {
	/**
	 * Display the social sharing buttons.
	 */
	function mts_social_buttons() {
		$mts_options = get_option( MTS_THEME_NAME );
		$buttons = array();

		if ( isset( $mts_options['mts_social_buttons'] ) && is_array( $mts_options['mts_social_buttons'] ) && array_key_exists( 'enabled', $mts_options['mts_social_buttons'] ) ) {
			$buttons = $mts_options['mts_social_buttons']['enabled'];
		}

		if ( ! empty( $buttons ) ) {
		?>
			<!-- Start Share Buttons -->
			<div class="shareit <?php echo $mts_options['mts_social_button_position']; ?>">
				<?php foreach( $buttons as $key => $button ) { mts_social_button( $key ); } ?>
			</div>
			<!-- end Share Buttons -->
		<?php
		}
	}
}

if ( ! function_exists('mts_social_button' ) ) {
	/**
	 * Display network-independent sharing buttons.
	 *
	 * @param $button
	 */
	function mts_social_button( $button ) {
		$mts_options = get_option( MTS_THEME_NAME );
		switch ( $button ) {
			case 'facebookshare':
			?>
				<!-- Facebook Share-->
				<span class="share-item facebooksharebtn">
					<div class="fb-share-button" data-layout="button_count"></div>
				</span>
			<?php
			break;
			case 'twitter':
			?>
				<!-- Twitter -->
				<span class="share-item twitterbtn">
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo esc_attr( $mts_options['mts_twitter_username'] ); ?>"><?php esc_html_e( 'Tweet', 'myportfolio' ); ?></a>
				</span>
			<?php
			break;
			case 'gplus':
			?>
				<!-- GPlus -->
				<span class="share-item gplusbtn">
					<g:plusone size="medium"></g:plusone>
				</span>
			<?php
			break;
			case 'facebook':
			?>
				<!-- Facebook -->
				<span class="share-item facebookbtn">
					<div id="fb-root"></div>
					<div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
				</span>
			<?php
			break;
			case 'pinterest':
			?>
				<!-- Pinterest -->
				<span class="share-item pinbtn">
					<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large' ); echo $thumb['0']; ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="horizontal"><?php esc_html_e( 'Pin It', 'myportfolio' ); ?></a>
				</span>
			<?php
			break;
			case 'linkedin':
			?>
				<!--Linkedin -->
				<span class="share-item linkedinbtn">
					<script type="IN/Share" data-url="<?php echo esc_url( get_the_permalink() ); ?>"></script>
				</span>
			<?php
			break;
			case 'stumble':
			?>
				<!-- Stumble -->
				<span class="share-item stumblebtn">
					<su:badge layout="1"></su:badge>
				</span>
			<?php
			break;
		}
	}
}

if ( ! function_exists( 'mts_article_class' ) ) {
	/**
	 * Custom `<article>` class name.
	 */
	function mts_article_class() {
		$mts_options = get_option( MTS_THEME_NAME );
		$class = 'article';
		
		// sidebar or full width
		if ( mts_custom_sidebar() == 'mts_nosidebar' ) {
			$class = 'ss-full-width';
		}
		
		echo $class;
	}
}

if ( ! function_exists( 'mts_single_page_class' ) ) {
	/**
	 * Custom `#page` class name.
	 */
	function mts_single_page_class() {
		$class = '';

		if ( is_single() || is_page() ) {

			$class = 'single';

			$header_animation = mts_get_post_header_effect();
			if ( !empty( $header_animation )) $class .= ' '.$header_animation;
		}

		echo $class;
	}
}

if ( ! function_exists( 'mts_archive_post' ) ) {
	/**
	 * Display a post of specific layout.
	 * 
	 * @param string $layout
	 */
	function mts_archive_post( $layout = '' ) {

		$mts_options = get_option(MTS_THEME_NAME);
		$post_format = get_post_format();
		get_template_part( 'post-format/format', get_post_format() ); ?>
		<header>
			<?php $post_format = (get_post_format()) ? get_post_format() : 'standard';
			$icon_default = array('standard' => 'fa-thumb-tack', 'audio' => 'fa-volume-down', 'video' => 'fa-video-camera','quote' => 'fa-quote-left', 'link' => 'fa-link', 'gallery' => 'fa-th-large');
			$icon = isset( $icon_default[$post_format] ) ? $icon_default[$post_format] : 'fa-thumb-tack';
			echo '<div class="center"><div class="format-icon"><i class="fa '.$icon.'"></i></div></div>'; ?>
			<h2 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="mts-blog-loader-link"><?php the_title(); ?></a></h2>
		</header>
		<?php $content = get_the_content();
		if(trim($content) != "" && $post_format != 'quote') : ?>
			<div class="front-view-content">
				<?php echo mts_excerpt(15); ?>
			</div>
		<?php endif;
		mts_the_postinfo();
	}
}

if ( ! function_exists('mts_post_loader' ) ) {
	/**
	 * Display post/portfolio preloader.
	 */
	function mts_post_loader() {
		$mts_options = get_option( MTS_THEME_NAME );
		$display = false;

		if ( '1' == $mts_options['mts_loading'] ) {
			if ( is_singular( 'post' ) || is_archive() || is_search() || is_page_template( 'page-blog.php' ) ) {
				$display = true;
			} else if ( is_singular( 'portfolio' ) || is_home() ) {
				$display = true;
			}
		}

		if ( $display ) {
			$shown_class = is_singular() ? ' content--show' : '';
			?>
			<div class="grid-popup-content<?php echo $shown_class; ?>">
				<div class="ball-grid-pulse"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			</div>
			<?php
		}
	}
}