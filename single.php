<?php
/**
 * The Template for displaying all single posts.
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
				get_template_part( 'content', get_post_format() );// get content template

				if( $grateful_option['about_author'] ) {
					get_template_part('includes/author-bio'); // display author description
				}

				if( $grateful_option['comments_posts'] ) {
					comments_template( '', true ); // display comments
				}
			}
		} else {
			get_template_part( 'content', 'none' ); // display 404 Not found page
		}
		?>
	</div>
</div>

<?php get_footer(); ?>