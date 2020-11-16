    <footer class="footer">
        <div class="container">

        <div class="footer-form-wrapper">
        <h3 class="footer-form-title">Подпишитесь на нашу рассылку</h3>
            <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="footer-form">
                <!-- Поле Email (обязательно) -->
                <input type="text" name="email" placeholder="Введите email" class="input footer-form-input" required /><br/>
                <!-- Токен списка -->
                <!-- Получить API ID на: https://app.getresponse.com/campaign_list.html -->
                <input type="hidden" name="campaign_token" value="BJbZT" />
                <!-- Страница благодарности (по желанию) -->
                <input type="hidden" name="thankyou_url" value="<?php echo home_url( 'thankyou' ); ?>"/>
                <!-- Добавить подписчика в цикл на определенный день (по желанию) -->
                <input type="hidden" name="start_day" value="0" />
                <!-- Кнопка подписаться -->
                <button type="submit">Подписаться</button>
            </form>
        </div>
        <!-- /.footer-form -->

        <?php
                if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
            return;
        }
        ?>

        <div class="footer-menu-bar">
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </div>
        <!-- /.footer-menu-bar -->
        <div class="footer-info">
            <?php
                    if( has_custom_logo() ){
                        echo '<a class="logo-link" href="'.get_home_url().'">'. 
                        '<img class="logo-image" src="'. get_theme_mod('custom_logo_2') .'"></a>';
                    } else {
                        echo '<a class="footer-logo-link" href="'.get_home_url().'">'. get_bloginfo('name') .'</a>';
                    }
            ?>

            <?php
                wp_nav_menu( [
                    'theme_location' => 'footer_menu',
                    'container'      =>  'nav',
                    'menu_class'     =>  'footer-nav',
                    'echo'           =>  true,
                ] );
            ?>
            <?php
                $instance = array(
                    'facebook'  =>  'https://fb.com',
                    'twitter'   =>  'https://twitter.com',
                    'youtube'   =>  'https://youtube.com',
                    'instagram' =>  'https://instagram.com',
                    'title'     =>  '',
                );
                $args = array(
                    'before_widget' => '<div class="footer-social">',
                    'after_widget'  => '</div>',
                );
                the_widget( 'Social_Widget', $instance, $args);
            ?>
        </div>
        <!-- /.footer-info -->
        <?php
                if ( ! is_active_sidebar( 'sidebar-footer-text' ) ) {
            return;
        }
        ?>
        <div class="footer-text-wrapper">
            <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
            <span class="footer-copyright">
                <?php echo date('Y'). ' &copy; ' . get_bloginfo('name'); ?>
            </span>
            <!-- /.footer-copyright -->
        </div>
        <!-- /.footer-text-wrapper -->
        </div>
        <!-- /.container -->
    </footer>
    <?php wp_footer(); ?>
</body>
</html>