<?php
if (!defined('ABSPATH')) { exit; }

function syf_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    register_nav_menus(array(
        'primary' => 'منوی اصلی',
        'footer'  => 'منوی فوتر',
    ));
}
add_action('after_setup_theme', 'syf_theme_setup');

function syf_enqueue_assets() {
    wp_enqueue_style('sakhtyar-flow-style', get_stylesheet_uri(), array(), '0.2.0');
    wp_enqueue_script('sakhtyar-flow-main', get_template_directory_uri() . '/assets/js/main.js', array(), '0.2.0', true);
}
add_action('wp_enqueue_scripts', 'syf_enqueue_assets');

function syf_upsert_page($title, $slug, $content = '') {
    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing) return (int)$existing->ID;

    $id = wp_insert_post(array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ), true);

    return is_wp_error($id) ? 0 : (int)$id;
}

function syf_bootstrap_site() {
    if (get_option('syf_bootstrap_done_v2') === '1') return;

    update_option('blogname', 'SakhtYar Flow');
    update_option('blogdescription', 'پلتفرم هوشمند تحلیل، توسعه و مدیریت پروژه‌های ساختمانی');
    update_option('timezone_string', 'Asia/Tehran');
    update_option('start_of_week', 6);
    update_option('permalink_structure', '/%postname%/');
    update_option('blog_public', '0');

    $pages = array(
        'home' => array('خانه', 'home'),
        'product' => array('محصول', 'product'),
        'features' => array('قابلیت‌ها', 'features'),
        'owners' => array('برای مالکان', 'owners'),
        'builders' => array('برای سازندگان', 'builders'),
        'investors' => array('برای سرمایه‌گذاران', 'investors'),
        'advisors' => array('برای مشاوران و کارشناسان', 'advisors'),
        'property' => array('تحلیل هوشمند ملک', 'property-intelligence'),
        'regulations' => array('قوانین و ضوابط', 'regulations'),
        'ai' => array('دستیار هوشمند', 'ai-assistant'),
        'feasibility' => array('امکان‌سنجی و سناریوسازی', 'feasibility'),
        'docs' => array('مستندات و راهنما', 'docs'),
        'academy' => array('آکادمی ساخت‌یار', 'academy'),
        'cases' => array('نمونه‌ها و مطالعات موردی', 'case-studies'),
        'about' => array('درباره ما', 'about'),
        'faq' => array('سوالات متداول', 'faq'),
        'contact' => array('تماس با ما', 'contact'),
        'demo' => array('درخواست دمو', 'request-demo'),
        'privacy' => array('حریم خصوصی', 'privacy'),
        'blog' => array('دانش ساخت', 'blog'),
    );

    $ids = array();
    foreach ($pages as $key => $def) {
        $ids[$key] = syf_upsert_page($def[0], $def[1]);
    }

    if (!empty($ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $ids['home']);
    }
    if (!empty($ids['blog'])) {
        update_option('page_for_posts', $ids['blog']);
    }

    $menu_name = 'منوی اصلی ساخت‌یار';
    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? (int)$menu->term_id : wp_create_nav_menu($menu_name);

    if (!is_wp_error($menu_id)) {
        $existing_items = wp_get_nav_menu_items($menu_id);
        if (!$existing_items) {
            $menu_keys = array('home','product','features','owners','builders','investors','academy','docs','about','contact');
            foreach ($menu_keys as $key) {
                if (empty($ids[$key])) continue;
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'     => get_the_title($ids[$key]),
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $ids[$key],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                ));
            }
        }

        $locations = get_theme_mod('nav_menu_locations', array());
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    flush_rewrite_rules();
    update_option('syf_bootstrap_done_v2', '1');
}
add_action('after_switch_theme', 'syf_bootstrap_site');

function syf_nav_fallback() {
    echo '<div class="syf-nav">';
    wp_list_pages(array('title_li' => '', 'depth' => 1));
    echo '</div>';
}
