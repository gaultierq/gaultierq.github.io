<?php
/**
 * The template for displaying posts in the Status post format.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>
<?php global $grateful_option; ?>

<!-- Start: Post Type Status -->
<article id="post-<?php the_ID(); ?>" <?php post_class('basic-post post-status'); ?>>

	<?php if( function_exists('get_field') && get_field('format_status_embed') ) : ?>
		<?php
		// Get featured image url
		$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		?>
		
		<div class="thumbnail" style="background: url(<?php echo $featured_image; ?>) center center; background-size: cover;">
			<?php
			// Get external status
			if( function_exists('get_field') ) {
				echo wp_oembed_get( esc_url( get_field('format_status_embed') ) );
			}
			?>
		</div>
	<?php endif; ?>

	<div class="post-inner">
		<div class="post-title">
			<?php if( ! is_single() ) : ?>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php else: ?>
				<h1><?php the_title(); ?></h1>
			<?php endif; ?>
		</div>

		<?php echo warrior_post_meta(); // display post meta ?>

		<div class="post-content">
			<?php
			// Check current page
			if( ! is_single() ) {
				the_excerpt();
			} else {
				the_content();
			}
			?>
		</div>

		<?php
		// For all single post
		if( is_single() ) {
			echo '<footer class="content-footer">';
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'grateful' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );

			// Display tags posts
			if( $grateful_option['tags_posts'] ) {
				$post_tags = wp_get_post_tags($post->ID);
				if( !empty($post_tags) ) {
					echo '<div class="tags"><i class="typcn typcn-bookmark"></i>';
					the_tags('<label>'. __('Tags:', 'grateful') .'</label> ', ', ', '');
					echo '</div>';
				}
			}

			get_template_part('includes/share-buttons'); // display share buttons

			get_template_part('includes/post-nav'); // display post navigation

			get_template_part('includes/related-posts'); // display related posts
			
			echo '</footer>';
		} else {
			echo '<div class="read-more"><a href="'. get_permalink() .'">'. __('Read More', 'grateful') .'</a></div>';
		}
		?>
	</div>
</article>
<!-- End: Post Type Status -->