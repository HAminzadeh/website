<?php get_header(); ?>
<section class="syf-page-hero"><div class="syf-container"><div class="syf-kicker">جستجو</div><h1>نتایج برای «<?php echo esc_html(get_search_query()); ?>»</h1>
<form class="syf-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>"><input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="جستجو در دانش ساخت"><button class="syf-btn syf-btn--primary" type="submit">جستجو</button></form>
</div></section>
<main class="syf-container"><div class="syf-content syf-result-list">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?><article class="syf-result"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html(wp_strip_all_tags(get_the_excerpt())); ?></p></article><?php endwhile; else: ?><p>نتیجه‌ای پیدا نشد.</p><?php endif; ?>
</div></main>
<?php get_footer(); ?>