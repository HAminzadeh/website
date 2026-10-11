<footer class="syf-footer syf-app-footer">
  <div class="syf-container">
    <div class="syf-footer-grid">
      <div class="syf-footer-brand-col">
        <a class="syf-brand syf-app-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <span class="syf-brand__mark"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/react/sakhtyar-mark.svg'); ?>" alt="" width="48" height="48"></span>
          <span class="syf-brand__text"><strong>ساخت‌یار</strong><span>پلتفرم هوشمند مشارکت در ساخت</span></span>
        </a>
        <p>وب‌سایت و محصول ساخت‌یار با یک زبان بصری مشترک طراحی شده‌اند تا کاربر از شناخت مسئله تا ورود به جریان عملیاتی، تجربه‌ای منسجم داشته باشد.</p>
        <div class="syf-footer-badges"><span>فناوری ملک</span><span>فناوری ساخت</span><span>هوش مصنوعی</span></div>
      </div>
      <div><h4>ماژول‌ها</h4>
        <a href="<?php echo esc_url(home_url('/property-intelligence/')); ?>">هوشمندی ملک</a>
        <a href="<?php echo esc_url(home_url('/regulations/')); ?>">هوشمندی ضوابط</a>
        <a href="<?php echo esc_url(home_url('/feasibility/')); ?>">امکان‌سنجی و سناریوسازی</a>
        <a href="<?php echo esc_url(home_url('/financial-analysis/')); ?>">تحلیل مالی</a>
        <a href="<?php echo esc_url(home_url('/ai-assistant/')); ?>">دستیار هوشمند</a>
      </div>
      <div><h4>برای شما</h4>
        <a href="<?php echo esc_url(home_url('/owners/')); ?>">مالکان</a>
        <a href="<?php echo esc_url(home_url('/builders/')); ?>">سازندگان</a>
        <a href="<?php echo esc_url(home_url('/investors/')); ?>">سرمایه‌گذاران</a>
        <a href="<?php echo esc_url(home_url('/advisors/')); ?>">مشاوران و کارشناسان</a>
        <a href="<?php echo esc_url(home_url('/case-studies/')); ?>">مطالعات موردی</a>
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
    <div class="syf-theme-lab"><span>Theme Lab</span>
      <?php foreach (syf_visual_themes() as $key=>$label) : ?>
        <a class="<?php echo syf_current_visual_theme()===$key ? 'is-active' : ''; ?>" href="<?php echo esc_url(add_query_arg('syf_theme',$key)); ?>"><?php echo esc_html($label); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="syf-footer-bottom">
      <span>© <?php echo esc_html(date('Y')); ?> ساخت‌یار. تمامی حقوق محفوظ است.</span>
      <span>خروجی‌های تحلیلی و هوشمند، ابزار پشتیبان تصمیم هستند و جایگزین بررسی تخصصی و منابع رسمی نیستند.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
