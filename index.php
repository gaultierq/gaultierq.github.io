<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?> 

<?php get_header(); ?>

<?php get_sidebar(); ?>

<?php global $grateful_option; ?>

<!-- Start : Left Content -->
	<div id="rightcontent">
		<?php
		// Display posts carousel slider
		if( is_home() || is_front_page() ) {
			if( $grateful_option['post_carousel_slider'] ) {
				get_template_part('includes/carousel-slider');
			}
		}
		?>

		<div class="post-wrapper">
			<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content', get_post_format() ); // get content template
				}
				get_template_part( 'includes/pagination' ); // display pagination
			} else {
				get_template_part( 'content', 'none' ); // display 404 Not found page
			}
			?>
		</div>	
	</div>
	<div class="clearfix"></div>
<?php get_footer(); ?>