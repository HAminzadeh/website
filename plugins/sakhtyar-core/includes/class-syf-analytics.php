<?php
if (!defined('ABSPATH')) { exit; }

final class SYF_Core_Analytics {
    public static function boot(): void {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
        add_shortcode('sakhtyar_analytics', [__CLASS__, 'shortcode']);
    }

    public static function register_routes(): void {
        register_rest_route('sakhtyar/v1', '/analytics/market', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [__CLASS__, 'rest_market'],
            'permission_callback' => static function (): bool {
                return current_user_can('syf_view_analytics');
            },
            'args' => [
                'region' => ['sanitize_callback' => 'sanitize_text_field', 'default' => '6'],
                'period' => ['sanitize_callback' => 'sanitize_key', 'default' => '30d'],
            ],
        ]);
    }

    public static function rest_market(WP_REST_Request $request): WP_REST_Response {
        $region = (string)$request->get_param('region');
        $period = (string)$request->get_param('period');

        $live = self::fetch_live($region, $period);
        if (is_array($live)) {
            $live['source'] = 'live';
            return new WP_REST_Response($live, 200);
        }

        if (
            defined('WP_DEBUG') && WP_DEBUG &&
            defined('SAKHTYAR_ENABLE_DEMO_ANALYTICS') &&
            SAKHTYAR_ENABLE_DEMO_ANALYTICS
        ) {
            $demo = self::demo_payload($region, $period);
            $demo['source'] = 'demo';
            return new WP_REST_Response($demo, 200);
        }

        return new WP_REST_Response([
            'source' => 'unavailable',
            'code' => 'analytics_unavailable',
            'message' => 'اطلاعات زنده در دسترس نیست.'
        ], 503);
    }

    private static function fetch_live(string $region, string $period): ?array {
        $path = (string) get_option(
            'syf_backend_analytics_path',
            '/api/v1/analytics/market'
        );

        $result = SYF_Core_Backend::request(
            'GET',
            $path,
            null,
            [
                'region' => $region,
                'period' => $period
            ]
        );

        if (is_wp_error($result) || !is_array($result)) {
            return null;
        }

        if (
            !isset(
                $result['metrics'],
                $result['price_series'],
                $result['segments'],
                $result['signals']
            )
        ) {
            return null;
        }

        return $result;
    }

    private static function demo_payload(string $region, string $period): array {
        $region_num = max(1, min(22, (int)$region));
        $offset = ($region_num % 7) - 3;
        $labels = $period === '7d'
            ? ['ش','ی','د','س','چ','پ','ج']
            : ($period === '90d'
                ? ['هفته ۱','هفته ۳','هفته ۵','هفته ۷','هفته ۹','هفته ۱۱','هفته ۱۳']
                : ['هفته ۱','هفته ۲','هفته ۳','هفته ۴','امروز']);

        $base = 100 + $offset;
        $series = [];
        foreach ($labels as $i=>$label) {
            $series[] = [
                'label' => $label,
                'value' => round($base + ($i * 1.8) + (($i % 2) ? 0.7 : -0.3), 1),
            ];
        }

        return [
            'region' => 'منطقه ' . $region_num,
            'period' => $period,
            'updated_at' => current_time('mysql'),
            'metrics' => [
                ['label' => 'شاخص قیمت پیشنهادی', 'value' => number_format_i18n(108.4 + $offset, 1), 'delta' => '+۲٫۸٪'],
                ['label' => 'شتاب تغییر ماهانه', 'value' => number_format_i18n(2.3 + ($offset/10), 1) . '٪', 'delta' => 'روند نمونه'],
                ['label' => 'فعالیت فایل‌های بازار', 'value' => number_format_i18n(71 + $region_num), 'delta' => '+۶٪'],
                ['label' => 'تازگی داده خزنده', 'value' => '۹۶٪', 'delta' => 'روزانه/هفتگی'],
            ],
            'price_series' => $series,
            'segments' => [
                ['label' => 'نوساز', 'value' => 82],
                ['label' => 'میان‌سال', 'value' => 64],
                ['label' => 'کلنگی', 'value' => 73],
            ],
            'signals' => [
                ['title' => 'فشار قیمت', 'state' => 'صعودی ملایم', 'level' => 'medium'],
                ['title' => 'سرعت عرضه', 'state' => 'باثبات', 'level' => 'low'],
                ['title' => 'ریسک داده', 'state' => 'نیازمند پایش', 'level' => 'medium'],
            ],
            'note' => 'این داده‌ها تا زمان اتصال Backend صرفاً برای نمایش رابط کاربری هستند.',
        ];
    }

    public static function shortcode(): string {
        if (!is_user_logged_in()) {
            return self::gate('برای مشاهده تحلیل‌های منطقه‌ای ابتدا وارد حساب شوید.', false);
        }
        if (!current_user_can('syf_view_analytics')) {
            return self::gate('دسترسی تحلیل بازار برای حساب شما فعال نیست. مدیر سامانه می‌تواند سطح دسترسی را ارتقا دهد.', true);
        }

        ob_start();
        ?>
        <div class="syf-core-analytics" data-syf-analytics>
          <div class="syf-core-analytics__toolbar">
            <div>
              <span class="syf-kicker">تحلیل داده‌محور بازار</span>
              <h2>رصد منطقه، روند قیمت و سیگنال‌های بازار</h2>
              <p>داده زنده در نسخه عملیاتی از Backend و خروجی خزنده‌ها خوانده می‌شود؛ در حالت بدون اتصال، داده نمایشی با برچسب مشخص نشان داده می‌شود.</p>
            </div>
            <div class="syf-core-analytics__controls">
              <label>منطقه<select data-syf-region><?php for ($i=1;$i<=22;$i++) : ?><option value="<?php echo esc_attr((string)$i); ?>"<?php selected($i,6); ?>>منطقه <?php echo esc_html((string)$i); ?></option><?php endfor; ?></select></label>
              <label>بازه<select data-syf-period><option value="7d">۷ روز</option><option value="30d" selected>۳۰ روز</option><option value="90d">۹۰ روز</option></select></label>
            </div>
          </div>

          <div class="syf-core-source-state"><span data-syf-source-dot></span><strong data-syf-source>در حال دریافت داده…</strong><small data-syf-updated></small></div>

          <div class="syf-core-analytics__kpis" data-syf-kpis></div>

          <div class="syf-core-analytics__main">
            <section class="syf-core-chart-card">
              <div class="syf-core-card-head"><div><small>روند</small><h3>شاخص تغییر قیمت پیشنهادی</h3></div><span>نمونه تحلیلی</span></div>
              <svg viewBox="0 0 640 230" class="syf-core-market-chart" aria-label="نمودار روند بازار">
                <g class="syf-core-chart-grid">
                  <line x1="20" y1="40" x2="620" y2="40"></line>
                  <line x1="20" y1="100" x2="620" y2="100"></line>
                  <line x1="20" y1="160" x2="620" y2="160"></line>
                </g>
                <polygon data-syf-chart-area></polygon>
                <polyline data-syf-chart-line></polyline>
              </svg>
              <div class="syf-core-chart-labels" data-syf-chart-labels></div>
            </section>

            <section class="syf-core-segment-card">
              <div class="syf-core-card-head"><div><small>تفکیک بازار</small><h3>مقایسه نوع ملک</h3></div></div>
              <div class="syf-core-segments" data-syf-segments></div>
            </section>
          </div>

          <div class="syf-core-signal-grid" data-syf-signals></div>
          <div class="syf-core-analytics-note" data-syf-note></div>
        </div>
        <?php
        return (string)ob_get_clean();
    }

    private static function gate(string $message, bool $upgrade): string {
        $button = $upgrade
            ? '<a class="syf-btn syf-btn--outline" href="' . esc_url(home_url('/account/')) . '">مشاهده سطح دسترسی</a>'
            : '<a class="syf-btn syf-btn--primary" href="' . esc_url(home_url('/account/?next=' . rawurlencode(home_url('/market-analytics/')))) . '">ورود / ساخت حساب</a>';

        return '<div class="syf-core-content-gate"><span class="syf-core-content-gate__icon">📊</span><h2>تحلیل بازار ساخت‌یار</h2><p>' . esc_html($message) . '</p><div class="syf-core-content-gate__actions">' . $button . '</div></div>';
    }

    public static function render_home_promo(): void {
        ?>
        <section class="syf-section syf-core-analytics-promo syf-section--soft">
          <div class="syf-container syf-core-analytics-promo__grid">
            <div>
              <div class="syf-kicker">تحلیل منطقه‌ای</div>
              <h2>از داده خزنده تا سیگنال قابل استفاده برای تصمیم</h2>
              <p>در نسخه عملیاتی، داده‌های جمع‌آوری‌شده روزانه یا هفتگی از Backend به شاخص‌های روند قیمت، فعالیت بازار، تازگی داده و سیگنال‌های منطقه تبدیل می‌شوند.</p>
              <div class="syf-core-analytics-promo__chips"><span>روند قیمت</span><span>مقایسه منطقه</span><span>تازگی داده</span><span>هشدار تغییر</span></div>
              <a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/market-analytics/')); ?>">مشاهده تحلیل بازار</a>
            </div>
            <div class="syf-core-analytics-promo__visual">
              <div class="syf-core-mini-kpis"><span><small>روند نمونه</small><strong>+۲٫۸٪</strong></span><span><small>تازگی داده</small><strong>۹۶٪</strong></span><span><small>سیگنال</small><strong>ملایم ↑</strong></span></div>
              <svg viewBox="0 0 520 200" aria-hidden="true"><polygon points="10,180 10,150 80,142 150,130 220,136 290,108 360,91 430,72 510,50 510,180"></polygon><polyline points="10,150 80,142 150,130 220,136 290,108 360,91 430,72 510,50"></polyline></svg>
            </div>
          </div>
        </section>
        <?php
    }
}
