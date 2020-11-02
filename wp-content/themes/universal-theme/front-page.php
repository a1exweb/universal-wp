<?php get_header(); ?>
<main class="front-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">
            <?php
                global $post;

                $myposts = get_posts([ 
                    'numberposts' => 1,
                    'category_name' => 'javascript',
                ]);

                if( $myposts ){
                    foreach( $myposts as $post ){
                setup_postdata( $post );
            ?>
                <img class="post-thumb" src="<?php
                    if (has_post_thumbnail( )) {
                        echo get_the_post_thumbnail_url();
                    } else {
                        echo get_template_directory_uri().'/assets/images/img-default.jpg"';
                    }
                ?>" alt="">
                <div class="hero-post-content">
                    <?php $author_id = get_the_author_meta('ID'); ?>
                    <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="author">
                        <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="" class="avatar">
                        <div class="author-bio">
                            <span class="author-name"><?php the_author( ); ?></span>
                            <span class="author-rank">Должность</span>
                        </div>
                    </a>

                    <div class="post-text">
                        <span class="hero-post-categories">
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
                        </span>
                        <h2 class="post-title"><?php trim_title(60); ?></h2>
                        <a href="<?php echo get_permalink( ); ?>" class="more">Читать далее</a>
                    </div>
                </div>
                <?php
                }
            } else {
                // Постов не найдено
            ?>
                <p>Постов не найдено</p>
            <?php
                }

            wp_reset_postdata(); // Сбрасываем $post
            ?>
            </div>
            <div class="right">
                <h3 class="recommend">Рекомендуем</h3>
                <ul class="posts-list">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 5,
                        // 'offset' => 1,
                        'category_name' => 'javascript, css, html, web-design',
                        'tag' => 'recommend',
                    ]);

                    if( $myposts ){
                        foreach( $myposts as $post ){
                    setup_postdata( $post );
                ?>
                    <li class="post">
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
                        <a class="post-permalink" href="<?php echo get_the_permalink( ); ?>">
                            <h4 class="post-title"><?php trim_title(60); ?></h4>
                        </a>
                    </li>
                    <?php
                        }
                    } else {
                        // Постов не найдено
                    ?>
                        <p>Постов не найдено</p>
                    <?php
                        }
                    wp_reset_postdata(); // Сбрасываем $post
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.hero -->
    </div>
</main>

<div class="container">
    <ul class="article-list">
        <?php
            global $post;

            $myposts = get_posts([ 
                'numberposts' => 4,
                'category_name' => 'articles',
                'tag' => 'novelty',
            ]);

            if( $myposts ){
                foreach( $myposts as $post ){
            setup_postdata( $post );
        ?>
            <li class="article-item">
                <a class="article-permalink" href="<?php echo get_the_permalink( ); ?>">
                    <h4 class="article-title"><?php trim_title(50); ?></h4>
                </a>
                <img class="article-thumb" src="<?php
                    if (has_post_thumbnail( )) {
                        echo get_the_post_thumbnail_url(null, 'thumbnail');
                    } else {
                        echo get_template_directory_uri().'/assets/images/img-default.jpg"';
                    }
                ?>" alt="">
            </li>
        <?php
            }
        } else {
            // Постов не найдено
        ?>
            <p>Постов не найдено</p>
        <?php
            }
        wp_reset_postdata(); // Сбрасываем $post
        ?>
    </ul>
    <!-- ./article-list -->
    <div class="main-grid">
        <ul class="article-grid">
            <?php		
                global $post;

                $query = new WP_Query( [
                    'posts_per_page' => 7,
                    'tag' => 'popular',
                    'category__not_in' => 31,
                ] );

                if ( $query->have_posts() ) {
                    $cnt = 0;
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $cnt++;
                        switch ($cnt) {
                            case '1':
                            ?>
                                <li class="article-grid-item">
                                    <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                        <span class="category-name"><?php 
                                            $category = get_the_category(); 
                                            echo $category[0]->name;
                                        ?></span>
                                        <h4 class="article-grid-title"><?php trim_title(50); ?></h4>
                                        <p class="article-grid-excerpt">
                                            <?php echo get_the_excerpt(  ); ?>
                                        </p>
                                        <div class="article-grid-info">
                                            <div class="author">
                                                <?php $author_id = get_the_author_meta('ID'); ?>
                                                <img src="<?php echo get_avatar_url($author_id); ?>" alt="Аватарка автора" class="author-avatar">
                                                <span class="author-name"> <strong><?php the_author(); ?></strong>: <?php the_author_meta('description'); ?></span>
                                            </div>
                                            <div class="comments">
                                                <svg class="icon comments-icon">
                                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                                                </svg>
                                                <span class="comments-counter"><?php comments_number('0'); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            break;
                        
                        case '2': ?>
                            <li class="article-grid-item">
                                <img class="article-grid-thumbnail" src="<?php
                                    if (has_post_thumbnail( )) {
                                        echo get_the_post_thumbnail_url();
                                    } else {
                                        echo get_template_directory_uri().'/assets/images/img-default.jpg"';
                                    }
                                ?>" alt="">
                                    <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                        <span class="tag">
                                            <?php
                                                $posttags = get_the_tags();
                                                if ($posttags) {
                                                    echo $posttags[0]->name.'';
                                                }
                                            ?>
                                        </span>
                                        <span class="category-name"><?php 
                                            $category = get_the_category(); 
                                            echo $category[0]->name;
                                        ?></span>
                                            <h4 class="article-grid-title"><?php trim_title(50); ?></h4>
                                            <div class="article-grid-info">
                                                <div class="author">
                                                    <?php $author_id = get_the_author_meta('ID'); ?>
                                                    <img src="<?php echo get_avatar_url($author_id); ?>" alt="Аватарка автора" class="author-avatar">
                                                    <div class="author-info">
                                                        <span class="author-name"> <strong><?php the_author(); ?></strong></span>
                                                        <span class="date"><?php the_time('j F'); ?></span>
                                                    <div class="comments">
                                                        <svg class="icon comments-icon">
                                                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                                                        </svg>
                                                        <span class="comments-counter"><?php comments_number('0'); ?></span>
                                                    </div>
                                                    <div class="likes">
                                                        <svg class="icon comments-icon">
                                                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#heart"></use>
                                                        </svg>
                                                        <span class="likes-counter"><?php comments_number('0'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./article-grid-info -->
                                    </a>
                                </li>
                            <?php
                            break;

                            case '3': ?>
                                <li class="article-grid-item">
                                    <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                        <img class="article-grid-thumbnail" src="<?php
                                        if (has_post_thumbnail( )) {
                                            echo get_the_post_thumbnail_url();
                                        } else {
                                            echo get_template_directory_uri().'/assets/images/img-default.jpg"';
                                        }
                                    ?>" alt="">
                                        <h4 class="article-grid-title"><?php trim_title(50); ?></h4>
                                    </a>
                                </li>
                                <?php
                                break;
                            default: ?>
                                <li class="article-grid-item article-grid-item-default">
                                    <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                        <h4 class="article-grid-title"><?php trim_title(50); ?></h4>
                                        <p class="article-grid-excerpt">
                                            <?php echo mb_strimwidth(get_the_excerpt(), 0, 85, '...'); ?>
                                        </p>
                                        <span class="date"><?php the_time('j F'); ?></span>
                                    </a>
                                </li>
                                <?php
                                break;
                        }
                        ?>
                        <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                        <?php 
                    }
                } else {
                    // Постов не найдено
                }

                wp_reset_postdata(); // Сбрасываем $post
            ?>
        </ul>
    <?php get_sidebar('home-top'); ?>
    </div>
</div>
<!-- /.container -->

<?php		
global $post;

$query = new WP_Query( [
    'posts_per_page' => 1,
    'category_name' => 'investigation',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
        <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url(<?php
            if (has_post_thumbnail( )) {
                echo get_the_post_thumbnail_url();
            } else {
                echo get_template_directory_uri().'/assets/images/img-default.jpg"';
            }
            ?>) no-repeat center;">
            <div class="container">
                <h2 class="investigation-title"><?php the_title(); ?></h2>
                <a href="<?php echo get_permalink( ); ?>" class="more">Читать статью</a>
            </div>
        </section>
        <!-- /.investigation -->
		<?php 
	}
} else {
	// Постов не найдено
}

wp_reset_postdata(); // Сбрасываем $post
?>
<section class="articles-news">
    <div class="container">
        <div class="leftside">
        <?php
            global $post;

            $myposts = get_posts([ 
                'numberposts' => 6,
            ]);

            if( $myposts ){
                foreach( $myposts as $post ){
                    setup_postdata( $post );
                    ?>
                    <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                    <a href="<?php the_permalink(); ?>" class="article">
                        <svg class="icon bookmark-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#bookmark"></use>
                        </svg>
                        
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
                                        '<span class="category-name %s">%s</span>',
                                        esc_html($category -> slug),
                                        esc_html($category -> name)
                                    );
                                }
                            ?>
                                <h2 class="title">
                                    <?php trim_title(100); ?>
                                </h2>
                            <p class="text">
                                <?php echo mb_strimwidth(get_the_excerpt(), 0, 180, '...'); ?>
                            </p>
                            <div class="down-info">
                                <span class="date"><?php the_time( 'd F' ); ?></span>
                                <div class="comments">
                                <svg class="icon comments-icon">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                                </svg>
                                    <span class="comments-counter"><?php comments_number('0'); ?></span>
                                </div>
                                <div class="likes">
                                <svg class="icon likes-icon">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#heart"></use>
                                </svg>
                                    <span class="likes-counter"><?php comments_number('0'); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php 
                }
            } else {
                // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </div>
        <div class="rightside">
            <?php get_sidebar('home-bottom'); ?>
        </div>
    </div>
</section>
<section class="special">
    <div class="container">
        <div class="special-grid">
        <?php		
            global $post;

            $query = new WP_Query( [
                'posts_per_page' => 1,
                'category_name' => 'photo-report',
            ] );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>
                    <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                    <div class="photo-report">
                        <!-- Slider main container -->
                        <div class="swiper-container photo-report-slider">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php
                                    $images = get_attached_media( 'image' );
                                    foreach ($images as $image) {
                                        echo '<div class="swiper-slide"><img src="';
                                        print_r($image -> guid);
                                        echo '"></div>';
                                    }
                                ?>
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="photo-report-content">
                        <?php 
                            foreach (get_the_category() as $key => $category) {
                                printf(
                                    '<a href="%s" class="category-link">%s</a>',
                                    esc_url( get_category_link( $category ) ),
                                    esc_html($category -> name)
                                );
                            }
                        ?>
                        <?php $author_id = get_the_author_meta('ID'); ?>
                            <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="author">
                                <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="" class="author-avatar">
                                <div class="author-bio">
                                    <span class="author-name"><?php the_author( ); ?></span>
                                    <span class="author-rank">Должность</span>
                                </div>
                            </a>
                            <h3 class="photo-report-title"><?php trim_title(60); ?></h3>
                            <a href="<?php echo get_the_permalink(); ?>" class="button photo-report-button">
                                <svg class="icon photo-report-icon">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#images"></use>
                                </svg>
                                Смотреть фото
                                <span class="photo-report-counter"><?php echo count($images); ?></span>
                            </a>
                        </div>

                    </div>
                    <!-- /.photo-report -->
                    <?php 
                }
            } else {
                // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
            ?>
            
            <div class="other">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 1,
                        'category_name' => 'career',
                    ]);

                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>
                            <div class="other-post-main">
                                <div class="content">
                                    <span class="category-name"><?php
                                            $category = get_the_category(); 
                                            echo $category[0]->name;
                                        ?></span>
                                        <h2 class="title">
                                            <?php echo trim_title(50); ?>
                                        </h2>
                                        <div class="text">
                                            <?php echo mb_strimwidth(get_the_excerpt(), 0, 85, '...'); ?>
                                        </div>
                                        <a href="<?php echo get_permalink( ); ?>" class="more">Читать далее</a>
                                </div>
                            </div>
                            <?php 
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post

                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 2,
                    ]);
                    echo '<div class="other-posts">';
                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>
                            <a href="<?php echo the_permalink(); ?>" class="other-post">
                                <h2 class="title">
                                    <?php echo trim_title(20); ?>
                                </h2>
                                <p class="text">
                                    <?php echo mb_strimwidth(get_the_excerpt(), 0, 85, '...'); ?>
                                </p>
                                <span class="date">
                                    <?php the_time('d F'); ?>
                                </span>
                            </a>
                            <?php 
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                    echo '</div>';
                ?>
            </div>
            <!-- /.other -->
        </div>
    </div>
</section>
<!-- /.special -->

<?php get_footer();