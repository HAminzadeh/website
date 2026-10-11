<?php
if (!defined('ABSPATH')) { exit; }

define('SYF_THEME_VERSION', '0.4.2');

function syf_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    register_nav_menus(array('primary'=>'منوی اصلی','footer'=>'منوی فوتر'));
}
add_action('after_setup_theme', 'syf_theme_setup');

require_once get_template_directory() . '/inc/static-pages.php';
require_once get_template_directory() . '/inc/module-pages.php';
require_once get_template_directory() . '/inc/ui-showcase.php';

function syf_visual_themes() {
    return array(
        'flow'=>'Flow — رابط همسو با اپلیکیشن',
        'studio'=>'Studio — معماری روشن',
        'signal'=>'Signal — داده و هوش',
        'forge'=>'Forge — ساخت و اجرا',
    );
}

function syf_current_visual_theme() {
    $allowed = array_keys(syf_visual_themes());
    if (isset($_GET['syf_theme'])) {
        $preview = sanitize_key(wp_unslash($_GET['syf_theme']));
        if (in_array($preview, $allowed, true)) return $preview;
    }
    $saved = get_theme_mod('syf_visual_theme', 'flow');
    return in_array($saved, $allowed, true) ? $saved : 'flow';
}

function syf_enqueue_assets() {
    wp_enqueue_style('sakhtyar-flow-style', get_stylesheet_uri(), array(), SYF_THEME_VERSION);
    wp_enqueue_style('sakhtyar-flow-static', get_template_directory_uri().'/assets/css/static-pages.css', array('sakhtyar-flow-style'), SYF_THEME_VERSION);
    wp_enqueue_style('sakhtyar-flow-visual-theme', get_template_directory_uri().'/assets/css/themes/'.syf_current_visual_theme().'.css', array('sakhtyar-flow-static'), SYF_THEME_VERSION);
    if (syf_current_visual_theme() === 'flow') {
        wp_enqueue_style('sakhtyar-flow-react-aligned', get_template_directory_uri().'/assets/css/react-aligned.css', array('sakhtyar-flow-visual-theme'), SYF_THEME_VERSION);
        wp_enqueue_style('sakhtyar-flow-experience-v042', get_template_directory_uri().'/assets/css/experience-v042.css', array('sakhtyar-flow-react-aligned'), SYF_THEME_VERSION);
    }
    wp_enqueue_script('sakhtyar-flow-main', get_template_directory_uri().'/assets/js/main.js', array(), SYF_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'syf_enqueue_assets');

function syf_body_classes($classes) {
    $classes[] = 'syf-theme-' . syf_current_visual_theme();
    return $classes;
}
add_filter('body_class', 'syf_body_classes');

function syf_customize_register($wp_customize) {
    $wp_customize->add_section('syf_appearance', array('title'=>'ظاهر SakhtYar Flow','priority'=>35));
    $wp_customize->add_setting('syf_visual_theme', array(
        'default'=>'flow',
        'sanitize_callback'=>function($value){
            return array_key_exists($value, syf_visual_themes()) ? $value : 'flow';
        }
    ));
    $wp_customize->add_control('syf_visual_theme', array(
        'label'=>'تم بصری',
        'section'=>'syf_appearance',
        'type'=>'select',
        'choices'=>syf_visual_themes(),
    ));
}
add_action('customize_register', 'syf_customize_register');

function syf_upsert_page($title, $slug, $content='') {
    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing) return (int)$existing->ID;
    $id = wp_insert_post(array(
        'post_title'=>$title,
        'post_name'=>$slug,
        'post_content'=>$content,
        'post_status'=>'publish',
        'post_type'=>'page'
    ), true);
    return is_wp_error($id) ? 0 : (int)$id;
}

function syf_site_pages() {
    return array(
        'home'=>array('خانه','home'),
        'product'=>array('محصول','product'),
        'features'=>array('قابلیت‌ها','features'),
        'owners'=>array('برای مالکان','owners'),
        'builders'=>array('برای سازندگان','builders'),
        'investors'=>array('برای سرمایه‌گذاران','investors'),
        'advisors'=>array('برای مشاوران و کارشناسان','advisors'),
        'property'=>array('هوشمندی ملک','property-intelligence'),
        'regulations'=>array('هوشمندی ضوابط','regulations'),
        'ai'=>array('دستیار هوشمند ساخت‌یار','ai-assistant'),
        'feasibility'=>array('امکان‌سنجی و سناریوسازی','feasibility'),
        'builder_matching'=>array('تطبیق سازنده','builder-matching'),
        'financial_analysis'=>array('تحلیل مالی و سناریوی اقتصادی','financial-analysis'),
        'reports_documents'=>array('گزارش و مستندات','reports-documents'),
        'monitoring_alerts'=>array('پایش و هشدار','monitoring-alerts'),
        'roadmap'=>array('نقشه راه محصول','roadmap'),
        'docs'=>array('مستندات و راهنما','docs'),
        'academy'=>array('آکادمی ساخت‌یار','academy'),
        'cases'=>array('نمونه‌ها و مطالعات موردی','case-studies'),
        'about'=>array('درباره ما','about'),
        'faq'=>array('سوالات متداول','faq'),
        'contact'=>array('تماس با ما','contact'),
        'demo'=>array('درخواست دمو','request-demo'),
        'privacy'=>array('حریم خصوصی','privacy'),
        'blog'=>array('دانش ساخت','blog'),
    );
}

function syf_bootstrap_site() {
    update_option('blogname', 'SakhtYar Flow');
    update_option('blogdescription', 'پلتفرم هوشمند تحلیل، توسعه و مدیریت پروژه‌های ساختمانی');
    update_option('timezone_string', 'Asia/Tehran');
    update_option('start_of_week', 6);
    update_option('permalink_structure', '/%postname%/');
    update_option('blog_public', '0');

    $ids = array();
    foreach (syf_site_pages() as $key=>$def) {
        $ids[$key] = syf_upsert_page($def[0], $def[1]);
    }

    if (!empty($ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $ids['home']);
    }
    if (!empty($ids['blog'])) update_option('page_for_posts', $ids['blog']);

    flush_rewrite_rules();
    update_option('syf_bootstrap_version', SYF_THEME_VERSION);
}

function syf_maybe_bootstrap_site() {
    if (get_option('syf_bootstrap_version') !== SYF_THEME_VERSION) {
        syf_bootstrap_site();
    }
}
add_action('after_switch_theme', 'syf_bootstrap_site');
add_action('init', 'syf_maybe_bootstrap_site', 20);
