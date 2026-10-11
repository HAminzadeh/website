<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="syf-topbar">
  <div class="syf-container">
    <div class="syf-topbar__right"><span class="syf-dot"></span><span>تصمیم‌گیری داده‌محور برای توسعه ملک و ساخت‌وساز</span></div>
    <div class="syf-topbar__left">
      <a href="<?php echo esc_url(home_url('/docs/')); ?>">راهنما</a>
      <a href="<?php echo esc_url(home_url('/academy/')); ?>">آکادمی</a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a>
    </div>
  </div>
</div>

<header class="syf-header">
  <div class="syf-container syf-header__inner">
    <a class="syf-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="syf-brand__mark"></span>
      <span class="syf-brand__text"><strong>SakhtYar Flow</strong><span>Property × Construction Intelligence</span></span>
    </a>

    <div class="syf-nav-wrap">
      <nav class="syf-desktop-nav">
        <a href="<?php echo esc_url(home_url('/product/')); ?>">پلتفرم</a>
        <a href="<?php echo esc_url(home_url('/features/')); ?>">قابلیت‌ها</a>
        <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">تحلیل ملک</a>
        <a href="<?php echo esc_url(home_url('/regulations/')); ?>">ضوابط</a>
        <a href="<?php echo esc_url(home_url('/feasibility/')); ?>">امکان‌سنجی</a>
        <a href="<?php echo esc_url(home_url('/academy/')); ?>">دانش ساخت</a>
      </nav>

      <div class="syf-header-actions">
        <a class="syf-btn syf-btn--ghost syf-header-login" href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a>
        <a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a>
        <button class="syf-mobile-toggle" type="button" aria-expanded="false" aria-controls="syf-mobile-nav">☰</button>
      </div>
    </div>
  </div>

  <nav id="syf-mobile-nav" class="syf-mobile-nav">
    <a href="<?php echo esc_url(home_url('/product/')); ?>">پلتفرم</a>
    <a href="<?php echo esc_url(home_url('/features/')); ?>">قابلیت‌ها</a>
    <a href="<?php echo esc_url(home_url('/owners/')); ?>">مالکان</a>
    <a href="<?php echo esc_url(home_url('/builders/')); ?>">سازندگان</a>
    <a href="<?php echo esc_url(home_url('/investors/')); ?>">سرمایه‌گذاران</a>
    <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">تحلیل ملک</a>
    <a href="<?php echo esc_url(home_url('/regulations/')); ?>">قوانین و ضوابط</a>
    <a href="<?php echo esc_url(home_url('/ai-assistant/')); ?>">دستیار هوشمند</a>
    <a href="<?php echo esc_url(home_url('/academy/')); ?>">آکادمی</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
  </nav>
</header>
