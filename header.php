<?php
/**
 * Header theme
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <header class="main-header">
        <div class="flx container">
            <div class="site-logo">
                <?php the_custom_logo(); ?>
            </div>
            <nav class="header-nav">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'header_nav',
                        'container_class' => '',
                        'container_id' => 'header-nav-container',
                        'menu_class' => '',
                        'fallback_cb' => '',
                        'menu_id' => 'header-nav-menu',
                    )
                );
                ?>
            </nav>
        </div>
    </header>

