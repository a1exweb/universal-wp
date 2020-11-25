<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="post-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
        <?php
            if (has_post_thumbnail( )) {
                echo get_the_post_thumbnail_url();
            } else {
                echo get_template_directory_uri().'/assets/images/img-default.jpg"';
            }
        ?>) no-repeat center/cover;">
		<div class="container">        
            <div class="post-header-wrapper">
                <div class="post-header-nav">
                    <?php
                        foreach (get_the_category() as $key => $category) {
                            printf(
                                '<a rel="category tag" href="%s" class="category-link %s">%s</a>',
                                esc_url(get_category_link($category)),
                                esc_html($category -> slug),
                                esc_html($category -> name)
                            );
                        }
                    ?>
                </div>
                <div class="video">
                    <?php
                    $video_link = get_field('video_link');
                    $tmp_youtube = explode('youtu.be/', get_field('video_link'));
                    $tmp_youtube_watch = explode('youtube.com/watch?v=', get_field('video_link'));
                    $tmp_vimeo = explode('/', get_field('video_link'));
                    if (strpos($video_link, 'youtu.be') !== false) // именно через жесткое сравнение
                    {
                        echo '<iframe width="100%" height="515" src="https://www.youtube.com/embed/' . end ($tmp_youtube) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
                    if (strpos($video_link, 'youtube.com/watch?') !== false) // именно через жесткое сравнение
                    {
                        echo '<iframe width="100%" height="515" src="https://www.youtube.com/embed/' . end ($tmp_youtube_watch ) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }

                    if (strpos($video_link, 'vimeo.com') !== false) // именно через жесткое сравнение
                    {
                        echo '<iframe src="https://player.vimeo.com/video/' . end ($tmp_vimeo) . '" width="100%" height="515" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                    }
                    ?>
                </div>
                <!-- /.post-header-nav -->

                <div class="header-post">
                <?php
                    if ( is_singular() ) :
                        // the_title( '<h1 class="post-title">', '</h1>' );
                        echo '<h1 class="post-title">';
                        trim_title(60);
                        echo '</h1>';
                    else :
                        // the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                        echo '<h2 class="post-title"><a href="'. esc_url( get_permalink() ) . '" rel="bookmark">';
                        echo trim_title(60);
                        echo '</a></h2>';
                    endif;?>

                </div>
                            
                <div class="down-info">
                    <div class="date">
                        <svg class="icon time-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#clock"></use>
                        </svg>
                        <?php the_time( 'd F, h:m' ); ?>
                    </div>
                </div>

                
            </div>
            <!-- /.post-header-wrapper -->
        </div>
        <!-- /.container -->
	</header><!-- .post-header -->

    <div class="container">
        <div class="post-content">
            <?php
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-example' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-example' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .post-content -->

        <footer class="post-footer">
            <?php
                $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-example' ) );
                if ( $tags_list ) {
                    /* translators: 1: list of tags. */
                    printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
                // Share social
                meks_ess_share();
                
            ?>
        </footer><!-- .post-footer -->

    </div>
    <!-- /.container -->
    
</article>