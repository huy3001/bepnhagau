<?php
/**
 * The template for displaying the header.
 *
 * Displays everything from the doctype declaration down to the navigation.
 */
?>
<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">	   
	<div id="ip-container" class="main-container">
		<header id="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<div id="header" class="<?php echo ( is_home() && 'posts' === get_option('show_on_front') && '1' == $mts_options['mts_loading'] ) ? "ip-logo" : ""; ?>">

				<?php if ( $mts_options['mts_show_primary_nav'] == '1' ) { ?>
					<div id="primary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<div id="dl-menu" class="dl-menuwrapper">
							<button class="dl-trigger"><i class="fa fa-bars"></i></button>
							<button class="dl-close hidden"><i class="fa fa-times"></i></button>
							<?php if ( has_nav_menu( 'mobile' ) ) {
									if ( has_nav_menu( 'primary-menu' ) ) {
										wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'items_wrap' => '<ul class="dl-menu">%3$s</ul>', 'container' => '', 'walker' => new mts_menu_walker ) );
									} else { ?>
										<ul class="dl-menu clearfix">
											<?php wp_list_categories('title_li='); ?>
										</ul>
									<?php }
									wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'menu clearfix', 'items_wrap' => '<ul class="dl-menu">%3$s</ul>', 'container' => '', 'walker' => new mts_menu_walker ) );
								} else {
									if ( has_nav_menu( 'primary-menu' ) ) {
										wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'items_wrap' => '<ul class="dl-menu">%3$s</ul>', 'container' => '', 'walker' => new mts_menu_walker ) );
									} else { ?>
										<ul class="dl-menu clearfix">
											<?php wp_list_categories('title_li='); ?>
										</ul>
									<?php }
							} ?>
						</div>
					</div>
				<?php } ?>

				<div class="logo-wrap">
					<?php if ($mts_options['mts_logo'] != '') {
						$logo_id = mts_get_image_id_from_url( $mts_options['mts_logo'] );
						$logo_w_h = '';
						if ( $logo_id ) {
							$logo	 = wp_get_attachment_image_src( $logo_id, 'full' );
							$logo_w_h = ' width="'.$logo[1].'" height="'.$logo[2].'"';
						}
						if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo" class="image-logo" itemprop="headline">
								<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?>></a>
							</h1><!-- END #logo -->
						<?php } else { ?>
							<h2 id="logo" class="image-logo" itemprop="headline">
								<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?>></a>
							</h2><!-- END #logo -->
						<?php }
					} else {
						if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 id="logo" class="text-logo" itemprop="headline">
								<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
							</h1><!-- END #logo -->
						<?php } else { ?>
							<h2 id="logo" class="text-logo" itemprop="headline">
								<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
							</h2><!-- END #logo -->
						<?php }
					} ?>
					<div class="site-description" itemprop="description">
						<?php bloginfo( 'description' ); ?>
					</div>
				</div>

				<?php mts_cart();

				if ( !empty($mts_options['mts_header_social']) && is_array($mts_options['mts_header_social']) && !empty($mts_options['mts_social_icon_head'])) { ?>
					<div class="header-social">
						<?php foreach( $mts_options['mts_header_social'] as $header_icons ) :
							if( ! empty( $header_icons['mts_header_icon'] ) && isset( $header_icons['mts_header_icon'] ) ) : ?>
								<a href="<?php print $header_icons['mts_header_icon_link'] ?>" class="header-<?php print $header_icons['mts_header_icon'] ?>"><span class="fa fa-<?php print $header_icons['mts_header_icon'] ?>"></span></a>
							<?php endif; endforeach; ?>
					</div>
				<?php } ?>

				<div class="copyrights">
					<?php mts_copyrights_credit(); ?>
				</div>

			</div><!--#header-->

			<?php if ( is_home() && 'posts' === get_option('show_on_front') && '1' == $mts_options['mts_loading'] ) : ?>
				<div class="ip-loader">
					<svg class="ip-inner" width="60px" height="60px" viewBox="0 0 80 80">
						<path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
						<path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
					</svg>
				</div>
			<?php endif; ?>
			
		</header>