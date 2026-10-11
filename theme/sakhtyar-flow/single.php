<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<section class="syf-page-hero"><div class="syf-container syf-narrow"><div class="syf-kicker">دانش ساخت</div><h1><?php the_title(); ?></h1><p><?php echo esc_html(get_the_date()); ?></p></div></section>
<main class="syf-container syf-narrow"><article class="syf-content"><?php the_content(); ?></article></main>
<?php endwhile; ?>
<?php get_footer(); ?>