<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package awps
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site" <?php echo !is_customize_preview() ?: 'style="padding: 0 40px;"'; ?>>

		<header id="masthead" class="site-header" role="banner">

			<?php
			if (is_customize_preview()) {
				echo '<div id="awps-header-control"></div>';
			}
			?>

			<div class="container">

				<nav id="site-navigation" class="main-navigation navbar navbar-expand-lg" role="navigation">
					<div class="collapse navbar-collapse">
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="navbar-brand">
							<?php bloginfo('name'); ?>
						</a>
						<?php
						if (has_nav_menu('primary')) :
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
									'menu_class'     => 'navbar-nav ml-auto',
									'walker'         => new Awps\Core\WalkerNav(),
								)
							);
						endif;
						?>
					</div>
				</nav>

			</div><!-- .container -->

		</header><!-- #masthead -->

		<div id="content" class="site-content">