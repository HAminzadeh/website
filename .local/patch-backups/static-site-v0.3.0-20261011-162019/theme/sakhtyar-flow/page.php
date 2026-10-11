<?php get_header(); ?>
<section class="syf-page-hero">
  <div class="syf-container">
    <div class="syf-kicker">SakhtYar Flow</div>
    <h1><?php the_title(); ?></h1>
    <p>این صفحه بخشی از پلتفرم و مرکز دانش SakhtYar Flow است و در نسخه‌های بعدی با محتوای تخصصی و داده‌های واقعی تکمیل می‌شود.</p>
  </div>
</section>
<main class="syf-container">
<?php while (have_posts()) : the_post(); ?>
  <article class="syf-content">
    <?php if (trim(get_the_content())): ?>
      <?php the_content(); ?>
    <?php else: ?>
      <h2>این بخش در حال تکمیل است</h2>
      <p>ساختار و طراحی اصلی این صفحه آماده شده و محتوای تخصصی آن در مرحله بعدی بر اساس مستندات پروژه، داده‌های واقعی و نیاز هر گروه کاربری اضافه خواهد شد.</p>
    <?php endif; ?>
  </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
