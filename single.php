<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Grace_Mag
 */

get_header();

$background_image_url = grace_mag_mod( 'common_page_background_image', '' );
?>

<div class="inner-banner<?php grace_mag_has_image_class( $background_image_url ); ?>"<?php grace_mag_has_image_url( $background_image_url ); ?>></div>

<div class="sigle-post">
    <?php grace_mag_breadcrumb(); ?>
    <div class="container">
        <div class="single-post-layout1">
            <div class="row">
                <?php grace_mag_display_sidebar( 'left' ); ?>
                <div class="<?php grace_mag_main_container_class(); ?>">
                    <?php
                    if( have_posts() ) :

                        while( have_posts() ) :
                            the_post();

                            get_template_part( 'template-parts/content', get_post_type() );

                        endwhile;

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;
                    ?>
                </div><!--col-lg-8-->
                <?php grace_mag_display_sidebar( 'right' ); ?>
            </div><!--single-post-layout1-->
        </div><!--container-->
    </div> <!--not found page-->
</div>

<?php
get_footer();
