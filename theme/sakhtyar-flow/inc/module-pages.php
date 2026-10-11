<?php
if (!defined('ABSPATH')) { exit; }

function syf_module_pages() {
    static $pages = null;
    if ($pages !== null) return $pages;

    $path = get_template_directory() . '/data/modules.json';
    if (!is_readable($path)) {
        $pages = array();
        return $pages;
    }

    $json = file_get_contents($path);
    $decoded = json_decode($json, true);
    $pages = is_array($decoded) ? $decoded : array();
    return $pages;
}

function syf_has_module_page($slug) {
    $pages = syf_module_pages();
    return isset($pages[$slug]);
}

function syf_render_module_page($slug) {
    $pages = syf_module_pages();
    if (!isset($pages[$slug])) return;
    $page = $pages[$slug];
    ?>
    <main class="syf-module-page">
      <section class="syf-module-hero">
        <div class="syf-container syf-module-hero__grid">
          <div class="syf-module-hero__copy">
            <div class="syf-kicker"><?php echo esc_html($page['kicker']); ?></div>
            <h1><?php echo esc_html($page['title']); ?></h1>
            <p><?php echo esc_html($page['lead']); ?></p>
            <div class="syf-module-hero__actions">
              <a class="syf-btn syf-btn--primary" href="#how-it-works">چطور کار می‌کند؟</a>
              <a class="syf-btn syf-btn--outline" href="#app-preview">نمای ماژول در اپلیکیشن</a>
            </div>
            <div class="syf-module-audience">
              <span>مناسب برای:</span>
              <?php foreach ($page['audiences'] as $audience) : ?><b><?php echo esc_html($audience); ?></b><?php endforeach; ?>
            </div>
          </div>

          <div id="app-preview" class="syf-module-app-preview">
            <div class="syf-module-app-preview__bar">
              <span class="syf-module-preview-brand"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/react/sakhtyar-mark.svg'); ?>" alt="" width="30" height="30">ساخت‌یار</span>
              <span class="syf-module-preview-state">نمونه رابط</span>
            </div>
            <div class="syf-module-app-preview__body">
              <div class="syf-module-app-preview__side"><i class="is-active"></i><i></i><i></i><i></i></div>
              <div class="syf-module-app-preview__main">
                <small><?php echo esc_html($page['kicker']); ?></small>
                <h3><?php echo esc_html($page['title']); ?></h3>
                <div class="syf-module-preview-grid">
                  <?php foreach ($page['preview'] as $item) : ?>
                    <div><span><?php echo esc_html($item[0]); ?></span><strong><?php echo esc_html($item[1]); ?></strong></div>
                  <?php endforeach; ?>
                </div>
                <div class="syf-module-preview-list"><span></span><span></span><span></span></div>
              </div>
            </div>
            <div class="syf-module-preview-note">این پیش‌نمایش برای توضیح ساختار ماژول است و داده‌های آن نمونه هستند.</div>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container syf-module-purpose">
          <div><div class="syf-kicker">به چه کاری می‌آید؟</div><h2>هدف این ماژول</h2></div>
          <p><?php echo esc_html($page['purpose']); ?></p>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head">
            <div><div class="syf-kicker">اجزای داخلی</div><h2>چه بخش‌هایی دارد؟</h2></div>
            <p>هر بخش یک وظیفه مشخص دارد و خروجی آن برای مرحله بعدی قابل استفاده است.</p>
          </div>
          <div class="syf-module-capability-grid">
            <?php foreach ($page['capabilities'] as $index=>$item) : ?>
              <article class="syf-module-capability">
                <span><?php echo esc_html(sprintf('%02d',$index+1)); ?></span>
                <h3><?php echo esc_html($item[0]); ?></h3>
                <p><?php echo esc_html($item[1]); ?></p>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="how-it-works" class="syf-section syf-section--white">
        <div class="syf-container">
          <div class="syf-section-head">
            <div><div class="syf-kicker">گردش کار</div><h2>چطور کار می‌کند؟</h2></div>
            <p>این مسیر منطق کلی ماژول را نشان می‌دهد؛ پیاده‌سازی عملیاتی هر مرحله به داده و سرویس‌های هسته عملیاتی متصل خواهد شد.</p>
          </div>
          <div class="syf-module-workflow">
            <?php foreach ($page['workflow'] as $index=>$item) : ?>
              <article><span><?php echo esc_html($index+1); ?></span><div><h3><?php echo esc_html($item[0]); ?></h3><p><?php echo esc_html($item[1]); ?></p></div></article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container syf-module-io-grid">
          <article>
            <div class="syf-kicker">ورودی‌ها</div><h2>چه چیزهایی لازم است؟</h2>
            <div class="syf-module-list">
              <?php foreach ($page['inputs'] as $item) : ?><div><span>→</span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?>
            </div>
          </article>
          <article>
            <div class="syf-kicker">خروجی‌ها</div><h2>چه چیزی تحویل می‌گیرید؟</h2>
            <div class="syf-module-list syf-module-list--success">
              <?php foreach ($page['outputs'] as $item) : ?><div><span>✓</span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?>
            </div>
          </article>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container syf-module-guide">
          <div><div class="syf-kicker">راهنمای استفاده</div><h2>سه نکته قبل از استفاده</h2><p>این نکات کمک می‌کنند خروجی ماژول را در جای درست خودش در فرآیند تصمیم بخوانید.</p></div>
          <div class="syf-module-guide__items">
            <?php foreach ($page['guidance'] as $index=>$item) : ?><div><span><?php echo esc_html($index+1); ?></span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">ادامه مسیر</div><h2>ماژول‌های دیگر ساخت‌یار</h2></div><a class="syf-link" href="<?php echo esc_url(home_url('/#decision-modules')); ?>">بازگشت به همه ماژول‌ها ←</a></div>
          <div class="syf-module-nav-grid">
            <?php $count=0; foreach ($pages as $other_slug=>$other) : if ($other_slug===$slug) continue; ?>
              <a href="<?php echo esc_url(home_url('/'.$other_slug.'/')); ?>"><small><?php echo esc_html($other['kicker']); ?></small><strong><?php echo esc_html($other['title']); ?></strong><span>←</span></a>
            <?php $count++; if ($count===4) break; endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container"><div class="syf-cta syf-react-cta">
          <div><h2>می‌خواهید این ماژول را در جریان واقعی محصول ببینید؟</h2><p>دموی ساخت‌یار بر اساس نقش و نوع پروژه شما تنظیم می‌شود.</p></div>
          <div class="syf-cta__actions"><a class="syf-btn syf-btn--light" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><a class="syf-btn syf-btn--ghost" href="<?php echo esc_url(home_url('/contact/')); ?>">گفت‌وگو با ما</a></div>
        </div></div>
      </section>
    </main>
    <?php
}
