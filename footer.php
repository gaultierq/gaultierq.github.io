<?php
/**
 * The template for displaying footer section.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

global $grateful_option;
?>
		
		<div class="clearfix"></div>
		</div>
	</section>
</section>

<div class="bg-area clearfix">
	<div class="container">
		<div class="bg-left"><div class="before"></div>
		<div class="after"></div></div>
	</div>
</div>

<?php
// Load tracking code from theme options
if( isset($grateful_option['tracking_code']) ) {
    echo $grateful_option['tracking_code'];
}

// Load custom CSS from theme options
if( isset( $grateful_option['custom_css'] ) ) {
    echo '<style type="text/css">';
    echo $grateful_option['custom_css'];
    echo '</style>';
}
?>

<a id="scroll-top" href="#top" style="display: block;"><span class="typcn typcn-arrow-up"></span></a>

<?php wp_footer(); ?>
</body>
</html>