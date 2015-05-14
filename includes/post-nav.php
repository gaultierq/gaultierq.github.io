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
<?php if( $grateful_option['post_nav'] ) : ?>
	<?php
	$prevPost = get_previous_post(true);
	$nextPost = get_next_post(true);
	?>

	<div id="post-nav">
	    <?php $prevPost = get_previous_post(true);
	        if($prevPost) {
	            $args = array(
	                'posts_per_page' => 1,
	                'include' => $prevPost->ID
	            );
	            $prevPost = get_posts($args);
	            foreach ($prevPost as $post) {
	                setup_postdata($post);
	    ?>
	        <div class="post-previous">
	            <span class="title"><?php _e('Previous Post', 'grateful'); ?></span>
	            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 7, '...'); ?></a></h3>
	        </div>
	    <?php
	                wp_reset_postdata();
	            } //end foreach
	        } // end if
	         
	        $nextPost = get_next_post(true);
	        if($nextPost) {
	            $args = array(
	                'posts_per_page' => 1,
	                'include' => $nextPost->ID
	            );
	            $nextPost = get_posts($args);
	            foreach ($nextPost as $post) {
	                setup_postdata($post);
	    ?>
	        <div class="post-next">
	            <span class="title"><?php _e('Next Post', 'grateful'); ?></span>
	            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 7, '...'); ?></a></h3>
	        </div>
	    <?php
	                wp_reset_postdata();
	            } //end foreach
	        } // end if
	    ?>
	</div>
<?php endif; ?>