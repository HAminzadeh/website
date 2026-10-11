<?php get_header(); ?>
<main class="syf-v43-blog">
<section class="syf-v43-blog-hero"><div class="syf-container"><div class="syf-kicker">دانش ساخت</div><h1>مقالات و راهنماهای ساخت‌یار</h1><p>محتوای کاربردی درباره مشارکت در ساخت، تحلیل ملک، ضوابط، سناریوسازی، اقتصاد پروژه و هوش مصنوعی.</p><div class="syf-v43-blog-filter"><span>موضوعات:</span><a href="#articles">مشارکت</a><a href="#articles">ضوابط</a><a href="#articles">تحلیل مالی</a><a href="#articles">امکان‌سنجی</a><a href="#articles">هوش مصنوعی</a></div></div></section>
<section id="articles" class="syf-section syf-section--white"><div class="syf-container">
<?php if (have_posts()): ?><div class="syf-v43-blog-grid"><?php $i=0; while(have_posts()): the_post(); $i++; ?>
<a class="syf-v43-blog-card<?php echo $i===1?' syf-v43-blog-card--featured':''; ?>" href="<?php the_permalink(); ?>" data-syf-reveal>
<div class="syf-v43-blog-card__media"><img src="<?php echo esc_url(function_exists('syf_article_cover_url')?syf_article_cover_url(get_the_ID()):''); ?>" alt="" loading="<?php echo $i===1?'eager':'lazy'; ?>"></div>
<div class="syf-v43-blog-card__body"><div class="syf-v43-blog-card__meta"><span><?php echo esc_html(get_post_meta(get_the_ID(),'_syf_article_category',true)?:'دانش ساخت'); ?></span><small><?php echo esc_html(function_exists('syf_article_reading_time')?syf_article_reading_time(get_the_ID()):6); ?> دقیقه مطالعه</small></div><h2><?php the_title(); ?></h2><p><?php echo esc_html(get_the_excerpt()); ?></p><b>ادامه مقاله ←</b></div>
</a><?php endwhile; ?></div><?php else: ?><div class="syf-content"><p>هنوز مقاله‌ای منتشر نشده است.</p></div><?php endif; ?>
</div></section></main>
<?php get_footer(); ?>