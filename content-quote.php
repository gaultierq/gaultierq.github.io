<?php
/**
 * The template for displaying posts in the Quote post format.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>
<?php global $grateful_option; ?>

<!-- Start: Post Type Quote -->
<?php
	// Get featured image url
	$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('basic-post post-quote'); ?>>
	<div class="bg-opacity"></div>

	<div class="post-inner">
		<blockquote><?php the_content(); ?></blockquote>
		<a href="<?php the_permalink(); ?>"></a>

		<?php if( function_exists('get_field') && get_field('format_quote_source') ) : ?>
			<cite><?php echo esc_attr( get_field('format_quote_source') ); ?></cite>
		<?php endif; ?>
	</div>
</article>
<!-- End: Post Type Quote --> 