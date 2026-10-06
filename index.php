<?php get_header(); ?>
<main class="syf-wrap syf-content">
<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <article>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php the_excerpt(); ?>
    </article>
  <?php endwhile; ?>
<?php else: ?>
  <p>محتوایی یافت نشد.</p>
<?php endif; ?>
</main>
<?php get_footer(); ?>
