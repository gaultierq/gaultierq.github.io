<?php
/**
 * The template for displaying search form.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0
 */
?>

<div class="search-box">
    <form id="search-form" method="get" action="<?php echo home_url(); ?>">
        <input id="search-field" type="text" name="s" value="<?php the_search_query(); ?>" />
		<a class="submit" href="javascript:void(0);" onclick="jQuery('#search-form').submit();"><i class="typcn typcn-chevron-right"></i></a>
    </form>
 </div>