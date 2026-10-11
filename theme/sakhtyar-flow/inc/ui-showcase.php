<?php
if (!defined('ABSPATH')) { exit; }

/**
 * SakhtYar Flow v0.4.2 — richer product storytelling and UI previews.
 * All numbers rendered by these showcase components are demonstrative only.
 */

function syf_showcase_catalog() {
    return array(
        'product' => array(
            'eyebrow'=>'مرکز تصمیم پروژه',
            'title'=>'نمای یکپارچه پرونده',
            'kpis'=>array(array('آمادگی داده','۸۶٪'),array('سناریوهای باز','۳'),array('موارد نیازمند بررسی','۵')),
            'chart_title'=>'روند آمادگی برای تصمیم',
            'chart'=>array(28,36,42,49,57,68,78,86),
            'bars'=>array(array('کیفیت داده',86),array('پوشش ضوابط',74),array('آمادگی مالی',79)),
            'feed'=>array(array('پرونده ملک','به‌روزرسانی شد'),array('ضابطه مرتبط','۴ منبع نمونه'),array('سناریو پایه','آماده مقایسه')),
        ),
        'features' => array(
            'eyebrow'=>'پوشش قابلیت‌ها',
            'title'=>'داشبورد محصول',
            'kpis'=>array(array('ماژول تصمیم','۸'),array('نقش کاربری','۴'),array('جریان متصل','۱')),
            'chart_title'=>'پوشش نمونه جریان تصمیم',
            'chart'=>array(18,26,39,48,59,72,83,91),
            'bars'=>array(array('ملک و GIS',91),array('دانش و ضوابط',78),array('اقتصاد و سناریو',71)),
            'feed'=>array(array('هوشمندی ملک','فعال در نمونه'),array('SakhtYar AI','در حال توسعه'),array('پایش','در نقشه راه')),
        ),
        'owners' => array(
            'eyebrow'=>'نمای مالک',
            'title'=>'آمادگی برای مذاکره',
            'kpis'=>array(array('کیفیت پرونده','۸۲٪'),array('ابهام کلیدی','۴'),array('سناریو','۳')),
            'chart_title'=>'شفافیت تصمیم در طول تکمیل پرونده',
            'chart'=>array(24,31,43,48,62,70,81,88),
            'bars'=>array(array('اسناد پایه',88),array('شناخت ضابطه',69),array('مدل اقتصادی',76)),
            'feed'=>array(array('مدرک مالکیت','نمونه: موجود'),array('ریسک ضابطه','نیازمند بررسی'),array('جلسه مذاکره','چک‌لیست آماده')),
        ),
        'builders' => array(
            'eyebrow'=>'نمای سازنده',
            'title'=>'غربال فرصت پروژه',
            'kpis'=>array(array('تناسب پروژه','۸۷٪'),array('ریسک باز','۳'),array('گزینه مالی','۴')),
            'chart_title'=>'مقایسه جذابیت فرصت',
            'chart'=>array(42,53,46,61,67,74,80,87),
            'bars'=>array(array('فنی',83),array('ضابطه',72),array('اقتصاد',89)),
            'feed'=>array(array('موقعیت','قابل بررسی'),array('ظرفیت ساخت','سناریویی'),array('تصمیم','ورود به بررسی عمیق')),
        ),
        'investors' => array(
            'eyebrow'=>'نمای سرمایه‌گذار',
            'title'=>'ریسک و بازده سناریو',
            'kpis'=>array(array('سناریو','۳'),array('حساسیت بالا','۲ متغیر'),array('ریسک داده','متوسط')),
            'chart_title'=>'ارزش نسبی سناریوهای نمونه',
            'chart'=>array(33,39,45,51,66,60,73,82),
            'bars'=>array(array('بازده',82),array('نقدشوندگی',67),array('اطمینان داده',74)),
            'feed'=>array(array('سناریو A','متعادل'),array('سناریو B','ریسک بیشتر'),array('سناریو C','سرمایه بیشتر')),
        ),
        'advisors' => array(
            'eyebrow'=>'نمای کارشناس',
            'title'=>'پرونده قابل استناد',
            'kpis'=>array(array('منبع متصل','۱۲'),array('نسخه گزارش','۴'),array('نکته باز','۶')),
            'chart_title'=>'تکمیل شواهد و مستندات',
            'chart'=>array(22,38,41,55,63,69,81,90),
            'bars'=>array(array('منبع',90),array('فرضیات',82),array('توضیح‌پذیری',86)),
            'feed'=>array(array('منبع جدید','ثبت شد'),array('فرضیه مالی','نسخه ۲'),array('گزارش','آماده مرور')),
        ),
        'property-intelligence' => array(
            'eyebrow'=>'هوشمندی ملک',
            'title'=>'Property Intelligence',
            'kpis'=>array(array('کیفیت داده','۸۸٪'),array('لایه مکانی','۷'),array('ابهام','۳')),
            'chart_title'=>'تکمیل شناسنامه ملک',
            'chart'=>array(21,35,47,50,64,73,82,88),
            'bars'=>array(array('شناسه و سند',92),array('زمینه مکانی',84),array('داده توسعه',76)),
            'feed'=>array(array('موقعیت','تطبیق نمونه'),array('همجواری','۳ سیگنال'),array('کیفیت','قابل قبول')),
        ),
        'regulations' => array(
            'eyebrow'=>'هوشمندی ضوابط',
            'title'=>'Regulation Intelligence',
            'kpis'=>array(array('منبع مرتبط','۱۲'),array('قاعده نمونه','۸'),array('نیازمند تأیید','۴')),
            'chart_title'=>'پوشش منبع و اعتبار',
            'chart'=>array(30,40,42,55,58,71,78,85),
            'bars'=>array(array('ارتباط موضوعی',88),array('ردیابی منبع',92),array('تأیید کارشناسی',64)),
            'feed'=>array(array('طرح تفصیلی','منبع متصل'),array('قاعده جدید','پیشنهاد بررسی'),array('نسخه سند','ثبت شده')),
        ),
        'feasibility' => array(
            'eyebrow'=>'امکان‌سنجی',
            'title'=>'Scenario Workspace',
            'kpis'=>array(array('سناریو A','۷۸'),array('سناریو B','۸۴'),array('سناریو C','۶۹')),
            'chart_title'=>'مقایسه نمونه سناریوها',
            'chart'=>array(37,49,44,61,58,73,81,84),
            'bars'=>array(array('ظرفیت ساخت',84),array('هزینه نسبی',68),array('ریسک اجرا',57)),
            'feed'=>array(array('Baseline','ذخیره شد'),array('Variant B','بهترین امتیاز'),array('Stress test','۲ فرض حساس')),
        ),
        'financial-analysis' => array(
            'eyebrow'=>'تحلیل مالی',
            'title'=>'Financial Scenario',
            'kpis'=>array(array('هزینه نمونه','۳۸٫۴'),array('ارزش نمونه','۶۱٫۲'),array('سناریو','۳')),
            'chart_title'=>'روند نمونه جریان نقد',
            'chart'=>array(18,29,27,43,52,66,74,89),
            'bars'=>array(array('حاشیه سناریو',79),array('ریسک هزینه',61),array('اطمینان ورودی',73)),
            'feed'=>array(array('هزینه ساخت','فرض نمونه'),array('قیمت فروش','قابل تغییر'),array('حساسیت','نمایش فعال')),
        ),
        'ai-assistant' => array(
            'eyebrow'=>'دستیار هوشمند',
            'title'=>'SakhtYar AI',
            'kpis'=>array(array('منبع پاسخ','۴'),array('زمینه پرونده','متصل'),array('اطمینان نمونه','۸۷٪')),
            'chart_title'=>'کیفیت زمینه پاسخ',
            'chart'=>array(34,39,51,55,68,72,80,87),
            'bars'=>array(array('ارتباط پاسخ',90),array('پوشش منبع',82),array('شفافیت',86)),
            'feed'=>array(array('پرسش','ریسک اصلی چیست؟'),array('شاهد','۴ منبع نمونه'),array('پاسخ','با ارجاع آماده')),
        ),
        'builder-matching' => array(
            'eyebrow'=>'تطبیق سازنده',
            'title'=>'Builder Matching',
            'kpis'=>array(array('فهرست اولیه','۱۸'),array('Shortlist','۶'),array('بهترین تطبیق','۸۹٪')),
            'chart_title'=>'امتیاز تناسب گزینه‌های نمونه',
            'chart'=>array(43,57,52,64,69,74,82,89),
            'bars'=>array(array('نوع پروژه',91),array('موقعیت',84),array('سابقه مشابه',79)),
            'feed'=>array(array('گزینه ۱','۸۹٪ تطبیق'),array('گزینه ۲','۸۴٪ تطبیق'),array('گزینه ۳','۷۸٪ تطبیق')),
        ),
        'reports-documents' => array(
            'eyebrow'=>'گزارش و مستندات',
            'title'=>'Decision Report',
            'kpis'=>array(array('بخش گزارش','۱۲'),array('نسخه','۴'),array('مورد باز','۳')),
            'chart_title'=>'پیشرفت نمونه گزارش',
            'chart'=>array(17,25,39,46,58,67,79,91),
            'bars'=>array(array('منابع',92),array('سناریوها',86),array('جمع‌بندی',81)),
            'feed'=>array(array('فصل مالی','به‌روزرسانی شد'),array('ضمیمه قوانین','متصل'),array('خروجی PDF','نمونه آماده')),
        ),
        'monitoring-alerts' => array(
            'eyebrow'=>'پایش و هشدار',
            'title'=>'Monitoring Center',
            'kpis'=>array(array('هشدار مهم','۲'),array('تغییر نمونه','۷'),array('وضعیت','پایش')),
            'chart_title'=>'روند تغییرات ثبت‌شده',
            'chart'=>array(31,28,42,36,55,47,69,63),
            'bars'=>array(array('داده ملک',79),array('منابع قانونی',88),array('وضعیت پرونده',72)),
            'feed'=>array(array('ضابطه','تغییر نمونه'),array('پرونده','داده جدید'),array('سناریو','نیازمند بازبینی')),
        ),
        'docs' => array(
            'eyebrow'=>'مرکز راهنما',
            'title'=>'Knowledge & Docs',
            'kpis'=>array(array('مسیر راهنما','۶'),array('موضوع','۱۲'),array('نسخه','در حال تکمیل')),
            'chart_title'=>'پوشش نمونه مستندات',
            'chart'=>array(23,30,36,48,54,65,76,84),
            'bars'=>array(array('محصول',90),array('داده',78),array('یکپارچه‌سازی',64)),
            'feed'=>array(array('شروع سریع','منتشرشده'),array('راهنمای نقش','در حال تکمیل'),array('API','نقشه راه')),
        ),
        'academy' => array(
            'eyebrow'=>'آکادمی',
            'title'=>'Learning Paths',
            'kpis'=>array(array('مسیر آموزشی','۶'),array('چک‌لیست','۸'),array('سطح','کاربردی')),
            'chart_title'=>'پیشرفت نمونه مسیر یادگیری',
            'chart'=>array(14,27,33,45,52,63,75,88),
            'bars'=>array(array('حقوقی',72),array('فنی',81),array('اقتصادی',86)),
            'feed'=>array(array('مشارکت در ساخت','مسیر ۱'),array('اقتصاد پروژه','مسیر ۲'),array('هوش مصنوعی','مسیر ۳')),
        ),
        'case-studies' => array(
            'eyebrow'=>'نمونه مسئله',
            'title'=>'Case Study Board',
            'kpis'=>array(array('سناریو','۳'),array('منبع','نمونه'),array('خروجی','مقایسه')),
            'chart_title'=>'تغییر امتیاز پس از تکمیل داده',
            'chart'=>array(29,35,44,48,61,70,77,85),
            'bars'=>array(array('داده',85),array('ضابطه',76),array('اقتصاد',82)),
            'feed'=>array(array('ملک کلنگی','نمونه'),array('فرصت سازنده','نمونه'),array('سرمایه‌گذاری','نمونه')),
        ),
        'about' => array(
            'eyebrow'=>'معماری محصول',
            'title'=>'SakhtYar Platform',
            'kpis'=>array(array('لایه','داده'),array('هسته','تصمیم'),array('خروجی','اقدام')),
            'chart_title'=>'اتصال لایه‌های محصول',
            'chart'=>array(30,35,45,52,62,70,82,90),
            'bars'=>array(array('Data',88),array('Knowledge',82),array('AI',74)),
            'feed'=>array(array('وب‌سایت','لایه معرفی'),array('Application','لایه عملیاتی'),array('Backend','هسته سرویس')),
        ),
    );
}

function syf_showcase_for_slug($slug) {
    $catalog = syf_showcase_catalog();
    return isset($catalog[$slug]) ? $catalog[$slug] : $catalog['product'];
}

function syf_chart_points($values) {
    $values = array_values(array_map('floatval', $values));
    $count = count($values);
    if ($count < 2) return '0,120 420,60';
    $points = array();
    foreach ($values as $index=>$value) {
        $x = round(($index / ($count - 1)) * 420, 1);
        $v = max(0, min(100, $value));
        $y = round(144 - ($v * 1.18), 1);
        $points[] = $x . ',' . $y;
    }
    return implode(' ', $points);
}

function syf_render_demo_dashboard($slug, $variant='default') {
    $data = syf_showcase_for_slug($slug);
    $points = syf_chart_points($data['chart']);
    ?>
    <div class="syf-v42-dashboard syf-v42-dashboard--<?php echo esc_attr($variant); ?>" data-syf-reveal>
      <div class="syf-v42-dashboard__top">
        <div>
          <span class="syf-v42-dashboard__eyebrow"><?php echo esc_html($data['eyebrow']); ?></span>
          <strong><?php echo esc_html($data['title']); ?></strong>
        </div>
        <span class="syf-v42-demo-badge"><i></i> نمونه نمایشی</span>
      </div>

      <div class="syf-v42-kpis">
        <?php foreach ($data['kpis'] as $index=>$item) : ?>
          <div class="syf-v42-kpi syf-v42-kpi--<?php echo esc_attr($index+1); ?>">
            <small><?php echo esc_html($item[0]); ?></small>
            <strong><?php echo esc_html($item[1]); ?></strong>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="syf-v42-dashboard__grid">
        <div class="syf-v42-chart-card">
          <div class="syf-v42-card-head"><strong><?php echo esc_html($data['chart_title']); ?></strong><span>۸ گام نمونه</span></div>
          <svg class="syf-v42-line-chart" viewBox="0 0 420 150" role="img" aria-label="<?php echo esc_attr($data['chart_title']); ?>">
            <defs>
              <linearGradient id="syfV42Area-<?php echo esc_attr(md5($slug.$variant)); ?>" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#2563EB" stop-opacity=".22"/>
                <stop offset="100%" stop-color="#2563EB" stop-opacity="0"/>
              </linearGradient>
            </defs>
            <line x1="0" y1="35" x2="420" y2="35" class="grid"/>
            <line x1="0" y1="75" x2="420" y2="75" class="grid"/>
            <line x1="0" y1="115" x2="420" y2="115" class="grid"/>
            <polygon points="<?php echo esc_attr($points); ?> 420,145 0,145" fill="url(#syfV42Area-<?php echo esc_attr(md5($slug.$variant)); ?>)"/>
            <polyline points="<?php echo esc_attr($points); ?>" class="trend"/>
          </svg>
          <div class="syf-v42-chart-axis"><span>شروع</span><span>بررسی</span><span>مقایسه</span><span>تصمیم</span></div>
        </div>

        <div class="syf-v42-side-card">
          <div class="syf-v42-card-head"><strong>شاخص‌های نمونه</strong><span>قابل توضیح</span></div>
          <div class="syf-v42-bars">
            <?php foreach ($data['bars'] as $item) : ?>
              <div class="syf-v42-bar-row">
                <div><span><?php echo esc_html($item[0]); ?></span><b><?php echo esc_html($item[1]); ?>%</b></div>
                <i><em style="--syf-v:<?php echo esc_attr((int)$item[1]); ?>%"></em></i>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="syf-v42-ring-row">
            <div class="syf-v42-ring"><span>82</span><small>Score</small></div>
            <p>این امتیاز و نمودارها فقط برای نمایش تجربه محصول هستند و داده واقعی پروژه محسوب نمی‌شوند.</p>
          </div>
        </div>
      </div>

      <div class="syf-v42-feed">
        <?php foreach ($data['feed'] as $index=>$item) : ?>
          <div><span><?php echo esc_html(sprintf('%02d',$index+1)); ?></span><p><strong><?php echo esc_html($item[0]); ?></strong><small><?php echo esc_html($item[1]); ?></small></p></div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
}

function syf_product_phases() {
    return array(
        array('01','زیرساخت و تجربه کاربری','معماری پایه، نقش‌ها، RTL، Design System و اتصال وب به مسیر محصول.','پایه موجود','product'),
        array('02','پرونده ملک و GIS','شناسنامه ملک، موقعیت، نقشه، لایه‌های مکانی و کیفیت داده.','در حال توسعه','property-intelligence'),
        array('03','دانش و ضوابط','Knowledge Base، منابع معتبر، قواعد نسخه‌دار و بازیابی قابل استناد.','در حال توسعه','regulations'),
        array('04','امکان‌سنجی و سناریو','مقایسه مسیرهای توسعه، فرضیات، ظرفیت، محدودیت و Stress Test.','نقشه راه نزدیک','feasibility'),
        array('05','اقتصاد و مدل مشارکت','هزینه، ارزش، جریان نقد، سهم طرفین، حساسیت و مقایسه سناریوها.','نقشه راه نزدیک','financial-analysis'),
        array('06','هوش مصنوعی و Agentها','دستیار زمینه‌محور، تحلیل سند، توضیح خروجی و Agentهای تخصصی.','در حال توسعه','ai-assistant'),
        array('07','تطبیق سازنده و سرمایه','Shortlist، امتیاز تناسب، سابقه، ظرفیت و مقایسه گزینه‌ها.','در نقشه راه','builder-matching'),
        array('08','گزارش، مدارک و گردش‌کار','نسخه گزارش، مستندات، تاریخچه تصمیم، وظایف و همکاری تیمی.','در حال توسعه','reports-documents'),
        array('09','پایش و هشدار','رصد تغییر داده، ضابطه، وضعیت پرونده و سیگنال‌های اثرگذار بر تصمیم.','در نقشه راه','monitoring-alerts'),
        array('10','یکپارچه‌سازی و API','نقشه، داده بیرونی، سرویس‌های Backend، صادرات و اتصال به ابزارهای تخصصی.','در نقشه راه','docs'),
        array('11','تحلیل مدیریتی و عملیات','داشبوردهای مدیریتی، کیفیت داده، عملیات دانش و کنترل وضعیت سرویس‌ها.','در نقشه راه','features'),
        array('12','موبایل و انتشار عملیاتی','تجربه Mobile-first، همکاری میدانی، امنیت، مانیتورینگ و اتوماسیون انتشار.','در نقشه راه','product'),
    );
}

function syf_render_homepage_product_gallery() {
    ?>
    <section class="syf-section syf-v42-preview-section syf-section--white">
      <div class="syf-container">
        <div class="syf-section-head">
          <div><div class="syf-kicker">پیش‌نمایش محصول</div><h2>داشبوردهایی که قرار است تصمیم را قابل دیدن کنند</h2></div>
          <p>به‌جای معرفی متنی صرف، چند نمای نمونه از تجربه اپلیکیشن را ببینید. همه اعداد این بخش نمایشی هستند.</p>
        </div>
        <div class="syf-v42-preview-tabs" data-syf-preview-tabs>
          <div class="syf-v42-preview-tabs__nav" role="tablist" aria-label="پیش‌نمایش ماژول‌ها">
            <button type="button" class="is-active" data-syf-preview-tab="property">هوشمندی ملک</button>
            <button type="button" data-syf-preview-tab="regulations">ضوابط</button>
            <button type="button" data-syf-preview-tab="feasibility">سناریو</button>
            <button type="button" data-syf-preview-tab="financial">تحلیل مالی</button>
            <button type="button" data-syf-preview-tab="ai">دستیار هوشمند</button>
          </div>
          <div class="syf-v42-preview-panels">
            <div class="is-active" data-syf-preview-panel="property"><?php syf_render_demo_dashboard('property-intelligence','gallery'); ?></div>
            <div data-syf-preview-panel="regulations"><?php syf_render_demo_dashboard('regulations','gallery'); ?></div>
            <div data-syf-preview-panel="feasibility"><?php syf_render_demo_dashboard('feasibility','gallery'); ?></div>
            <div data-syf-preview-panel="financial"><?php syf_render_demo_dashboard('financial-analysis','gallery'); ?></div>
            <div data-syf-preview-panel="ai"><?php syf_render_demo_dashboard('ai-assistant','gallery'); ?></div>
          </div>
        </div>
      </div>
    </section>
    <?php
}

function syf_render_homepage_roadmap() {
    $phases = syf_product_phases();
    ?>
    <section class="syf-section syf-v42-roadmap-home syf-section--soft">
      <div class="syf-container">
        <div class="syf-section-head">
          <div><div class="syf-kicker">تصویر کامل محصول</div><h2>ساخت‌یار فقط یک ابزار نیست؛ یک مسیر چندفازی است</h2></div>
          <p>قابلیت‌های آماده، در حال توسعه و نقشه راه آینده در یک تصویر واحد معرفی می‌شوند تا مخاطب بداند محصول به کدام سمت می‌رود.</p>
        </div>
        <div class="syf-v42-phase-strip">
          <?php foreach (array_slice($phases,0,8) as $phase) : ?>
            <a href="<?php echo esc_url(home_url('/'.$phase[4].'/')); ?>" data-syf-reveal>
              <span><?php echo esc_html($phase[0]); ?></span>
              <small><?php echo esc_html($phase[3]); ?></small>
              <strong><?php echo esc_html($phase[1]); ?></strong>
              <p><?php echo esc_html($phase[2]); ?></p>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="syf-v42-roadmap-home__action"><a class="syf-btn syf-btn--outline" href="<?php echo esc_url(home_url('/roadmap/')); ?>">مشاهده نقشه راه کامل محصول</a></div>
      </div>
    </section>
    <?php
}

function syf_has_rich_page($slug) {
    if ($slug === 'roadmap') return true;
    if (function_exists('syf_has_module_page') && syf_has_module_page($slug)) return true;
    if (function_exists('syf_has_static_page') && syf_has_static_page($slug)) return true;
    return false;
}

function syf_render_rich_page($slug) {
    if ($slug === 'roadmap') {
        syf_render_roadmap_page();
        return;
    }
    if (function_exists('syf_has_module_page') && syf_has_module_page($slug)) {
        syf_render_rich_module_page($slug);
        return;
    }
    syf_render_rich_static_page($slug);
}

function syf_render_page_cards($cards) {
    if (empty($cards)) return;
    ?>
    <div class="syf-v42-card-grid">
      <?php foreach ($cards as $index=>$item) : ?>
        <article class="syf-v42-feature-card" data-syf-reveal>
          <span class="syf-v42-feature-card__icon"><?php echo esc_html(sprintf('%02d',$index+1)); ?></span>
          <div>
            <h3><?php echo esc_html($item[0]); ?></h3>
            <p><?php echo esc_html($item[1]); ?></p>
          </div>
          <i>←</i>
        </article>
      <?php endforeach; ?>
    </div>
    <?php
}

function syf_render_rich_form_section($page, $slug) {
    $is_demo = isset($page['form']) && $page['form'] === 'demo';
    $visual = get_template_directory_uri() . '/assets/images/react/form-showcase.jpg';
    ?>
    <section class="syf-section syf-section--soft">
      <div class="syf-container">
        <div class="syf-v42-form-shell">
          <div class="syf-v42-form-visual" style="background-image:url('<?php echo esc_url($visual); ?>')">
            <div class="syf-v42-form-visual__shade"></div>
            <div class="syf-v42-form-visual__copy">
              <span>ساخت‌یار / شروع گفتگو</span>
              <h2><?php echo $is_demo ? 'مسئله شما، نقطه شروع دموی محصول' : 'یک مسیر روشن برای شروع همکاری'; ?></h2>
              <p><?php echo $is_demo ? 'نقش، نوع ملک و مهم‌ترین تصمیمی که پیش رو دارید را بگویید تا مسیر دمو حول همان مسئله شکل بگیرد.' : 'موضوع همکاری یا مسئله خود را کوتاه توضیح دهید؛ فرم فعلی نمایشی است و اتصال واقعی در فاز Backend/CRM فعال می‌شود.'; ?></p>
            </div>
            <div class="syf-v42-form-mini">
              <div><small>مرحله ۱</small><strong>شناخت مسئله</strong></div>
              <div><small>مرحله ۲</small><strong>انتخاب ماژول</strong></div>
              <div><small>مرحله ۳</small><strong>نمایش مسیر تصمیم</strong></div>
            </div>
          </div>
          <div class="syf-v42-form-card">
            <div class="syf-kicker"><?php echo $is_demo ? 'درخواست دمو' : 'تماس با ما'; ?></div>
            <h2><?php echo $is_demo ? 'برای شروع چند نکته را بگویید' : 'پیام شما'; ?></h2>
            <p>این فرم در نسخه فعلی اطلاعاتی ارسال یا ذخیره نمی‌کند.</p>
            <form class="syf-static-form syf-v42-static-form" data-syf-static-form>
              <label>نام و نام خانوادگی<input type="text" name="name" placeholder="نام شما"></label>
              <label>شماره تماس یا ایمیل<input type="text" name="contact" placeholder="راه ارتباطی"></label>
              <label>نقش شما<select name="role"><option>مالک</option><option>سازنده</option><option>سرمایه‌گذار</option><option>مشاور / کارشناس</option><option>همکاری تجاری / فنی</option></select></label>
              <label>موضوع<select name="topic"><option>تحلیل ملک</option><option>ضوابط و قوانین</option><option>امکان‌سنجی</option><option>تحلیل مالی</option><option>دستیار هوشمند</option><option>نمای کامل پلتفرم</option></select></label>
              <label class="syf-form-wide">توضیح کوتاه<textarea name="message" rows="5" placeholder="در چند خط بگویید چه مسئله‌ای دارید"></textarea></label>
              <div class="syf-form-wide syf-form-actions"><button class="syf-btn syf-btn--primary" type="submit">ثبت درخواست نمایشی</button><span data-syf-form-message></span></div>
            </form>
            <div class="syf-v42-form-note">اتصال واقعی فرم و CRM در فاز Backend فعال می‌شود.</div>
          </div>
        </div>
      </div>
    </section>
    <?php
}

function syf_render_rich_static_page($slug) {
    $pages = function_exists('syf_static_pages') ? syf_static_pages() : array();
    if (!isset($pages[$slug])) return;
    $page = $pages[$slug];
    ?>
    <main class="syf-static-page syf-v42-page">
      <section class="syf-v42-page-hero">
        <div class="syf-container syf-v42-page-hero__grid">
          <div class="syf-v42-page-hero__copy">
            <div class="syf-kicker"><?php echo esc_html($page['kicker']); ?></div>
            <h1><?php echo esc_html($page['title']); ?></h1>
            <p><?php echo esc_html($page['lead']); ?></p>
            <div class="syf-static-actions">
              <?php if (!in_array($slug,array('contact','request-demo'),true)) : ?><a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><?php endif; ?>
              <a class="syf-btn syf-btn--outline" href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه محصول</a>
            </div>
          </div>
          <div class="syf-v42-page-hero__dashboard"><?php syf_render_demo_dashboard($slug,'hero'); ?></div>
        </div>
      </section>

      <?php if (!empty($page['cards'])) : ?>
      <section class="syf-section syf-section--white">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">اجزای اصلی</div><h2>این بخش دقیقاً چه چیزی ارائه می‌کند؟</h2></div><p>قابلیت‌ها با همان زبان بصری اپلیکیشن نمایش داده می‌شوند تا معرفی سایت از تجربه محصول جدا نباشد.</p></div>
          <?php syf_render_page_cards($page['cards']); ?>
        </div>
      </section>
      <?php endif; ?>

      <?php if (!empty($page['steps'])) : ?>
      <section class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">گردش کار</div><h2>از ورودی تا خروجی، مرحله‌به‌مرحله</h2></div><p>هر گام، ورودی و خروجی مشخص دارد و در نسخه عملیاتی به سرویس‌های هسته محصول متصل می‌شود.</p></div>
          <div class="syf-v42-steps">
            <?php foreach ($page['steps'] as $index=>$step) : ?>
              <article data-syf-reveal><span><?php echo esc_html(sprintf('%02d',$index+1)); ?></span><div><h3><?php echo esc_html($step); ?></h3><p>داده و تصمیم این مرحله در پرونده پروژه ثبت می‌شود تا مسیر قابل پیگیری بماند.</p></div></article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php if (!empty($page['bullets'])) : ?>
      <section class="syf-section syf-section--white">
        <div class="syf-container syf-v42-principles">
          <div><div class="syf-kicker">اصل طراحی</div><h2>ظاهر زیبا کافی نیست؛ خروجی باید قابل اعتماد و توضیح‌پذیر باشد</h2><p>در ساخت‌یار فرضیات، کیفیت داده، منبع و موارد نیازمند بررسی در خود تجربه کاربری دیده می‌شوند.</p></div>
          <div class="syf-v42-principles__list">
            <?php foreach ($page['bullets'] as $bullet) : ?><div><span>✓</span><p><?php echo esc_html($bullet); ?></p></div><?php endforeach; ?>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php if (!empty($page['faq'])) : ?>
      <section class="syf-section syf-section--white"><div class="syf-container syf-narrow"><div class="syf-section-head"><div><div class="syf-kicker">پرسش‌های متداول</div><h2>پاسخ کوتاه به سؤال‌های رایج</h2></div></div><div class="syf-faq-list">
        <?php foreach ($page['faq'] as $index=>$item) : ?><details class="syf-faq"<?php echo $index===0?' open':''; ?>><summary><?php echo esc_html($item[0]); ?><span><?php echo $index===0?'−':'+'; ?></span></summary><div><?php echo esc_html($item[1]); ?></div></details><?php endforeach; ?>
      </div></div></section>
      <?php endif; ?>

      <?php if (!empty($page['form'])) : syf_render_rich_form_section($page,$slug); endif; ?>

      <?php if (empty($page['form']) && $slug !== 'privacy') : ?>
      <section class="syf-section syf-section--soft"><div class="syf-container"><div class="syf-cta syf-react-cta">
        <div><h2>این بخش را در جریان واقعی محصول ببینید</h2><p>دموی ساخت‌یار بر اساس نقش، نوع پروژه و تصمیم شما تنظیم می‌شود.</p></div>
        <div class="syf-cta__actions"><a class="syf-btn syf-btn--light" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><a class="syf-btn syf-btn--ghost" href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه</a></div>
      </div></div></section>
      <?php endif; ?>
    </main>
    <?php
}

function syf_render_rich_module_page($slug) {
    $pages = function_exists('syf_module_pages') ? syf_module_pages() : array();
    if (!isset($pages[$slug])) return;
    $page = $pages[$slug];
    ?>
    <main class="syf-module-page syf-v42-module-page">
      <section class="syf-v42-module-hero">
        <div class="syf-container syf-v42-module-hero__grid">
          <div class="syf-v42-module-hero__copy">
            <div class="syf-kicker"><?php echo esc_html($page['kicker']); ?></div>
            <h1><?php echo esc_html($page['title']); ?></h1>
            <p><?php echo esc_html($page['lead']); ?></p>
            <div class="syf-module-hero__actions">
              <a class="syf-btn syf-btn--primary" href="#how-it-works">چطور کار می‌کند؟</a>
              <a class="syf-btn syf-btn--outline" href="#dashboard-preview">نمونه داشبورد</a>
            </div>
            <div class="syf-module-audience"><span>مناسب برای:</span><?php foreach ($page['audiences'] as $audience) : ?><b><?php echo esc_html($audience); ?></b><?php endforeach; ?></div>
          </div>
          <div id="dashboard-preview"><?php syf_render_demo_dashboard($slug,'module'); ?></div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container syf-module-purpose syf-v42-module-purpose">
          <div><div class="syf-kicker">به چه کاری می‌آید؟</div><h2>هدف این ماژول</h2></div>
          <p><?php echo esc_html($page['purpose']); ?></p>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">داخل اپلیکیشن</div><h2>یک صفحه فقط برای نمایش عدد نیست</h2></div><p>داشبورد باید وضعیت، روند، ریسک، داده و اقدام بعدی را در یک نگاه کنار هم قرار دهد.</p></div>
          <div class="syf-v42-analytics-grid">
            <article><span>01</span><h3>خلاصه تصمیم</h3><p>شاخص‌های کلیدی و موارد نیازمند توجه، بدون پنهان کردن جزئیات پشت یک Score.</p></article>
            <article><span>02</span><h3>نمودار و روند</h3><p>مقایسه سناریو یا تغییر وضعیت در زمان، به‌جای نمایش فهرست‌های خشک و طولانی.</p></article>
            <article><span>03</span><h3>اقدام بعدی</h3><p>هر نتیجه به مرحله بعد، منبع، سند یا کار لازم در پرونده متصل می‌شود.</p></article>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">اجزای داخلی</div><h2>چه بخش‌هایی دارد؟</h2></div><p>هر قابلیت برای حل یک بخش مشخص از مسئله طراحی شده و خروجی آن در مراحل بعدی قابل استفاده است.</p></div>
          <div class="syf-module-capability-grid">
            <?php foreach ($page['capabilities'] as $index=>$item) : ?>
              <article class="syf-module-capability syf-v42-module-capability" data-syf-reveal><span><?php echo esc_html(sprintf('%02d',$index+1)); ?></span><h3><?php echo esc_html($item[0]); ?></h3><p><?php echo esc_html($item[1]); ?></p></article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="how-it-works" class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">گردش کار</div><h2>چطور کار می‌کند؟</h2></div><p>منطق کلی ماژول از دریافت ورودی تا ساخت خروجی و انتقال به مرحله بعد.</p></div>
          <div class="syf-module-workflow syf-v42-module-workflow">
            <?php foreach ($page['workflow'] as $index=>$item) : ?><article data-syf-reveal><span><?php echo esc_html($index+1); ?></span><div><h3><?php echo esc_html($item[0]); ?></h3><p><?php echo esc_html($item[1]); ?></p></div></article><?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container syf-module-io-grid">
          <article><div class="syf-kicker">ورودی‌ها</div><h2>چه چیزهایی لازم است؟</h2><div class="syf-module-list"><?php foreach ($page['inputs'] as $item) : ?><div><span>→</span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?></div></article>
          <article><div class="syf-kicker">خروجی‌ها</div><h2>چه چیزی تحویل می‌گیرید؟</h2><div class="syf-module-list syf-module-list--success"><?php foreach ($page['outputs'] as $item) : ?><div><span>✓</span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?></div></article>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container syf-module-guide">
          <div><div class="syf-kicker">راهنمای استفاده</div><h2>قبل از تفسیر خروجی</h2><p>داده نمونه و UI نمایشی جایگزین بررسی فنی، حقوقی یا مالی نیست؛ هدف، نمایش تجربه و منطق محصول است.</p></div>
          <div class="syf-module-guide__items"><?php foreach ($page['guidance'] as $index=>$item) : ?><div><span><?php echo esc_html($index+1); ?></span><p><?php echo esc_html($item); ?></p></div><?php endforeach; ?></div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">ادامه مسیر</div><h2>ماژول‌های دیگر ساخت‌یار</h2></div><a class="syf-link" href="<?php echo esc_url(home_url('/#decision-modules')); ?>">همه ماژول‌ها ←</a></div>
          <div class="syf-module-nav-grid">
            <?php $count=0; foreach ($pages as $other_slug=>$other) : if ($other_slug===$slug) continue; ?>
              <a href="<?php echo esc_url(home_url('/'.$other_slug.'/')); ?>"><small><?php echo esc_html($other['kicker']); ?></small><strong><?php echo esc_html($other['title']); ?></strong><span>←</span></a>
            <?php $count++; if ($count===4) break; endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--soft"><div class="syf-container"><div class="syf-cta syf-react-cta">
        <div><h2>این ماژول را در جریان کامل محصول ببینید</h2><p>دموی ساخت‌یار بر اساس نقش و مسئله واقعی شما تنظیم می‌شود.</p></div>
        <div class="syf-cta__actions"><a class="syf-btn syf-btn--light" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><a class="syf-btn syf-btn--ghost" href="<?php echo esc_url(home_url('/roadmap/')); ?>">نقشه راه محصول</a></div>
      </div></div></section>
    </main>
    <?php
}

function syf_render_roadmap_page() {
    $phases = syf_product_phases();
    ?>
    <main class="syf-v42-roadmap-page">
      <section class="syf-v42-roadmap-hero">
        <div class="syf-container syf-v42-roadmap-hero__grid">
          <div>
            <div class="syf-kicker">نقشه راه SakhtYar</div>
            <h1>از داده ملک تا تصمیم، همکاری و عملیات پروژه</h1>
            <p>این صفحه تصویر محصول هدف را نشان می‌دهد؛ بخشی از قابلیت‌ها زیرساخت یا نمونه UI دارند، بخشی در حال توسعه‌اند و بخشی در نقشه راه قرار دارند.</p>
            <div class="syf-static-actions"><a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/request-demo/')); ?>">درخواست دمو</a><a class="syf-btn syf-btn--outline" href="<?php echo esc_url(home_url('/product/')); ?>">معرفی پلتفرم</a></div>
          </div>
          <div><?php syf_render_demo_dashboard('features','roadmap'); ?></div>
        </div>
      </section>

      <section class="syf-section syf-section--white">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">۱۲ مسیر محصول</div><h2>قابلیت‌هایی که در کنار هم ساخت‌یار را کامل می‌کنند</h2></div><p>وضعیت‌ها برای معرفی مسیر توسعه‌اند و به‌معنای تعهد زمانی انتشار نیستند.</p></div>
          <div class="syf-v42-roadmap-grid">
            <?php foreach ($phases as $phase) : ?>
              <a href="<?php echo esc_url(home_url('/'.$phase[4].'/')); ?>" data-syf-reveal>
                <div class="syf-v42-roadmap-grid__top"><span><?php echo esc_html($phase[0]); ?></span><small><?php echo esc_html($phase[3]); ?></small></div>
                <h3><?php echo esc_html($phase[1]); ?></h3>
                <p><?php echo esc_html($phase[2]); ?></p>
                <b>مشاهده بخش مرتبط ←</b>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="syf-section syf-section--soft">
        <div class="syf-container">
          <div class="syf-section-head"><div><div class="syf-kicker">معماری تجربه</div><h2>چهار لایه که باید به هم متصل بمانند</h2></div></div>
          <div class="syf-v42-layer-grid">
            <article><span>01</span><h3>داده و منبع</h3><p>ملک، GIS، اسناد، قوانین، بازار و داده‌های عملیاتی.</p></article>
            <article><span>02</span><h3>تحلیل و مدل</h3><p>قواعد، سناریو، مدل مالی، امتیازها و موتورهای تصمیم.</p></article>
            <article><span>03</span><h3>هوش و Agent</h3><p>پرسش، توضیح، جمع‌بندی، پایش و Agentهای تخصصی.</p></article>
            <article><span>04</span><h3>تجربه و اقدام</h3><p>داشبورد، گزارش، همکاری، Matching و ادامه عملیات پروژه.</p></article>
          </div>
        </div>
      </section>
    </main>
    <?php
}
