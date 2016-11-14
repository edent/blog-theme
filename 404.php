<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package edent_simple
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">404!</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<header class="entry-header">
						<h1 class="entry-title">This isn't the page you are looking for...</h1>
					</header>
					<p>
						<a href="https://www.flickr.com/photos/st3f4n/3951143570/">
							<img
								src="https://farm3.staticflickr.com/2465/3951143570_20b4eccd3f.jpg"
								width="500" height="333"
								alt="Two small plastic toy Stormtroopers from Star Wars stare at a computer monitor. They are searching Google for 'The Droids we are looking for'."
								class="wp-image-0 aligncenter"
							>
						</a>
					</p>
					<p>Maybe try one of the links below or a search?</p>

					<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts' );

						// Only show the widget if site has multiple categories.
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
