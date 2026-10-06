<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="syf-header">
  <div class="syf-wrap syf-header-inner">
    <a class="syf-brand" href="<?php echo esc_url(home_url('/')); ?>">SakhtYar Flow</a>
    <nav aria-label="منوی اصلی">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'syf-nav',
        'fallback_cb' => 'syf_nav_fallback',
      ));
      ?>
    </nav>
  </div>
</header>
