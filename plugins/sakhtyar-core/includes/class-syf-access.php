<?php
if (!defined('ABSPATH')) { exit; }

final class SYF_Core_Access {
    private const ROLE_MEMBER  = 'syf_member';
    private const ROLE_ANALYST = 'syf_analyst';
    private const ROLE_ADVISOR = 'syf_advisor';

    public static function boot(): void {
        add_action('init', [__CLASS__, 'install_or_upgrade'], 5);
        add_action('init', [__CLASS__, 'handle_front_actions'], 20);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_filter('the_content', [__CLASS__, 'protect_article_content'], 20);
        add_shortcode('sakhtyar_account', [__CLASS__, 'account_shortcode']);
    }

    public static function install_or_upgrade(bool $force = false): void {
        $installed = (string)get_option('syf_core_db_version', '');
        if (!$force && $installed === SYF_CORE_DB_VERSION) {
            return;
        }

        self::register_roles();
        self::ensure_page('حساب کاربری', 'account', '[sakhtyar_account]');
        self::ensure_page('تحلیل بازار و منطقه', 'market-analytics', '[sakhtyar_analytics]');

        update_option('syf_core_db_version', SYF_CORE_DB_VERSION, false);
    }

    private static function register_roles(): void {
        add_role(self::ROLE_MEMBER, 'کاربر ساخت‌یار', [
            'read'                    => true,
            'syf_view_articles'       => true,
            'syf_view_module_details' => true,
        ]);

        add_role(self::ROLE_ANALYST, 'کاربر تحلیل‌گر ساخت‌یار', [
            'read'                    => true,
            'syf_view_articles'       => true,
            'syf_view_module_details' => true,
            'syf_view_analytics'      => true,
        ]);

        add_role(self::ROLE_ADVISOR, 'کارشناس ساخت‌یار', [
            'read'                    => true,
            'syf_view_articles'       => true,
            'syf_view_module_details' => true,
            'syf_view_analytics'      => true,
            'syf_view_professional'   => true,
        ]);

        $admin = get_role('administrator');
        if ($admin) {
            foreach ([
                'syf_view_articles',
                'syf_view_module_details',
                'syf_view_analytics',
                'syf_view_professional',
                'syf_manage_access',
                'syf_export_packages',
            ] as $cap) {
                $admin->add_cap($cap, true);
            }
        }
    }

    private static function ensure_page(string $title, string $slug, string $content): int {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing) {
            if (trim((string)$existing->post_content) === '') {
                wp_update_post(['ID' => $existing->ID, 'post_content' => $content]);
            }
            return (int)$existing->ID;
        }

        $id = wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $content,
        ], true);

        return is_wp_error($id) ? 0 : (int)$id;
    }

    public static function enqueue_assets(): void {
        wp_enqueue_style('sakhtyar-core', SYF_CORE_URL . 'assets/core.css', [], SYF_CORE_VERSION);
        wp_enqueue_script('sakhtyar-core', SYF_CORE_URL . 'assets/core.js', [], SYF_CORE_VERSION, true);

        wp_localize_script('sakhtyar-core', 'SYF_CORE', [
            'loggedIn'        => is_user_logged_in(),
            'canArticles'      => current_user_can('syf_view_articles'),
            'canModuleDetails' => current_user_can('syf_view_module_details'),
            'canAnalytics'     => current_user_can('syf_view_analytics'),
            'accountUrl'       => home_url('/account/'),
            'analyticsUrl'     => home_url('/market-analytics/'),
            'restUrl'          => esc_url_raw(rest_url('sakhtyar/v1/analytics/market')),
            'restNonce'        => wp_create_nonce('wp_rest'),
        ]);
    }

    public static function protect_article_content(string $content): string {
        if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
            return $content;
        }
        if (current_user_can('syf_view_articles')) {
            return $content;
        }

        $next = get_permalink();
        $account = add_query_arg('next', rawurlencode($next), home_url('/account/'));

        return '<div class="syf-core-content-gate">' .
            '<span class="syf-core-content-gate__icon">🔐</span>' .
            '<h2>برای مطالعه کامل، حساب ساخت‌یار لازم است</h2>' .
            '<p>ساخت حساب رایگان است. بعد از ورود می‌توانید مقاله کامل، جزئیات ماژول‌ها و فلوچارت‌های تعاملی را ببینید.</p>' .
            '<div class="syf-core-content-gate__actions">' .
            '<a class="syf-btn syf-btn--primary" href="' . esc_url($account) . '">ساخت حساب / ورود</a>' .
            '<a class="syf-btn syf-btn--outline" href="' . esc_url(home_url('/blog/')) . '">بازگشت به مقالات</a>' .
            '</div></div>';
    }

    public static function handle_front_actions(): void {
        if (empty($_POST['syf_core_action'])) {
            return;
        }

        $action = sanitize_key(wp_unslash($_POST['syf_core_action']));
        $next = isset($_POST['next']) ? wp_unslash($_POST['next']) : '';
        $next = wp_validate_redirect($next, home_url('/account/'));

        if ($action === 'register') {
            self::handle_register($next);
        } elseif ($action === 'login') {
            self::handle_login($next);
        }
    }

    private static function handle_register(string $next): void {
        if (!isset($_POST['_syf_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_syf_nonce'])), 'syf_register')) {
            self::redirect_notice('invalid_request');
        }

        $name = isset($_POST['display_name']) ? sanitize_text_field(wp_unslash($_POST['display_name'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $password = isset($_POST['password']) ? (string)wp_unslash($_POST['password']) : '';

        if ($name === '' || !is_email($email) || strlen($password) < 8) {
            self::redirect_notice('register_fields');
        }
        if (email_exists($email)) {
            self::redirect_notice('email_exists');
        }

        $base = sanitize_user(strstr($email, '@', true), true);
        if ($base === '') $base = 'user';
        $username = $base;
        $i = 1;
        while (username_exists($username)) {
            $username = $base . $i;
            $i++;
        }

        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            self::redirect_notice('register_failed');
        }

        $user = new WP_User($user_id);
        $user->set_role(self::ROLE_MEMBER);
        wp_update_user(['ID' => $user_id, 'display_name' => $name, 'nickname' => $name]);

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, is_ssl());

        wp_safe_redirect($next ?: home_url('/account/?syf_notice=registered'));
        exit;
    }

    private static function handle_login(string $next): void {
        if (!isset($_POST['_syf_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_syf_nonce'])), 'syf_login')) {
            self::redirect_notice('invalid_request');
        }

        $login = isset($_POST['login']) ? sanitize_text_field(wp_unslash($_POST['login'])) : '';
        $password = isset($_POST['password']) ? (string)wp_unslash($_POST['password']) : '';

        if (is_email($login)) {
            $user = get_user_by('email', $login);
            if ($user) $login = $user->user_login;
        }

        $result = wp_signon([
            'user_login'    => $login,
            'user_password' => $password,
            'remember'      => true,
        ], is_ssl());

        if (is_wp_error($result)) {
            self::redirect_notice('login_failed');
        }

        wp_safe_redirect($next ?: home_url('/account/?syf_notice=logged_in'));
        exit;
    }

    private static function redirect_notice(string $code): void {
        wp_safe_redirect(add_query_arg('syf_notice', $code, home_url('/account/')));
        exit;
    }

    public static function account_shortcode(): string {
        $notice = isset($_GET['syf_notice']) ? sanitize_key(wp_unslash($_GET['syf_notice'])) : '';
        $next = isset($_GET['next']) ? rawurldecode((string)wp_unslash($_GET['next'])) : '';
        $next = wp_validate_redirect($next, home_url('/account/'));

        ob_start();
        ?>
        <div class="syf-core-account-shell">
          <?php if (is_user_logged_in()) :
              $user = wp_get_current_user();
              $role_labels = [
                  self::ROLE_MEMBER  => 'کاربر پایه',
                  self::ROLE_ANALYST => 'تحلیل‌گر',
                  self::ROLE_ADVISOR => 'کارشناس',
                  'administrator'     => 'مدیر سیستم',
              ];
              $role = $user->roles[0] ?? 'subscriber';
              $label = $role_labels[$role] ?? 'کاربر';
          ?>
            <section class="syf-core-account-card syf-core-account-card--profile">
              <div>
                <span class="syf-kicker">حساب ساخت‌یار</span>
                <h2><?php echo esc_html($user->display_name ?: $user->user_login); ?></h2>
                <p><?php echo esc_html($user->user_email); ?></p>
              </div>
              <span class="syf-core-role-badge"><?php echo esc_html($label); ?></span>
            </section>

            <div class="syf-core-access-grid">
              <?php
              $access_items = [
                  ['مقالات تخصصی', 'syf_view_articles', 'مطالعه کامل محتوای دانش ساخت'],
                  ['جزئیات و فلوچارت ماژول‌ها', 'syf_view_module_details', 'دسترسی به جزئیات تعاملی جریان‌ها'],
                  ['تحلیل بازار و منطقه', 'syf_view_analytics', 'داشبوردهای تحلیلی مبتنی بر داده Backend'],
                  ['قابلیت‌های تخصصی', 'syf_view_professional', 'امکانات ویژه کارشناسان و مشاوران'],
              ];
              foreach ($access_items as $item) :
                  $allowed = current_user_can($item[1]);
              ?>
                <article class="<?php echo $allowed ? 'is-allowed' : 'is-locked'; ?>">
                  <span><?php echo $allowed ? '✓' : '🔒'; ?></span>
                  <h3><?php echo esc_html($item[0]); ?></h3>
                  <p><?php echo esc_html($item[2]); ?></p>
                  <small><?php echo $allowed ? 'دسترسی فعال' : 'نیازمند ارتقای دسترسی توسط مدیر'; ?></small>
                </article>
              <?php endforeach; ?>
            </div>

            <div class="syf-core-account-actions">
              <?php if (current_user_can('syf_view_analytics')) : ?>
                <a class="syf-btn syf-btn--primary" href="<?php echo esc_url(home_url('/market-analytics/')); ?>">ورود به تحلیل بازار</a>
              <?php endif; ?>
              <a class="syf-btn syf-btn--outline" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج از حساب</a>
            </div>
          <?php else : ?>
            <?php self::render_notice($notice); ?>
            <div class="syf-core-auth-grid">
              <section class="syf-core-auth-panel syf-core-auth-panel--login">
                <div class="syf-kicker">ورود</div>
                <h2>به حساب ساخت‌یار وارد شوید</h2>
                <p>برای مطالعه کامل مقالات و مشاهده جزئیات ماژول‌ها وارد شوید.</p>
                <form method="post" class="syf-core-auth-form">
                  <?php wp_nonce_field('syf_login', '_syf_nonce'); ?>
                  <input type="hidden" name="syf_core_action" value="login">
                  <input type="hidden" name="next" value="<?php echo esc_attr($next); ?>">
                  <label>ایمیل یا نام کاربری<input type="text" name="login" autocomplete="username" required></label>
                  <label>رمز عبور<input type="password" name="password" autocomplete="current-password" required></label>
                  <button class="syf-btn syf-btn--primary" type="submit">ورود به ساخت‌یار</button>
                </form>
              </section>

              <section class="syf-core-auth-panel syf-core-auth-panel--register">
                <div class="syf-kicker">حساب جدید</div>
                <h2>در کمتر از یک دقیقه حساب بسازید</h2>
                <p>کاربر جدید با دسترسی پایه ساخته می‌شود؛ مدیر می‌تواند بعداً سطح دسترسی را ارتقا دهد.</p>
                <form method="post" class="syf-core-auth-form">
                  <?php wp_nonce_field('syf_register', '_syf_nonce'); ?>
                  <input type="hidden" name="syf_core_action" value="register">
                  <input type="hidden" name="next" value="<?php echo esc_attr($next); ?>">
                  <label>نام و نام خانوادگی<input type="text" name="display_name" autocomplete="name" required></label>
                  <label>ایمیل<input type="email" name="email" autocomplete="email" required></label>
                  <label>رمز عبور (حداقل ۸ کاراکتر)<input type="password" name="password" minlength="8" autocomplete="new-password" required></label>
                  <button class="syf-btn syf-btn--primary" type="submit">ساخت حساب رایگان</button>
                </form>
              </section>
            </div>
          <?php endif; ?>
        </div>
        <?php
        return (string)ob_get_clean();
    }

    private static function render_notice(string $notice): void {
        $messages = [
            'registered'      => 'حساب شما ساخته شد.',
            'logged_in'       => 'با موفقیت وارد شدید.',
            'invalid_request' => 'درخواست معتبر نبود؛ دوباره تلاش کنید.',
            'register_fields' => 'نام، ایمیل معتبر و رمز حداقل ۸ کاراکتری لازم است.',
            'email_exists'    => 'برای این ایمیل قبلاً حساب ساخته شده است.',
            'register_failed' => 'ساخت حساب انجام نشد؛ دوباره تلاش کنید.',
            'login_failed'    => 'اطلاعات ورود صحیح نیست.',
        ];
        if ($notice && isset($messages[$notice])) {
            echo '<div class="syf-core-notice">' . esc_html($messages[$notice]) . '</div>';
        }
    }

    public static function role_choices(): array {
        return [
            self::ROLE_MEMBER  => 'کاربر پایه',
            self::ROLE_ANALYST => 'تحلیل‌گر',
            self::ROLE_ADVISOR => 'کارشناس',
        ];
    }
}
