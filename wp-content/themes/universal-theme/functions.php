<?php
// Add advanced features
if ( ! function_exists( 'universal_theme_setup' ) ) :
    function universal_theme_setup() {
        // Add tag title
        add_theme_support( 'title-tag' );

        // Add thumbnails
        add_theme_support( 'post-thumbnails', array('post') );

        // Add custom logo
        // add_theme_support( 'custom-logo', [
        //     'width'       => 163,
        //     'flex-height' => true,
        //     'header-text' => 'Universal',
        //     'unlink-homepage-logo' => false,
		// ] );
		
		add_action( 'customize_register', 'custom_logo_uploader' );
		function custom_logo_uploader($wp_customize) {
		
			$wp_customize->add_section( 'upload_custom_logo', array(
				'title'          => 'Логотип',
				'description'    => 'Отображение собственного логотипа?',
				'priority'       => 25,
			) );
		
			$wp_customize->add_setting( 'custom_logo', array(
				'default'        => '',
			) );
		
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo', array(
				'label'   => 'Пользовательский логотип',
				'section' => 'upload_custom_logo',
				'settings'   => 'custom_logo',
			) ) );
		
			$wp_customize->add_setting( 'custom_logo_2', array(
				'default'        => '',
			) );
		
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo_2', array(
				'label'   => 'Пользовательский логотип',
				'section' => 'upload_custom_logo', // put the name of whatever section you want to add your settings
				'settings'   => 'custom_logo_2',
			) ) );
		}

        // Registration menu
        register_nav_menus( [
            'header_menu' => 'Меню в шапке',
            'footer_menu' => 'Меню в подвале'
		] );
		
		add_action( 'init', 'register_post_types' );
		function register_post_types(){
			register_post_type( 'lesson', [
				'label'  => null,
				'labels' => [
					'name'               => 'Уроки', // основное название для типа записи
					'singular_name'      => 'Урок', // название для одной записи этого типа
					'add_new'            => 'Добавить урок', // для добавления новой записи
					'add_new_item'       => 'Добавление урока', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Редактирование урока', // для редактирования типа записи
					'new_item'           => 'Новый урок', // текст новой записи
					'view_item'          => 'Смотреть урок', // для просмотра записи этого типа.
					'search_items'       => 'Искать уроки', // для поиска по этим типам записи
					'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
					'parent_item_colon'  => '', // для родителей (у древовидных типов)
					'menu_name'          => 'Уроки', // название меню
				],
				'description'         => 'Раздел с видеоуроками',
				'public'              => true,
				// 'publicly_queryable'  => null, // зависит от public
				// 'exclude_from_search' => null, // зависит от public
				// 'show_ui'             => null, // зависит от public
				// 'show_in_nav_menus'   => null, // зависит от public
				'show_in_menu'        => true, // показывать ли в меню адмнки
				// 'show_in_admin_bar'   => null, // зависит от show_in_menu
				'show_in_rest'        => true, // добавить в REST API. C WP 4.7
				'rest_base'           => null, // $post_type. C WP 4.7
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-welcome-learn-more',
				'capability_type'   => 'post',
				//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
				//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
				'hierarchical'        => false,
				'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
				'taxonomies'          => [],
				'has_archive'         => true,
				'rewrite'             => true,
				'query_var'           => true,
			] );
		}

		// хук, через который подключается функция
		// регистрирующая новые таксономии (create_lesson_taxonomies)
		add_action( 'init', 'create_lesson_taxonomies' );

		// функция, создающая 2 новые таксономии "genres" и "writers" для постов типа "book"
		function create_lesson_taxonomies(){

			// Добавляем древовидную таксономию 'genre' (как категории)
			register_taxonomy('genre', array('lesson'), array(
				'hierarchical'  => true,
				'labels'        => array(
					'name'              => _x( 'Genres', 'taxonomy general name' ),
					'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
					'search_items'      =>  __( 'Search Genres' ),
					'all_items'         => __( 'All Genres' ),
					'parent_item'       => __( 'Parent Genre' ),
					'parent_item_colon' => __( 'Parent Genre:' ),
					'edit_item'         => __( 'Edit Genre' ),
					'update_item'       => __( 'Update Genre' ),
					'add_new_item'      => __( 'Add New Genre' ),
					'new_item_name'     => __( 'New Genre Name' ),
					'menu_name'         => __( 'Genre' ),
				),
				'show_ui'       => true,
				'query_var'     => true,
				//'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
			));

			// Добавляем НЕ древовидную таксономию 'writer' (как метки)
			register_taxonomy('writer', 'lesson',array(
				'hierarchical'  => false,
				'labels'        => array(
					'name'                        => _x( 'Teachers', 'taxonomy general name' ),
					'singular_name'               => _x( 'Teacher', 'taxonomy singular name' ),
					'search_items'                =>  __( 'Search Teachers' ),
					'popular_items'               => __( 'Popular Teachers' ),
					'all_items'                   => __( 'All Teachers' ),
					'parent_item'                 => null,
					'parent_item_colon'           => null,
					'edit_item'                   => __( 'Edit Teacher' ),
					'update_item'                 => __( 'Update Teacher' ),
					'add_new_item'                => __( 'Add New Teacher' ),
					'new_item_name'               => __( 'New Teacher Name' ),
					'separate_items_with_commas'  => __( 'Separate teachers with commas' ),
					'add_or_remove_items'         => __( 'Add or remove teachers' ),
					'choose_from_most_used'       => __( 'Choose from the most used teachers' ),
					'menu_name'                   => __( 'Teachers' ),
				),
				'show_ui'       => true,
				'query_var'     => true,
				//'rewrite'       => array( 'slug' => 'the_writer' ), // свой слаг в URL
			));
		}
    }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

// Connecting styles and scripts
function enqueue_universal_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'swiper-slider', get_template_directory_uri().'/assets/css/swiper-bundle.min.css', 'style', null, null );
	wp_enqueue_style( 'universal-theme-style', get_template_directory_uri().'/assets/css/universal-theme.css', 'style', null, null );
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', null, null, true );
	wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap' );
	wp_enqueue_script( 'scripts', get_template_directory_uri().'/assets/js/scripts.js', 'swiper', null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

function trim_title($s) {
    echo mb_strimwidth(get_the_title(), 0, $s, '...');
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init_main_sidebar() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной сверху', 'universal-theme' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
        )
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной внизу', 'universal-theme' ),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
        )
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Добавьте меню сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
        )
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда.', 'universal-theme' ),
			'before_widget' => '<div id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
        )
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Посты', 'universal-theme' ),
			'id'            => 'sidebar-post',
			'description'   => esc_html__( 'Добавьте посты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="sidebar-post %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="sidebar-post-title">',
			'after_title'   => '</h2>',
        )
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init_main_sidebar' );


/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$description = $instance['description'];
		$link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $description ) ) {
			echo '<p class="widget-description">' . $description . '</p>';
        }
        if ( ! empty( $link ) ) {
            echo '<a target="_blank" rel="nofollow noopener" class="widget-link" href="' . $link . '">
            <svg class="icon download-icon">
				<use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#download"></use>
			</svg>
            Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Полезные файлы';
        $description = @ $instance['description'] ?: 'Описание';
        $link = @ $instance['link'] ?: 'http://disk.yandex.ru';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_downloader_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('downloader_widget_script', $theme_url .'/downloader_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_downloader_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );


add_filter( 'widget_tag_cloud_args', 'filter_tag_cloud' );
function filter_tag_cloud( $args ){
	// filter...
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '13';
	return $args;
}


/**
 * Добавление нового виджета Social_Widget.
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => 'Описание виджета', /*'classname' => 'social_widget',*/ )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];
		$instagram = $instance['instagram'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="social-links">';
		if ( ! empty( $facebook ) ) {
			echo '<a target="_blank" rel="nofollow noopener" class="social-link social-link-facebook" href='.$facebook.'>
			<svg class="icon social-icon-facebook">
				<use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#facebook"></use>
			</svg>
			</a>';
		}
		if ( ! empty( $twitter ) ) {
			echo '<a target="_blank" rel="nofollow noopener" class="social-link social-link-twitter " href='.$twitter.'>
			<svg class="icon social-icon-twitter">
				<use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#twitter"></use>
			</svg>
			</a>';
		}
		if ( ! empty( $youtube ) ) {
			echo '<a target="_blank" rel="nofollow noopener" class="social-link social-link-youtube" href='.$youtube.'>
			<svg class="icon social-icon-youtube">
				<use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#youtube"></use>
			</svg>
			</a>';
		}
		if ( ! empty( $instagram ) ) {
			echo '<a target="_blank" rel="nofollow noopener" class="social-link social-link-instagram" href='.$instagram.'>
			<svg class="icon social-icon-instagram">
				<use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#instagram"></use>
			</svg>
			</a>';
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Наши соцсети';
		$facebook = @ $instance['facebook'] ?: '';
		$twitter = @ $instance['twitter'] ?: '';
		$youtube = @ $instance['youtube'] ?: '';
		$instagram = @ $instance['instagram'] ?: '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Ссылка на facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Ссылка на twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Ссылка на youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Ссылка на instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_social_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('social_widget_script', $theme_url .'/social_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_social_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.social_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );


/**
 * Добавление нового виджета Recent_Widget.
 */
class Recent_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_posts_widget
			'Недвано опубликовано',
			array( 'description' => 'Последние посты', 'classname' => 'recent-posts-widget', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="recent-posts-wrapper">';
			global $post;
				$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
					<a href="<?php echo get_the_permalink(); ?>" class="recent-post-link">
						<img class="recent-post-thumbnail" src="<?php
							if (has_post_thumbnail( )) {
								echo get_the_post_thumbnail_url(null, 'thumbnail');
							} else {
								echo get_template_directory_uri().'/assets/images/img-default.jpg"';
							}
						?>" alt="">
						<div class="recent-post-info">
							<h4 class="recent-post-title">
								<?php trim_title(35); ?>
							</h4>
							<span class="recent-post-time">
							<?php
								$time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
								echo "$time_diff назад.";
							?>
							</span>
						</div>
					</a>
					<?php
				}
				wp_reset_postdata();
				echo '</div>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Недавно опубликовано';
		$count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_posts_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('recent_posts_widget_script', $theme_url .'/recent_posts_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_posts_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recent_posts_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Widget

// регистрация Recent_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'Recent_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );


/**
 * Добавление нового виджета Post_Widget.
 */
class Post_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'post_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: post_widget
			'Посты',
			array( 'description' => 'Посты', /*'classname' => 'post_widget',*/ )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_post_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_post_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$count = $instance['count'];

		echo $args['before_widget'];
		if ( ! empty( $count ) ) {
			echo '<div class="widget-posts-wrapper">';
			
			global $post;
				$category = get_the_category($post->ID);
				$current_cat_id = $category[0]->cat_ID;
				$current_cat_name = $category[0]->name;
				$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title', 'category' => $current_cat_id ) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
					<a href="<?php echo get_the_permalink(); ?>" class="widget-post-link">
						<img class="widget-post-thumbnail" src="<?php
							if (has_post_thumbnail( )) {
								echo get_the_post_thumbnail_url();
							} else {
								echo get_template_directory_uri().'/assets/images/img-default.jpg"';
							}
						?>" alt="">
						<div class="widget-post-info">
							<h4 class="widget-post-title">
								<?php trim_title(35); ?>
							</h4>
							
							<div class="down-info">
								<div class="views">
									<svg class="icon views-icon">
										<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#views"></use>
									</svg>
                                    <span class="views-counter"><?php comments_number('0', '1', '%'); ?></span>
								</div>
								<div class="comments">
									<svg class="icon comments-icon">
										<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
									</svg>
                                    <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                                </div>
							</div>
						</div>
					</a>
					<?php
				}
				wp_reset_postdata();
				echo '</div>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$count = @ $instance['count'] ?: '4';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_post_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_post_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('post_widget_script', $theme_url .'/post_widget_script.js' );
	}

	// стили виджета
	function add_post_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_post_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.post_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Post_Widget

// регистрация Post_Widget в WordPress
function register_post_widget() {
	register_widget( 'Post_Widget' );
}
add_action( 'widgets_init', 'register_post_widget' );

add_filter('excerpt_more', function($more) {
	return '...';
});

function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){

	wp_localize_script( 'jquery', 'adminAjax', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);  

}

add_action('wp_ajax_contacts_form', 'ajax_form');
add_action('wp_ajax_nopriv_contacts_form', 'ajax_form');
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_question = $_POST['contact_question'];
	$message = 'Пользователь' .$contact_name . ' Задал вопрос: ' .$contact_question . ' Его email: ' . $contact_email;
	$headers = 'From: Александр Ярославцев <web.dev.a1exweb@gmail.com>' . "\r\n";

	$send_message = wp_mail('web.dev.a1exweb@gmail.com', 'Пришёл вопрос от пользователя', $message, $headers);
	if($send_message) {
		echo 'Okay';
	} else {
		echo 'Error';
	}

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}

// remove versions
function rem_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'rem_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'rem_wp_ver_css_js', 9999 );
add_filter('the_generator', '__return_empty_string');