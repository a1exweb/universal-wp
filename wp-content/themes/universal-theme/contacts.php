<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/

get_header();
?>
<section class="section-dark">
    <div class="container">
    <?php the_title('<h1 class="page-title">', '</h1>', true); ?>
    <div class="contacts-wrapper">
    <div class="left">
    <form action="function.php" class="contacts-form" method="POST">
        <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя" required>
        <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email" required>
        <textarea name="contact_question" class="textarea contacts-textarea" placeholder="Ваш вопрос" required></textarea>
        <button type="submit" class="button more">Отправить</button>
    </form>
    <!-- <?php echo do_shortcode( '[contact-form-7 id="377" title="Контактная форма"]') ?> -->
    <p>Через форму обратной связи</p>
    <?php the_content(); ?>
    </div>
    <!-- /.left -->
    <div class="right">
    
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