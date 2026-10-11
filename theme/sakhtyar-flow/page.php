<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<?php
$slug = get_post_field('post_name', get_the_ID());
if (function_exists('syf_has_static_page') && syf_has_static_page($slug)) {
    syf_render_static_page($slug);
} else {
?>
<section class="syf-page-hero"><div class="syf-container">
  <div class="syf-kicker">SakhtYar Flow</div>
  <h1><?php the_title(); ?></h1>
  <p><?php echo esc_html(get_the_excerpt() ?: 'بخشی از پلتفرم و مرکز دانش SakhtYar Flow.'); ?></p>
</div></section>
<main class="syf-container"><article class="syf-content"><?php the_content(); ?></article></main>
<?php } ?>
<?php endwhile; ?>
<?php get_footer(); ?>
