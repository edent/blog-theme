<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package edent_simple
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
				edent_byline();
				// edent_simple_posted_on();
			?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	<hr class="hr-top"/>
	<div class="entry-content">
		<?php
			if ( is_single() ) :
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'edent_simple' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				?>
				<footer class="entry-footer">
					<?php edent_simple_entry_footer(); ?>
				</footer><!-- .entry-footer -->
				<?php

				// wp_link_pages( array(
				// 	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edent_simple' ),
				// 	'after'  => '</div>',
				// ) );
			else :
				if ( has_post_thumbnail() ) {
					echo '<a href="' . esc_url( get_permalink() ) .'">'.get_the_post_thumbnail(get_the_ID(),'full').'</a>';
					// the_post_thumbnail('full');
				}
				the_excerpt();
			endif;

		?>
	</div><!-- .entry-content -->


</article><!-- #post-## -->
