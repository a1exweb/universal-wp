<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/

get_header();
?>
<section class="section-dark">
    <div class="container">
    <!-- <?php the_title('<h1 class="page-title">', '</h1>', true); ?> -->
        <h1 class="page-title"><?php the_field('contacts_title'); ?></h1>
    <div class="contacts-wrapper">
    <div class="left">
    <!-- <form action="function.php" class="contacts-form" method="POST">
        <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя" required>
        <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email" required>
        <textarea name="contact_question" class="textarea contacts-textarea" placeholder="Ваш вопрос" required></textarea>
        <button type="submit" class="button more">Отправить</button>
    </form> -->
    <!-- <?php echo do_shortcode( '[contact-form-7 id="377" title="Контактная форма"]') ?> -->
    <h2 class="contacts-title">Через форму обратной связи</h2>
    <?php the_content(); ?>
    </div>
    <!-- /.left -->
    <div class="right">
        <h2 class="contacts-title">Или по этим контактам</h2>
        <?php
            $email = get_post_meta( get_the_ID(), 'email', true );
            if ($email) { echo '<a href="mailto:'. $email . '">' . $email . '</a>'; }

            $address = get_post_meta( get_the_ID(), 'address', true ); 
            if ($address) { echo '<address>' . $address . '</address>'; }

            // $phone = get_post_meta( get_the_ID(), 'phone', true );
            // if ($phone) { echo '<a href="tel:'. $phone . '">' . $phone . '</a>'; }
            echo '<a href="tel:' . get_field('phone') . '">'. get_field('phone') . '</a>';
        ?>

        <!-- <?php

            echo '<address>'. get_field('address') . '</address>';
        ?> -->
    </div>
    <!-- /.right -->
    </div>
    <!-- /.contacts-wrapper -->
    </div>
    <!-- /.container -->
</section>
<!-- /.section-dark -->
<?php
get_footer();
?>