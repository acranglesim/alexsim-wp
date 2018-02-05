<?php
/**
 * The template used for displaying page content in contactus.php
 *
 * @package plum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('contact-us'); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content col-md-12 col-sm-12">
        <?php the_content(); ?>

        <?php if(get_theme_mod('plum_form_shortcode_set') != ''): ?>
            <div class="p-form col-md-6 col-sm-6">
                <?php echo do_shortcode(get_theme_mod('plum_form_shortcode_set')); ?>
            </div>
        <?php endif; ?>

        <?php if(get_theme_mod('plum_select_contact_page') != ''): ?>
        <div class="about-address col-md-6 col-sm-6">
            <div class="address">
                <?php
                $args = array(
                    'post_type' => 'page',
                    'posts_per_page' => 1,
                    'post__in' => array(get_theme_mod('plum_select_contact_page')),
                );

                $loop = new WP_Query( $args );
                while( $loop -> have_posts() ):
                    $loop->the_post(); ?>
                    <h3 class="contact-title">
                        <?php the_title(); ?>
                    </h3>
                    <p class="contact-data">
                        <?php the_content(); ?>
                    </p>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>

            <div class="about">
                <?php
                $args = array(
                'post_type' => 'page',
                'posts_per_page' => 1,
                'post__in' => array(get_theme_mod('plum_static_selectpage')),
                );

                $loop = new WP_Query( $args );
                while( $loop -> have_posts() ):
                $loop->the_post(); ?>
                <div class="h-content">
                    <h3 class="title">
                        <?php the_title(); ?>
                    </h3>
                    <div class="excerpt">
                        <?php echo substr(get_the_content(), 0, 300)."..."; ?>
                    </div>

                    <?php if(get_theme_mod('plum_static_button') != ''): ?>
                        <a href="<?php the_permalink(); ?>" class="more-button">
                            <?php echo get_theme_mod('plum_static_button'); ?>
                        </a>
                    <?php endif;?>
                </div>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'plum' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <div class="site-loc col-md-12 cl-sm-12">
        <?php if(get_theme_mod('plum_map_set') != ''): ?>
            <div class="map-img col-md-6 col-sm-6">
                <a href="<?php the_permalink(); ?>"><img src="<?php echo get_theme_mod('plum_map_set'); ?> " /></a>
            </div>
        <?php endif; ?>

        <div class="site-info col-md-6 col-sm-6">
            <h1 cass="site-title"><?php bloginfo( 'name' ); ?></h1>
            <h3 class="site-desc"><?php bloginfo( 'description' ); ?></h3>
            <div class="social-i">
                <?php get_template_part('modules/social/social', 'fa'); ?>
            </div>
            <div class="button">
                <a href="<?php get_theme_mod('plum_button_url'); ?>"><?php echo get_theme_mod('plum_button_text'); ?></a>
            </div>
        </div>

    </div>

    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'plum' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
