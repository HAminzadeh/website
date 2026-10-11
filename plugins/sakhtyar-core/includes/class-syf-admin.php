<?php
if (!defined('ABSPATH')) { exit; }

final class SYF_Core_Admin {
    public static function boot(): void {
        add_action('admin_menu', [__CLASS__, 'menu']);
        add_action('admin_post_syf_update_user_access', [__CLASS__, 'update_user_access']);
        add_action('admin_post_syf_save_backend_settings', [__CLASS__, 'save_backend_settings']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_assets']);
    }

    public static function menu(): void {
        add_menu_page(
            'SakhtYar',
            'SakhtYar',
            'manage_options',
            'sakhtyar',
            [__CLASS__, 'dashboard_page'],
            'dashicons-building',
            3
        );

        add_submenu_page('sakhtyar', 'داشبورد ساخت‌یار', 'داشبورد', 'manage_options', 'sakhtyar', [__CLASS__, 'dashboard_page']);
        add_submenu_page('sakhtyar', 'کاربران و دسترسی', 'کاربران و دسترسی', 'list_users', 'sakhtyar-users', [__CLASS__, 'users_page']);
        add_submenu_page('sakhtyar', 'اتصال Backend', 'اتصال Backend', 'manage_options', 'sakhtyar-backend', [__CLASS__, 'backend_page']);
    }

    public static function admin_assets(string $hook): void {
        if (strpos($hook, 'sakhtyar') === false) return;
        wp_enqueue_style('sakhtyar-core', SYF_CORE_URL . 'assets/core.css', [], SYF_CORE_VERSION);
    }

    public static function dashboard_page(): void {
        if (!current_user_can('manage_options')) return;

        $counts = count_users();
        $theme = wp_get_theme('sakhtyar-flow');
        ?>
        <div class="wrap syf-admin-wrap">
          <h1>مرکز مدیریت ساخت‌یار</h1>
          <p class="description">وضعیت حساب‌ها، اتصال Backend و بسته‌های انتشار را از این بخش مدیریت کنید.</p>

          <div class="syf-admin-kpis">
            <article><small>کل کاربران</small><strong><?php echo esc_html((string)($counts['total_users'] ?? 0)); ?></strong></article>
            <article><small>Theme</small><strong><?php echo esc_html($theme->exists() ? $theme->get('Version') : '—'); ?></strong></article>
            <article><small>Core Plugin</small><strong><?php echo esc_html(SYF_CORE_VERSION); ?></strong></article>
            <article><small>Backend</small><strong><?php echo get_option('syf_backend_base_url') ? 'Configured' : 'Demo Mode'; ?></strong></article>
          </div>

          <div class="syf-admin-grid">
            <a href="<?php echo esc_url(admin_url('admin.php?page=sakhtyar-users')); ?>"><span class="dashicons dashicons-groups"></span><h2>کاربران و سطح دسترسی</h2><p>کاربر جدید به‌صورت پیش‌فرض «کاربر پایه» است؛ سطح تحلیل‌گر یا کارشناس را از اینجا بدهید.</p></a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=sakhtyar-backend')); ?>"><span class="dashicons dashicons-database"></span><h2>اتصال Backend</h2><p>Base URL، مسیر Analytics و Token را بدون قراردادن Secret در Theme تنظیم کنید.</p></a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=sakhtyar-release')); ?>"><span class="dashicons dashicons-download"></span><h2>Release Center</h2><p>دو ZIP استاندارد Theme و Plugin را با نسخه فعلی برای نصب روی هاست بگیرید.</p></a>
          </div>
        </div>
        <?php
    }

    public static function users_page(): void {
        if (!current_user_can('list_users')) return;
        $users = get_users(['number' => 100, 'orderby' => 'registered', 'order' => 'DESC']);
        $choices = SYF_Core_Access::role_choices();
        ?>
        <div class="wrap syf-admin-wrap">
          <h1>کاربران و سطح دسترسی</h1>
          <p class="description">مدیران WordPress از این جدول قابل تنزل نیستند تا ریسک قفل شدن مدیریت کاهش پیدا کند.</p>
          <table class="widefat striped syf-admin-users">
            <thead><tr><th>کاربر</th><th>ایمیل</th><th>ثبت‌نام</th><th>سطح فعلی</th><th>تغییر دسترسی</th></tr></thead>
            <tbody>
            <?php foreach ($users as $user) :
                $role = $user->roles[0] ?? 'subscriber';
                $is_admin = in_array('administrator', $user->roles, true);
            ?>
              <tr>
                <td><strong><?php echo esc_html($user->display_name ?: $user->user_login); ?></strong><br><code><?php echo esc_html($user->user_login); ?></code></td>
                <td><?php echo esc_html($user->user_email); ?></td>
                <td><?php echo esc_html(mysql2date('Y/m/d H:i', $user->user_registered)); ?></td>
                <td><?php echo $is_admin ? '<span class="syf-admin-pill">مدیر سیستم</span>' : esc_html($choices[$role] ?? $role); ?></td>
                <td>
                  <?php if (!$is_admin && current_user_can('promote_users')) : ?>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="syf-admin-inline-form">
                      <?php wp_nonce_field('syf_update_user_access_' . $user->ID); ?>
                      <input type="hidden" name="action" value="syf_update_user_access">
                      <input type="hidden" name="user_id" value="<?php echo esc_attr((string)$user->ID); ?>">
                      <select name="role">
                        <?php foreach ($choices as $key=>$label) : ?><option value="<?php echo esc_attr($key); ?>"<?php selected($role,$key); ?>><?php echo esc_html($label); ?></option><?php endforeach; ?>
                      </select>
                      <button class="button button-primary" type="submit">ذخیره</button>
                    </form>
                  <?php else : ?>—<?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php
    }

    public static function update_user_access(): void {
        if (!current_user_can('promote_users')) wp_die('Access denied.');

        $user_id = isset($_POST['user_id']) ? absint($_POST['user_id']) : 0;
        check_admin_referer('syf_update_user_access_' . $user_id);

        $role = isset($_POST['role']) ? sanitize_key(wp_unslash($_POST['role'])) : '';
        $choices = SYF_Core_Access::role_choices();
        if (!$user_id || !isset($choices[$role])) wp_die('Invalid role.');

        $user = get_user_by('id', $user_id);
        if (!$user || in_array('administrator', $user->roles, true)) wp_die('Administrator role cannot be changed here.');

        $user->set_role($role);
        wp_safe_redirect(admin_url('admin.php?page=sakhtyar-users&updated=1'));
        exit;
    }

    public static function backend_page(): void {
        if (!current_user_can('manage_options')) return;
        ?>
        <div class="wrap syf-admin-wrap">
          <h1>اتصال Backend و Analytics</h1>
          <p class="description">توکن فقط در سمت WordPress ذخیره می‌شود و در JavaScript فرانت‌اند نمایش داده نمی‌شود.</p>
          <?php if (isset($_GET['updated'])) : ?><div class="notice notice-success is-dismissible"><p>تنظیمات ذخیره شد.</p></div><?php endif; ?>

          <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="syf-admin-settings-card">
            <?php wp_nonce_field('syf_save_backend_settings'); ?>
            <input type="hidden" name="action" value="syf_save_backend_settings">

            <label>Backend Base URL
              <input type="url" name="base_url" value="<?php echo esc_attr((string)get_option('syf_backend_base_url','')); ?>" placeholder="https://api.example.com">
            </label>
            <label>Analytics Path
              <input type="text" name="analytics_path" value="<?php echo esc_attr((string)get_option('syf_backend_analytics_path','/api/v1/analytics/market')); ?>">
            </label>
            <label>Service Token
              <input type="password" name="api_token" value="" autocomplete="new-password" placeholder="<?php echo get_option('syf_backend_api_token') ? 'توکن ذخیره شده؛ برای تغییر مقدار جدید وارد کنید' : 'Bearer token'; ?>">
            </label>

            <div class="syf-admin-settings-note">
              قرارداد پیشنهادی پاسخ Analytics: <code>region</code>، <code>updated_at</code>، <code>metrics</code>، <code>price_series</code>، <code>segments</code> و <code>signals</code>.
            </div>
            <button class="button button-primary button-hero" type="submit">ذخیره اتصال Backend</button>
          </form>
        </div>
        <?php
    }

    public static function save_backend_settings(): void {
        if (!current_user_can('manage_options')) wp_die('Access denied.');
        check_admin_referer('syf_save_backend_settings');

        $base = isset($_POST['base_url']) ? esc_url_raw(wp_unslash($_POST['base_url'])) : '';
        $path = isset($_POST['analytics_path']) ? sanitize_text_field(wp_unslash($_POST['analytics_path'])) : '/api/v1/analytics/market';
        $token = isset($_POST['api_token']) ? sanitize_text_field(wp_unslash($_POST['api_token'])) : '';

        update_option('syf_backend_base_url', untrailingslashit($base), false);
        update_option('syf_backend_analytics_path', '/' . ltrim($path, '/'), false);
        if ($token !== '') {
            update_option('syf_backend_api_token', $token, false);
        }

        wp_safe_redirect(admin_url('admin.php?page=sakhtyar-backend&updated=1'));
        exit;
    }
}
