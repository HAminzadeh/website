<?php get_header(); ?>
<main class="syf-wrap">
<?php while (have_posts()) : the_post(); ?>
  <article class="syf-content">
    <h1><?php the_title(); ?></h1>
    <?php if (trim(get_the_content())): ?>
      <div><?php the_content(); ?></div>
    <?php else: ?>
      <p class="syf-muted">محتوای این بخش در نسخه بعدی قالب تکمیل خواهد شد.</p>
    <?php endif; ?>
  </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
