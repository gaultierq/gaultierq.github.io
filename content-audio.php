<?php
/**
 * The template for displaying posts in the Audio post format.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>
<?php global $grateful_option; ?>

<!-- Start: Post Type Audio -->
<article id="post-<?php the_ID(); ?>" <?php post_class('basic-post post-audio'); ?>>
	<?php if( function_exists('get_field') && get_field('format_audio_embed') ) : ?>
		<div class="thumbnail video-holder">
			<?php
			// Get featured image
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('blog-image');
			}
			
			// Get external status
			if( function_exists('get_field') ) {
				echo '<div class="embed-player">' . apply_filters('the_content', esc_url( get_field('format_audio_embed') ) ). '</div>';
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
<!-- End: Post Type Audio -->