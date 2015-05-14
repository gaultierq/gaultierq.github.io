<?php
/**
 * Template for displaying related posts.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<?php global $grateful_option; ?>

<?php if( $grateful_option['related_posts'] ) : ?>
	<?php
	// get the categories
	$categories = get_the_category();
	$cat_ids = array();
	foreach($categories as $category) $cat_ids[] = $category->term_id;

	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'orderby' => 'rand',
		'category__in' => $cat_ids,
		'post__not_in' => array( get_the_ID() ),
		'posts_per_page' => 3
	);

	$posts_related = new WP_Query();
	$posts_related->query($args);
	if ( $posts_related->have_posts() ) :
	?>

	<div id="related-posts">
		<div class="inner">
			<h3 class="widget-title"><?php _e('Related Posts', 'grateful'); ?></h3>
			<ul>
				<?php while( $posts_related->have_posts() ) : $posts_related->the_post(); ?>
					<li>
						<div class="thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php
							// Get featured image
							if ( has_post_thumbnail() ) {
								the_post_thumbnail('small-thumb');
							} else { 
								echo '<img src="http://placehold.it/215x125/&amp;text='. __('No Thumbnail', 'singkarak') .'" alt="" />';
							}
							?>
							</a>
						</div>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 8, '...'); ?></a>
						<div class="meta"> <?php echo date_i18n( 'M jS, Y', strtotime( get_the_date('Y-m-d'), false ) ); ?></div>
					</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>