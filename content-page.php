<?php
/**
 * The template for displaying posts in Page.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<!-- Start: Post Type Page -->

<div class="page-header">
	<?php
		// Get featured image
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('blog-image');
		}
	?>
</div>
<div class="box page-inner page-page">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>

	<div class="post-content">
		<?php the_content(); ?>
	</div>

	<footer class="content-footer">
		<?php
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'grateful' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
	</footer>
</div>

<!-- End: Post Type Page -->