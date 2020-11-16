<?php get_header(); ?>
<div class="container">
    <h1 class="search-title">Результаты поиска по запросу:</h1>
    <section class="articles-news">
        <div class="leftside">
                <div class="articles-wrapper">
                <?php
            if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div class="article">
                        
                        
                        <div class="image">
                            <?php 
                            if (has_post_thumbnail( )) {
                                the_post_thumbnail( );
                            } else {
                                echo '<img src="'.get_template_directory_uri().'/assets/images/img-default.jpg" alt="">';
                            }
                            ?>
                        </div>
                        <div class="content">
                            <?php 
                                foreach (get_the_category() as $key => $category) {
                                    printf(
                                        '<div class="header-post"><span class="category-name %s">%s</span></div>',
                                        esc_html($category -> slug),
                                        esc_html($category -> name)
                                    );
                                }
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <h2 class="title">
                                    <?php trim_title(100); ?>
                                </h2>
                            </a>
                            <p class="text">
                                <?php echo mb_strimwidth(get_the_excerpt(), 0, 180, '...'); ?>
                            </p>
                            <div class="down-info">
                                <span class="date"><?php the_time( 'd F' ); ?></span>
                                <div class="comments">
                                <svg class="icon comments-icon">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                                </svg>
                                    <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                                </div>
                                <div class="likes">
                                <svg class="icon likes-icon">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#heart"></use>
                                </svg>
                                    <span class="likes-counter"><?php comments_number('0', '1', '%'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                // Постов не найдено
                <?php endif; ?>
                </div>

                <?php 
                    $args = array(
                        'prev_text'    => __('<svg class="icon prev-icon">
                        <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                    </svg><span>Назад</span>'),
                        'next_text'    => __('<span>Вперед</span>
                        
                        <svg class="icon prev-icon">
                        <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                    </svg>'),
                    );
                    the_posts_pagination($args);
                ?>
        </div>
        <div class="rightside">
            <?php get_sidebar('home-bottom'); ?>
        </div>
</section>

</div>
<!-- /.container -->
<?php get_footer(); ?>