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

                    <a class="home-link" href="<?php echo get_home_url(); ?>">
                        <svg class="icon home-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#home"></use>
                        </svg>
                        На главную</a>
                    <?php
                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="post-nav-prev">
                            <svg class="icon prev-icon">
                                <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                            </svg>
                            ' . esc_html__( 'Назад', 'universal-theme' ) . '</span>',
                            'next_text' => '<span class="post-nav-prev">
                            ' . esc_html__( 'Вперед', 'universal-theme' ) . '</span>
                            <svg class="icon next-icon">
                                <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                            </svg>',
                        )
                    );
                    ?>
                </div>
                <!-- /.post-header-nav -->

                <div class="header-post">
                <?php
                    if ( is_singular() ) :
                        the_title( '<h1 class="post-title">', '</h1>' );
                    else :
                        the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                    endif;?>

                    <svg class="icon bookmark-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#bookmark"></use>
                    </svg>
                </div>
                
                <p class="excerpt">
                    <?php echo mb_strimwidth(get_the_excerpt(), 0, 180, '...'); ?>
                </p>
            
                <div class="down-info">
                    <div class="date">
                        <svg class="icon time-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#clock"></use>
                        </svg>
                        <?php the_time( 'd F, h:m' ); ?>
                    </div>
                    <div class="likes">
                        <svg class="icon likes-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#heart"></use>
                            </svg>
                            <span class="likes-counter"><?php comments_number('0'); ?></span>
                    </div>
                    <div class="comments">
                        <svg class="icon comments-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                        </svg>
                        <span class="comments-counter"><?php comments_number('0'); ?></span>
                    </div>                
                </div>

                <div class="post-author">
                    <div class="post-author-info">
                    <?php $author_id = get_the_author_meta('ID'); ?>
                        <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="" class="post-author-avatar">
                            <span class="post-author-name"><?php the_author( ); ?></span>
                            <span class="post-author-rank">Должность</span>
                            <span class="post-author-posts">
                            <?php
                                plural_form(
                                    count_user_posts($author_id),
                                    /* варианты написания для количества 1, 2 и 5 */
                                    array('статья','статьи','статей')
                                );
                            ?>
                            </span>
                    </div>
                    <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="post-author-link">Страница автора</a>
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
            ?>
        </footer><!-- .post-footer -->

    </div>
    <!-- /.container -->

    
</article>