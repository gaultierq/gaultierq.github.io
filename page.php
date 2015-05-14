<?php
/**
 * The template for displaying Page post type.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<?php get_header(); ?>

<?php get_sidebar(); ?>

<!-- Start : Left Content -->
	<div id="rightcontent">
		<div class="post-wrapper">
			<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content', 'page' ); // get content template
				}
			} else {
				get_template_part( 'content', 'none' ); // display 404 Not found page
			}
			?>
		</div>
	</div> 
<?php get_footer(); ?>