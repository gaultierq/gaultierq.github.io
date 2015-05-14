<?php
/**
 * The template for displaying header part.
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

global $grateful_option;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo ( $grateful_option['favicon']['url'] ? esc_url( $grateful_option['favicon']['url'] ) : get_template_directory_uri().'/images/favicon.png' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<section id="main-wrapper" >
		<section class="container">
			<a class="menu-trigger" href="#leftcontent"></a>