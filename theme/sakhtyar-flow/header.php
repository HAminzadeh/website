<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="syf-topbar">
  <div class="syf-container">
    <div class="syf-topbar__right">
      <span><i class="syf-dot"></i> پلتفرم هوشمند تصمیم‌سازی و توسعه ملک</span>
    </div>
    <div class="syf-topbar__left">
      <span>آکادمی ساخت‌یار</span>
      <span>مستندات</span>
      <span>پشتیبانی</span>
    </div>
  </div>
</div>

<header class="syf-header">
  <div class="syf-container syf-header__inner">
    <a class="syf-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="syf-brand__mark"></span>
      <span class="syf-brand__text">
        <strong>SakhtYar Flow</strong>
        <span>Property Intelligence → Project Execution</span>
      </span>
    </a>

    <div class="syf-nav-wrap">
      <button class="syf-mobile-toggle" type="button" aria-label="باز کردن منو">☰</button>
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

    <div class="syf-header-actions">
      <a class="syf-btn syf-btn--ghost" href="<?php echo esc_url(home_url('/docs/')); ?>">مستندات</a>
      <a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a>
    </div>
  </div>
</header>
