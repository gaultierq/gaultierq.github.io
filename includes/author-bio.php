<?php
/**
 * Template for displaying author bio.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<?php global $grateful_option; ?>

<!-- Start author bio -->
<div class="single-author box clearfix">
	<h3 class="widget-title"><?php _e('About the Author', 'grateful'); ?></h3>
	<div class="wrapper">
		<div class="thumbnail">
			<?php echo get_avatar( $post->post_author, '80' ); ?>
		</div>

		<div class="info">
			<h5><?php the_author_posts_link(); ?></h5>
			<?php echo wpautop( get_the_author_meta('description', $post->post_author) ); ?>

			<?php
			// Get social media profile value
			$author_id = get_the_author_meta( 'ID' );

			$url_facebook = get_field('url_facebook', 'user_'. $author_id );
			$url_twitter = get_field('url_twitter', 'user_'. $author_id );
			$url_instagram = get_field('url_instagram', 'user_'. $author_id );
			$url_gplus = get_field('url_gplus', 'user_'. $author_id );
			$url_pinterest = get_field('url_pinterest', 'user_'. $author_id );
			$url_youtube = get_field('url_youtube', 'user_'. $author_id );
			$url_vimeo = get_field('url_vimeo', 'user_'. $author_id );
			$url_linkedin = get_field('url_linkedin', 'user_'. $author_id );
			?>

			<ul class="social-profiles">
				<?php if( $url_facebook ) : ?>
					<li><a href="<?php echo esc_url( $url_facebook ); ?>" target="_blank"><i class="typcn typcn-social-facebook"></i></a></li>
				<?php endif; ?>

				<?php if( $url_twitter ) : ?>
					<li><a href="<?php echo esc_url( $url_twitter ); ?>" target="_blank"><i class="typcn typcn-social-twitter"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_instagram ) : ?>
					<li><a href="<?php echo esc_url( $url_instagram ); ?>" target="_blank"><i class="typcn typcn-social-instagram"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_gplus ) : ?>
					<li><a href="<?php echo esc_url( $url_gplus ); ?>" target="_blank"><i class="typcn typcn-social-google-plus"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_pinterest ) : ?>
					<li><a href="<?php echo esc_url( $url_pinterest ); ?>" target="_blank"><i class="typcn typcn-social-pinterest"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_youtube ) : ?>
					<li><a href="<?php echo esc_url( $url_youtube ); ?>" target="_blank"><i class="typcn typcn-social-youtube"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_vimeo ) : ?>
					<li><a href="<?php echo esc_url( $url_vimeo ); ?>" target="_blank"><i class="typcn typcn-social-vimeo"></i></a></li>
				<?php endif; ?>
				
				<?php if( $url_linkedin ) : ?>
					<li><a href="<?php echo esc_url( $url_linkedin ); ?>" target="_blank"><i class="typcn typcn-social-linkedin"></i></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<!-- End author bio -->