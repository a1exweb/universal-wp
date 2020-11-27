<?php get_header(); ?>
<div class="container">
    <h1 class="category-title"><?php single_cat_title(); ?></h1>
        <div class="post-list">
        <?php while ( have_posts() ){ the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="post-card">
                    <img src="<?php if (has_post_thumbnail( )) { 
                        echo get_the_post_thumbnail_url(null, 'thumb' ); 
                    } else {
                        echo get_template_directory_uri().'/assets/images/img-default.jpg';
                    } ?>" alt="" class="post-card-thumbnail">
                <div class="post-card-content">
                <h2 class="post-card-title"><?php trim_title(20); ?></h2>
                <p class="post-card-excerpt">
                    <?php echo mb_strimwidth(get_the_excerpt(), 0, 85, '...'); ?>
                </p>
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
                <!-- /.post-card-content -->
            </a>
        <?php } ?>
        <?php if ( ! have_posts() ){ ?>
            Записей нет.
        <?php } ?>
        </div>
        <!-- /.posts-list -->
    
</div>
<!-- /.container -->
<?php get_footer(); ?>