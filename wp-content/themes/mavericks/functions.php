<?php
/**
 * Mavericks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mavericks
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}


function mavericks_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-ua' => esc_html__( 'Ukraine', 'mavericks' ),
			'menu-pl' => esc_html__( 'Poland', 'mavericks' ),
		)
	);
}
add_action( 'after_setup_theme', 'mavericks_setup' );


/**
 * Enqueue scripts and styles.
 */
function mavericks_scripts() {
	wp_enqueue_style( 'mavericks-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i', array(), false );
	wp_enqueue_style( 'mavericks-normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css', array(), false );
	wp_enqueue_style( 'mavericks-slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), false );
	wp_enqueue_style( 'mavericks-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', array(), false );
	wp_enqueue_style( 'mavericks-pikaday', 'https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css', array(), false );
	wp_enqueue_style( 'mavericks-style', get_template_directory_uri() . '/dist/css/style.min.css', array(), false );

	wp_enqueue_script( 'mavericks-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), false, true );
	wp_enqueue_script( 'mavericks-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), false, true );
	wp_enqueue_script( 'mavericks-pikaday', 'https://cdn.jsdelivr.net/npm/pikaday/pikaday.js', array(), false, true );
	wp_enqueue_script( 'mavericks-youtube', 'https://www.youtube.com/player_api', array(), false, true );

	wp_enqueue_script( 'mavericks-scripts', get_template_directory_uri() . '/dist/js/scripts.min.js', array(), false, true );

	wp_localize_script( 'mavericks-scripts', 'frontendAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));


}
add_action( 'wp_enqueue_scripts', 'mavericks_scripts' );

// Create taxonomy
function create_event_taxonomies(){
	register_taxonomy('event_type', 'events', array(
		'hierarchical'  => false,
		'labels'        => array(
			'name'                        => _x( 'Типи подій', 'taxonomy general name' ),
			'singular_name'               => _x( 'Тип події', 'taxonomy singular name' ),
			'search_items'                => __( 'Пошук по типу події' ),
			'popular_items'               => __( 'Популярні типи подій' ),
			'all_items'                   => __( 'Всі типи події' ),
			'parent_item'                 => null,
			'parent_item_colon'           => null,
			'edit_item'                   => __( 'Редагувати тип події' ),
			'update_item'                 => __( 'Оновити тип події' ),
			'add_new_item'                => __( 'Додати новий тип події' ),
			'new_item_name'               => __( 'Створити тип події' ),
			'separate_items_with_commas'  => __( 'Розділіть типи комою' ),
			'add_or_remove_items'         => __( 'Додати або видалити тип події' ),
			'choose_from_most_used'       => __( 'Оберіть із популярних' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'show_in_rest'  => true,
		'rewrite'       => array( 'slug' => 'event_type' ),
	));
}
add_action( 'init', 'create_event_taxonomies' );

// Create post type
function register_post_types(){
	register_post_type( 'events', [
		'label'  => null,
		'labels' => [
			'name'               => 'Події',
			'singular_name'      => 'Подія',
			'add_new'            => 'Додати подію',
			'add_new_item'       => 'Додавання події',
			'edit_item'          => 'Редагування події',
			'new_item'           => 'Нова подія',
			'view_item'          => 'Дивитись події',
			'search_items'       => 'Шукати події',
			'not_found'          => 'Подій не знайдено',
			'menu_name'          => 'Події',
		],
		'description'            => '',
		'public'                 => true,
		'show_in_menu'           => true,
		'show_in_rest'        => true,
		'rest_base'           => null,
		'menu_position'       => 5,
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'custom-fields',  'page-attributes'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['event_type'],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	register_post_type( 'orders',
        array(
            'labels' => array(
                'name' => __( 'Заявки' ),
                'singular_name' => __( 'Заявка' )
            ),
            'public' => false,
            'show_ui' => true,
            'has_archive' => true,
            'supports' => array( 'title'),
            'taxonomies' => array( 'category', 'post_tag' ),
            'rewrite' => array( 'slug' => 'orders' )
        )
    );
}
add_action( 'init', 'register_post_types' );

//connection tax and posts
add_action( 'init', 'post_tag_for_events' );
function post_tag_for_events(){
	register_taxonomy_for_object_type( 'event_type', 'events');
	unregister_taxonomy_for_object_type('category', 'orders');
}


// AJAX events from front-page
function ajax_more_events() {
	$offset = $_POST['offset'];
	$per_page = $_POST['perPage'];
	$latest_events = new  WP_Query([
		'post_type' => 'events',
		'posts_per_page' => $per_page,
		'offset' => $offset,
	]);

	if($latest_events->have_posts()) {
		while ( $latest_events->have_posts() ) { $latest_events->the_post();
	
			get_template_part( 'parts/block', 'events' );
		
		} wp_reset_postdata();
	} 

	exit;
}
add_action('wp_ajax_nopriv_ajax_more_events', 'ajax_more_events'); 
add_action('wp_ajax_ajax_more_events', 'ajax_more_events');

// add metabox
function orders_meta_fields() {
	add_meta_box( 'orders_meta', 'Дані клієнта', 'orders_meta_fields_html', 'orders', 'normal', 'high');
}
add_action('add_meta_boxes', 'orders_meta_fields', 1);

function orders_meta_fields_html($post) {
?>
	<div class="admin-custom-meta" style="display: flex;flex-wrap: wrap;">
		<div class="admin-custom-meta__field" style="width:25%;">
			<label>
				<div>Ім'я</div>
				<input type="text" style="width:100%;" name="orders_meta[order_name]" value="<?php echo get_post_meta($post->ID, 'order_name', true); ?>" />
			</label>
		</div>
		<div class="admin-custom-meta__field" style="width:25%;">
			<label>
				<div>Прізвище</div>
				<input type="text" style="width:100%;" name="orders_meta[order_surname]" value="<?php echo get_post_meta($post->ID, 'order_surname', true); ?>" />
			</label>
		</div>
		<div class="admin-custom-meta__field" style="width:25%;">
			<label>
				<div>Посада</div>
				<input type="text" style="width:100%;" name="orders_meta[order_position]" value="<?php echo get_post_meta($post->ID, 'order_position', true); ?>" />
			</label>
		</div>
		<div class="admin-custom-meta__field" style="width:25%;">
			<label>
				<div>Веб-сайт</div>
				<input type="text" style="width:100%;" name="orders_meta[order_website]" value="<?php echo get_post_meta($post->ID, 'order_website', true); ?>" />
			</label>
		</div>
		<div class="admin-custom-meta__field admin-custom-meta__field--textarea" style="width:100%;">
			<label>
				<div>Коментар</div>
				<textarea style="width:100%;" name="orders_meta[order_comment]" rows="10"><?php echo get_post_meta($post->ID, 'order_comment', true); ?></textarea>
			</label>
		</div>
	</div>
	<input type="hidden" name="orders_meta_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}


function orders_meta_fields_update( $post_id ){
	if (
		   empty( $_POST['orders_meta'] )
		|| ! wp_verify_nonce( $_POST['orders_meta_nonce'], __FILE__ )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
	)
		return false;

	$_POST['orders_meta'] = array_map( 'sanitize_text_field', $_POST['orders_meta'] );
	foreach( $_POST['orders_meta'] as $key => $value ){
		if( empty($value) ){
			delete_post_meta( $post_id, $key );
			continue;
		}

		update_post_meta( $post_id, $key, $value );
	}

	return $post_id;
}
add_action( 'save_post', 'orders_meta_fields_update', 0 );


function insert_order() {
	$order_data_string = $_POST['orderData']; //получаем пост-данные
	parse_str($order_data_string, $order_data); // парсим данные в массив

	// очищаем поля для безопасности
	$order_data['name'] = sanitize_text_field($order_data['name']);
	$order_data['surname'] = sanitize_text_field($order_data['surname']);
	$order_data['position'] = sanitize_text_field($order_data['position']);
	$order_data['website'] = sanitize_text_field($order_data['website']);
	$order_data['comment'] = sanitize_textarea_field($order_data['comment']);

	$number_next_order = wp_count_posts('orders')->publish + 1;

	$admin_user = get_user_by( 'login', 'admin' );
	$admin_id = $admin_user->ID;

	$post_data = array(
		'post_title'    => 'Заявка ' . $number_next_order . ': ' . $order_data['name'] . ' ' . $order_data['surname'],
		'post_status'   => 'publish',
		'post_author'   => $admin_id,
		'post_type'     => 'orders',
		'meta_input'   => array(
			'orders_meta[order_name]' => $order_data['name'],
		),
	);

	$post_id = wp_insert_post( wp_slash($post_data) );

	// если пост добавился - добавляем к нему мета поля
	if($post_id){
		foreach($order_data as $key => $value) {
			update_post_meta($post_id, "order_$key", $value);
		}

		if(send_order_email($order_data)) {
			$respone['success'] = 'Заявка успішно надіслана';
		}else{
			$respone['success'] = 'Заявка не надіслана';
		}

		// ответ засовываем в джейсон и отдаем на фронт
		// $respone['success'] = 'Ви успішно відправили заявку';
   	}else{
		$respone['error'] = 'Сталась помилка, спробуйте пізніше';
	}

	echo json_encode($respone);
	exit;
}
add_action('wp_ajax_nopriv_insert_order', 'insert_order'); 
add_action('wp_ajax_insert_order', 'insert_order');

function send_order_email( $order_data ) {
    if ( isset( $_COOKIE['country'] ) && $_COOKIE['country'] == 'pl' ) {
        $to = get_theme_mod( 'mavericks_email_pl' );
    } else {
        $to = get_theme_mod( 'mavericks_email_ua' );
    }
	$subject = 'Нове замовлення';
	$message = "Нове замовлення отримане від:\n" . 
		"Ім'я: " . $order_data['name'] . "\n" . 
		"Прізвище: " . $order_data['surname'] . "\n" . 
		"Посада: " . $order_data['position'] . "\n" . 
		"Веб-сайт: " . $order_data['website'] . "\n" . 
		"Коментар: " . $order_data['comment'] . "\n";
    $headers = 'From: ' . get_option('admin_email') . "\r\n";
    $headers .= 'Reply-To: ' . get_option('admin_email') . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    // Send the email
    $sent = mail( $to, $subject, $message, $headers );
    
    // Check if the email was sent successfully
    if ( $sent ) {
        return true;
    } else {
        return false;
    }
}

// add cookie
function add_country_cookie() {
	$country = $_POST['country'];
	setcookie("country", $country, time() + (365 * 24 * 60 * 60), "/");
	if ( isset($_COOKIE['country'])) {
		$_COOKIE['country'] = $country;
	}

	if($country == 'ru') {
		$url = get_permalink(153); //страница для редиректа
		echo $url;
	}else{
		display_menu($country); // если не ру, то вызываем функцию, куда передаем ид страны
	}

	exit;
}
add_action('wp_ajax_nopriv_add_country_cookie', 'add_country_cookie'); 
add_action('wp_ajax_add_country_cookie', 'add_country_cookie');

// динамический вывод меню в зависимости от страны
function display_menu($country = 'ua'){
    if ( isset($_COOKIE['country']) && $_COOKIE['country'] != 'ru') {
		$country_menu = $_COOKIE['country'];
	}else{
		$country_menu = $country;
	}

	if (!has_nav_menu('menu-' . $country_menu)) { //если вдруг в куках значение, для которого нет меню, то делаем по дефолту юа меню
		$country_menu = 'ua';
	}

	$args = [
		'theme_location'  => 'menu-' . $country_menu,
		'container'       => false,
		'menu_class'      => 'main-menu',
		'fallback_cb'     => 'wp_page_menu',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
	];
	wp_nav_menu( $args );
}

function check_cookie() {
    if ( isset($_COOKIE['country']) && $_COOKIE['country'] == 'ru' && !is_page(153) ) {
		$url = get_permalink(153);
        wp_redirect($url);
        exit();
    }
}
add_action('template_redirect', 'check_cookie');

// add email fields in admin
function add_custom_email_fields( $wp_customize ) {
    $wp_customize->add_section( 'custom_email_section', array(
        'title' => __( 'E-mail сайту', 'mavericks' ),
        'priority' => 25,
    ) );
 
    $wp_customize->add_setting( 'mavericks_email_ua', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'mavericks_email_ua', array(
        'type' => 'email',
        'section' => 'custom_email_section',
        'label' => __( 'E-mail для України', 'mavericks' ),
        'description' => __( 'Введіть е-мейл для України', 'mavericks' ),
    ) );
 
    $wp_customize->add_setting( 'mavericks_email_pl', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'mavericks_email_pl', array(
        'type' => 'email',
        'section' => 'custom_email_section',
        'label' => __( 'E-mail для Польщі', 'mavericks' ),
        'description' => __( 'Введіть е-мейл для Польщі', 'mavericks' ),
    ) );
}
add_action( 'customize_register', 'add_custom_email_fields' );
