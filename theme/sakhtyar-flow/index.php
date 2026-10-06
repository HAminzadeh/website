<?php get_header(); ?>
<section class="syf-page-hero">
  <div class="syf-container">
    <div class="syf-kicker">دانش ساخت</div>
    <h1>مقالات و راهنماهای SakhtYar Flow</h1>
    <p>محتوای آموزشی درباره مشارکت در ساخت، تحلیل ملک، ضوابط، سرمایه‌گذاری و فناوری ساختمان.</p>
  </div>
</section>
<main class="syf-container">
  <div class="syf-content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article style="padding:18px 0;border-bottom:1px solid #e5e7eb">
        <h2 style="margin:0 0 8px"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div style="color:#64748b;line-height:1.9"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; else: ?>
      <p>هنوز مقاله‌ای منتشر نشده است.</p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
