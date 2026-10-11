<footer class="syf-footer">
  <div class="syf-container">
    <div class="syf-footer-grid">
      <div>
        <a class="syf-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <span class="syf-brand__mark"></span>
          <span class="syf-brand__text"><strong>SakhtYar Flow</strong><span>Property × Construction Intelligence</span></span>
        </a>
        <p>پلتفرمی برای تبدیل داده‌های ملک، ضوابط، سناریوهای توسعه و تحلیل اقتصادی به یک جریان تصمیم‌گیری روشن و قابل پیگیری.</p>
        <div class="syf-footer-badges"><span>PropTech</span><span>ConstructionTech</span><span>AI</span></div>
      </div>

      <div><h4>پلتفرم</h4>
        <a href="<?php echo esc_url(home_url('/product/')); ?>">محصول</a>
        <a href="<?php echo esc_url(home_url('/features/')); ?>">قابلیت‌ها</a>
        <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">تحلیل ملک</a>
        <a href="<?php echo esc_url(home_url('/regulations/')); ?>">قوانین و ضوابط</a>
        <a href="<?php echo esc_url(home_url('/ai-assistant/')); ?>">دستیار هوشمند</a>
      </div>

      <div><h4>برای شما</h4>
        <a href="<?php echo esc_url(home_url('/owners/')); ?>">مالکان</a>
        <a href="<?php echo esc_url(home_url('/builders/')); ?>">سازندگان</a>
        <a href="<?php echo esc_url(home_url('/investors/')); ?>">سرمایه‌گذاران</a>
        <a href="<?php echo esc_url(home_url('/advisors/')); ?>">مشاوران و کارشناسان</a>
        <a href="<?php echo esc_url(home_url('/case-studies/')); ?>">نمونه‌های نمایشی</a>
      </div>

      <div><h4>منابع و شرکت</h4>
        <a href="<?php echo esc_url(home_url('/academy/')); ?>">آکادمی ساخت‌یار</a>
        <a href="<?php echo esc_url(home_url('/docs/')); ?>">مستندات و راهنما</a>
        <a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
        <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
        <a href="<?php echo esc_url(home_url('/privacy/')); ?>">حریم خصوصی</a>
      </div>
    </div>

    <?php if (defined('WP_DEBUG') && WP_DEBUG) : ?>
    <div class="syf-theme-lab">
      <span>Theme Lab</span>
      <?php foreach (syf_visual_themes() as $key=>$label) : ?>
        <a class="<?php echo syf_current_visual_theme()===$key ? 'is-active' : ''; ?>" href="<?php echo esc_url(add_query_arg('syf_theme',$key)); ?>"><?php echo esc_html($label); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="syf-footer-bottom">
      <span>© <?php echo esc_html(date('Y')); ?> SakhtYar Flow. تمامی حقوق محفوظ است.</span>
      <span>نسخه معرفی محصول — داده‌ها و نمونه‌های عددی نمایشی هستند مگر آن‌که منبع‌گذاری شوند.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
