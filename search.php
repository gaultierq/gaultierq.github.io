<?php
/**
 * The template for displaying posts in the search results.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0
 */
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<!-- Start : Left Content -->
	<div id="rightcontent">
		<div class="post-wrapper">
			<?php if( is_archive() || is_search() ) : ?>
			<header class="archive-header">
				<h1 class="title"><span><?php echo grateful_archive_title(); ?></span></h1>
			</header>
			<?php endif; ?>

			<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content', get_post_format() ); // get content template
				}
			} else {
				get_template_part( 'content', 'none' ); // display 404 Not found page
			}
			?>
		</div>
	</div> 
<?php get_footer(); ?>