<?php
/**
 * The template for displaying posts in 404 page.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>
<?php global $grateful_option; ?>

<!-- Start: 404 -->
<article class="hentry">
	<div class="thumbnail">
		<img class="wp-post-image" src="<?php echo $grateful_option['404_image']['url']; ?>" alt="" />
	</div>

	<div class="post-inner">
		<div class="post-title">
			<h1><?php _e('Page Not Found', 'grateful'); ?></h1>
		</div>

		<div class="post-content">
			<p><?php _e('The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'grateful');?></p>
		</div>
	</div>
</article>
<!-- End: 404 -->