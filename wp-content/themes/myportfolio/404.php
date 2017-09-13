<?php
/**
 * The template for displaying 404 (Not Found) pages.
 */
get_header(); ?>
<div id="page">
	<div class="container">
		<article class="article">
			<div id="content_box" >
				<header>
					<div class="title">
						<h1><?php _e('Error 404 Not Found', 'myportfolio' ); ?></h1>
					</div>
				</header>
				<div class="post-single-content no-results">
					<p><?php _e('Oops! We couldn\'t find this Page.', 'myportfolio' ); ?></p>
					<p><?php _e('Please check your URL or use the search form below.', 'myportfolio' ); ?></p>
					<?php get_search_form();?>
				</div><!--.post-content--><!--#error404 .post-->
			</div><!--#content-->
		</article>
	</div>
<?php get_footer(); ?>