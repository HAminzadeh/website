<?php get_header(); ?>
<?php while(have_posts()): the_post(); ?>
<main class="syf-v43-single">
<section class="syf-v43-article-hero"><div class="syf-container syf-v43-article-hero__grid"><div>
<div class="syf-v43-article-meta"><span><?php echo esc_html(get_post_meta(get_the_ID(),'_syf_article_category',true)?:'دانش ساخت'); ?></span><small><?php echo esc_html(function_exists('syf_article_reading_time')?syf_article_reading_time(get_the_ID()):6); ?> دقیقه مطالعه</small></div>
<h1><?php the_title(); ?></h1><p><?php echo esc_html(get_the_excerpt()); ?></p><div class="syf-v43-article-date">به‌روزرسانی: <?php echo esc_html(get_the_modified_date()); ?></div>
</div><div class="syf-v43-article-hero__media"><img src="<?php echo esc_url(function_exists('syf_article_cover_url')?syf_article_cover_url(get_the_ID()):''); ?>" alt=""></div></div></section>
<section class="syf-section syf-section--white"><div class="syf-container syf-v43-article-layout">
<aside class="syf-v43-article-aside"><div class="syf-v43-toc"><strong>در این مقاله</strong><nav data-syf-article-toc></nav></div><div class="syf-v43-article-disclaimer">این مطلب آموزشی است و جایگزین نظر حقوقی، مهندسی یا مالی تخصصی نیست.</div></aside>
<article class="syf-v43-article-content" data-syf-article-content><?php the_content(); ?></article>
</div></section>
<section class="syf-section syf-section--soft"><div class="syf-container"><div class="syf-cta syf-react-cta"><div><h2>این موضوع را روی یک پرونده واقعی ببینید</h2><p>ساخت‌یار داده، ضابطه، سناریو و خروجی تصمیم را در یک مسیر قابل پیگیری کنار هم می‌گذارد.</p></div><div class="syf-cta__actions"><a class="syf-btn syf-btn--light" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><a class="syf-btn syf-btn--ghost" href="<?php echo esc_url(home_url('/blog/')); ?>">همه مقالات</a></div></div></div></section>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>