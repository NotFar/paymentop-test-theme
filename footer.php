<?php
/**
 * Footer
 */

?>

	<footer id="theme-footer" class="site-footer">
        <div class="flx container">
            <div class="site-logo">
                <?php the_custom_logo(); ?>
            </div>
            <?php if ( has_nav_menu( 'footer_nav_1' ) ) { ?>

                <nav class="footer-nav">
                    <?php
                        wp_nav_menu(
                            array(
                             'theme_location' => 'footer_nav_1',
                             'container_class' => '',
                             'container_id' => 'footer-nav-1-container',
                             'menu_class' => '',
                             'fallback_cb' => '',
                             'menu_id' => 'footer-nav-1',
                            )
                        );
                    ?>
                </nav>

            <?php } ?>

            <?php if ( has_nav_menu( 'footer_nav_2' ) ) { ?>

                <nav class="footer-nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_nav_2',
                            'container_class' => '',
                            'container_id' => 'footer-nav-2-container',
                            'menu_class' => '',
                            'fallback_cb' => '',
                            'menu_id' => 'footer-nav-2',
                        )
                    );
                    ?>
                </nav>

            <?php } ?>

            <?php if ( has_nav_menu( 'footer_nav_3' ) ) { ?>

                <nav class="footer-nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_nav_3',
                            'container_class' => '',
                            'container_id' => 'footer-nav-3-container',
                            'menu_class' => '',
                            'fallback_cb' => '',
                            'menu_id' => 'footer-nav-3',
                        )
                    );
                    ?>
                </nav>

            <?php } ?>

            <?php if ( has_nav_menu( 'footer_nav_4' ) ) { ?>

                <nav class="footer-nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_nav_4',
                            'container_class' => '',
                            'container_id' => 'footer-nav-4-container',
                            'menu_class' => '',
                            'fallback_cb' => '',
                            'menu_id' => 'footer-nav-4',
                        )
                    );
                    ?>
                </nav>

            <?php } ?>
        </div>
	</footer><!-- #theme-footer -->

<?php wp_footer(); ?>

</body>
</html>
