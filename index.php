<?php
/**
 * Main template
 */

get_header();
?>
<section>
    <div class="container">
        <?php
        if ( have_posts() ) :

            /* Start the Loop */
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>
    </div>
</section>
<?php
get_footer();
