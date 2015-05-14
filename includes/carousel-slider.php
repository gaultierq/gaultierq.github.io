<?php
/**
 * Template for displaying post carousel slider.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<?php global $grateful_option; ?>

<!-- Start carousel slider -->
<div id="main-carousel-slider" class="carousel">
	<ul class="slides">
		<?php
		$show_per_page = $grateful_option['carousel_slider_post_per_page'];
		$args = array(
		  	'post_type' => 'post',
			'post_status' => 'publish',
			'orderby' => 'rand',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $show_per_page
		);
		$the_loop = new WP_Query($args);
		if ($the_loop->have_posts()) : while ($the_loop->have_posts()) : $the_loop->the_post();
		?>
			<li>
				<article class="post overlay-post">
					<div class="thumbnail">
						<?php
						// Get featured image
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('carousel-image');
						} else {
							echo '<img src="http://placehold.it/290x200/333333/&text=&nbsp;" alt=""/>';
						}
						?>
					</div>
					<div class="overlay">
						<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 3, '...'); ?></a></h3>

						<div class='meta'>
							<?php if( ($grateful_option['post_carousel_slider']) ) : ?>
								<span class="category"><i class="typcn typcn-bookmark"></i> <?php the_category(', ') ?></span>
							<?php endif; ?>
						</div>
					</div>
				</article>
			</li>
			<?php endwhile; ?>
			<?php else : ?>
				
			<?php endif; ?>
	</ul>
</div>
<!-- End carousel slider -->