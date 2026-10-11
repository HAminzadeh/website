<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<?php
$slug = get_post_field('post_name', get_the_ID());

if (in_array($slug, array('account','market-analytics'), true)) {
    $is_account = $slug === 'account';
    ?>
    <section class="syf-v050-tool-hero">
      <div class="syf-container syf-v050-tool-hero__grid">
        <div>
          <div class="syf-kicker"><?php echo $is_account ? 'حساب و دسترسی' : 'تحلیل داده‌محور'; ?></div>
          <h1><?php echo $is_account ? 'حساب کاربری ساخت‌یار' : 'تحلیل بازار و منطقه'; ?></h1>
          <p><?php echo $is_account
              ? 'ورود، ساخت حساب و سطح دسترسی شما به مقالات، جزئیات ماژول‌ها و ابزارهای تحلیلی از اینجا مدیریت می‌شود.'
              : 'روندهای منطقه‌ای، تازگی داده، سیگنال‌های قیمت و خروجی خزنده‌ها در این صفحه به داده Backend متصل می‌شوند.'; ?></p>
        </div>
        <div class="syf-v050-tool-hero__badge"><?php echo $is_account ? 'Access Center' : 'Market Intelligence'; ?></div>
      </div>
    </section>
    <main class="syf-container syf-v050-tool-main"><article class="syf-content"><?php the_content(); ?></article></main>
    <?php
} elseif (function_exists('syf_has_rich_page') && syf_has_rich_page($slug)) {
    syf_render_rich_page($slug);
} elseif (function_exists('syf_has_module_page') && syf_has_module_page($slug)) {
    syf_render_module_page($slug);
} elseif (function_exists('syf_has_static_page') && syf_has_static_page($slug)) {
    syf_render_static_page($slug);
} else {
?>
<section class="syf-page-hero"><div class="syf-container">
  <div class="syf-kicker">ساخت‌یار</div>
  <h1><?php the_title(); ?></h1>
  <p><?php echo esc_html(get_the_excerpt() ?: 'بخشی از پلتفرم و مرکز دانش ساخت‌یار.'); ?></p>
</div></section>
<main class="syf-container"><article class="syf-content"><?php the_content(); ?></article></main>
<?php } ?>
<?php endwhile; ?>
<?php get_footer(); ?>
