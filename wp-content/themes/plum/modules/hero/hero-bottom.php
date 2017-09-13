<?php if ( get_theme_mod('plum_hero_eta_enable') && is_front_page() && !is_home() ) : ?>
    <div id="hero2" class="hero-content">
        <div class="layer"></div>
        <div class="container hero-container">
            <?php
            $args = array(
                'post_type' => 'page',
                'posts_per_page' => 1,
                'post__in' => array(get_theme_mod('plum_hero2_selectpage')),
            );

            $loop = new WP_Query( $args );
            while( $loop -> have_posts() ):
                $loop->the_post();

                $class = has_post_thumbnail() ?  'col-md-8 col-sm-8' : 'col-md-12 centered' ; ?>
                <div class="<?php echo $class; ?> h-content">
                    <h1 class="title">
                        <?php the_title(); ?>
                    </h1>
                    <?php if(get_theme_mod('plum_hero2_full_content', true)) : ?>
                        <div class="excerpt">
                            <?php the_content(); ?>
                        </div>
                    <?php else : ?>
                        <div class="excerpt">
                            <?php echo substr(get_the_content(), 0, 300)."..."; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(get_theme_mod('plum_hero2_button') != ''): ?>
                        <a href="" class="more-button">
                            <?php echo get_theme_mod('plum_hero2_button'); ?>
                        </a>
                    <?php endif;?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                <div class="col-md-4 col-sm-4 f-image">
                    <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url(); ?>"></a>
                </div>
            <?php endif; ?>
                <?php
            endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>
