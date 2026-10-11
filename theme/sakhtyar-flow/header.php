<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="syf-header syf-app-header">
  <div class="syf-container syf-header__inner">
    <a class="syf-brand syf-app-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="syf-brand__mark"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/react/sakhtyar-mark.svg'); ?>" alt="" width="48" height="48"></span>
      <span class="syf-brand__text"><strong>ساخت‌یار</strong><span>مدیریت هوشمند مشارکت در ساخت</span></span>
    </a>
    <nav class="syf-desktop-nav syf-app-nav" aria-label="منوی اصلی">
      <a href="<?php echo esc_url(home_url('/product/')); ?>">پلتفرم</a>
      <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">هوشمندی ملک</a>
      <a href="<?php echo esc_url(home_url('/regulations/')); ?>">ضوابط</a>
      <a href="<?php echo esc_url(home_url('/feasibility/')); ?>">امکان‌سنجی</a>
      <a href="<?php echo esc_url(home_url('/ai-assistant/')); ?>">دستیار هوشمند</a>
      <a href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه</a>
      <a href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه محصول</a>
    <a href="<?php echo esc_url(home_url('/academy/')); ?>">آکادمی</a>
    </nav>
    <div class="syf-header-actions syf-app-actions">
      <a class="syf-btn syf-btn--ghost syf-header-login" href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a>
      <a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a>
      <button class="syf-mobile-toggle" type="button" aria-expanded="false" aria-controls="syf-mobile-nav" aria-label="باز کردن منو">☰</button>
    </div>
  </div>
  <nav id="syf-mobile-nav" class="syf-mobile-nav" aria-label="منوی موبایل">
    <a href="<?php echo esc_url(home_url('/product/')); ?>">پلتفرم</a>
    <a href="<?php echo esc_url(home_url('/features/')); ?>">قابلیت‌ها</a>
    <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">هوشمندی ملک</a>
    <a href="<?php echo esc_url(home_url('/regulations/')); ?>">هوشمندی ضوابط</a>
    <a href="<?php echo esc_url(home_url('/feasibility/')); ?>">امکان‌سنجی و سناریوسازی</a>
    <a href="<?php echo esc_url(home_url('/financial-analysis/')); ?>">تحلیل مالی</a>
    <a href="<?php echo esc_url(home_url('/ai-assistant/')); ?>">دستیار هوشمند</a>
    <a href="<?php echo esc_url(home_url('/builder-matching/')); ?>">تطبیق سازنده</a>
    <a href="<?php echo esc_url(home_url('/reports-documents/')); ?>">گزارش و مستندات</a>
    <a href="<?php echo esc_url(home_url('/monitoring-alerts/')); ?>">پایش و هشدار</a>
    <a href="<?php echo esc_url(home_url('/owners/')); ?>">مالکان</a>
    <a href="<?php echo esc_url(home_url('/builders/')); ?>">سازندگان</a>
    <a href="<?php echo esc_url(home_url('/investors/')); ?>">سرمایه‌گذاران</a>
    <a href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه محصول</a>
    <a href="<?php echo esc_url(home_url('/academy/')); ?>">آکادمی</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
  </nav>
</header>
