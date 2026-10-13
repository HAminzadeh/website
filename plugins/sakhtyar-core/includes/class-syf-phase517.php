<?php
if (!defined('ABSPATH')) { exit; }

/** Phase 5.17: safe public bridge diagnostics and an app entry point. */
final class SYF_Core_Phase517 {
    public static function boot(): void {
        add_action('admin_menu', [__CLASS__, 'admin_menu']);
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
        add_shortcode('sakhtyar_app_entry', [__CLASS__, 'app_entry']);
        add_filter('the_content', [__CLASS__, 'append_account_entry'], 25);
    }
    public static function register_routes(): void {
        register_rest_route('sakhtyar/v1', '/bridge/health', [
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => static function () { return current_user_can('manage_options'); },
            'callback' => static function () {
                $res = SYF_Core_Backend::request('GET', '/api/web/v1/public/capabilities');
                return rest_ensure_response([
                    'connected' => is_array($res) && !is_wp_error($res),
                    'service' => is_array($res) ? sanitize_text_field((string)($res['service'] ?? '')) : '',
                    'phase' => '5.17',
                ]);
            },
        ]);
    }
    private static function app_url(): string {
        $url = defined('SAKHTYAR_APP_URL') ? (string)SAKHTYAR_APP_URL
            : (string)get_option('syf_app_url', '');
        $parts = wp_parse_url($url);
        if (!is_array($parts) || ($parts['scheme'] ?? '') !== 'https' || empty($parts['host'])
            || !empty($parts['user']) || !empty($parts['pass'])) { return ''; }
        return esc_url($url);
    }
    public static function app_entry(): string {
        $url = self::app_url();
        if (!$url) { return ''; }
        $message = 'ÙˆØ±ÙˆØ¯ Ø¨Ù‡ Ø§Ù¾Ù„ÛŒÚ©ÛŒØ´Ù† Ø¹Ù…Ù„ÛŒØ§ØªÛŒ Ø³Ø§Ø®Øªâ€ŒÛŒØ§Ø±';
        $note = 'ØªØ§ Ø²Ù…Ø§Ù† Ø±Ø§Ù‡â€ŒØ§Ù†Ø¯Ø§Ø²ÛŒ Identity Provider Ùˆ SSOØŒ ÙˆØ±ÙˆØ¯ WordPress Ø¨Ù‡â€ŒØªÙ†Ù‡Ø§ÛŒÛŒ Ù†Ø´Ø³Øª React Ø§ÛŒØ¬Ø§Ø¯ Ù†Ù…ÛŒâ€ŒÚ©Ù†Ø¯.';
        return '<section class="syf-section syf-phase517-app-entry"><div class="syf-container">'
            . '<h3>' . esc_html($message) . '</h3>'
            . '<p>' . esc_html($note) . '</p>'
            . '<a class="syf-btn syf-btn--primary" rel="noopener noreferrer" href="' . esc_url($url) . '">'
            . 'ÙˆØ±ÙˆØ¯ Ø¨Ù‡ Ù¾Ù†Ù„ Ù‡ÙˆØ´Ù…Ù†Ø¯ Ø³Ø§Ø®Øªâ€ŒÛŒØ§Ø±</a></div></section>';
    }
    public static function append_account_entry(string $content): string {
        if (!is_admin() && is_page('account') && in_the_loop() && is_main_query()) {
            return $content . self::app_entry();
        }
        return $content;
    }
    public static function admin_menu(): void {
        add_options_page('SakhtYar Bridge', 'SakhtYar Bridge', 'manage_options',
            'syf-phase517', [__CLASS__, 'settings_page']);
    }
    public static function settings_page(): void {
        if (!current_user_can('manage_options')) { wp_die('Access denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['syf_phase517_save'])) {
            check_admin_referer('syf_phase517_settings');
            $base = isset($_POST['syf_backend_url'])
                ? esc_url_raw(trim((string)wp_unslash($_POST['syf_backend_url']))) : '';
            $app = isset($_POST['syf_app_url'])
                ? esc_url_raw(trim((string)wp_unslash($_POST['syf_app_url']))) : '';
            $city = isset($_POST['syf_market_city'])
                ? sanitize_text_field(wp_unslash($_POST['syf_market_city'])) : 'ØªÙ‡Ø±Ø§Ù†';
            if ($base !== '' && !SYF_Core_Backend::valid_base($base)) {
                echo '<div class="notice notice-error"><p>Backend URL must be an HTTPS origin.</p></div>';
            } elseif ($app !== '' && (!wp_parse_url($app, PHP_URL_HOST) || wp_parse_url($app, PHP_URL_SCHEME) !== 'https')) {
                echo '<div class="notice notice-error"><p>App URL must use HTTPS.</p></div>';
            } else {
                update_option('syf_backend_base_url', $base);
                update_option('syf_app_url', $app);
                update_option('syf_market_city', function_exists('mb_substr') ? mb_substr($city, 0, 120) : $city);
                echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
            }
        }
        $configured = (bool)SYF_Core_Backend::base();
        $remote = $configured ? SYF_Core_Backend::request('GET', '/api/web/v1/public/capabilities') : null;
        $connected = is_array($remote) && !is_wp_error($remote);
        echo '<div class="wrap"><h1>SakhtYar Phase 5.17 Bridge</h1>';
        echo '<p>Backend capabilities: <strong>' . ($connected ? 'CONNECTED' : 'NOT VERIFIED') . '</strong></p>';
        echo '<p>Private case access must use the end-user Java identity; a WordPress service token is not user SSO.</p>';
        echo '<form method="post">';
        wp_nonce_field('syf_phase517_settings');
        echo '<table class="form-table"><tbody>';
        $fields = [
            ['syf_backend_url','Backend HTTPS origin','syf_backend_base_url'],
            ['syf_app_url','React app HTTPS URL','syf_app_url'],
            ['syf_market_city','Market city','syf_market_city'],
        ];
        foreach ($fields as $field) {
            $value = (string)get_option($field[2], $field[2] === 'syf_market_city' ? 'ØªÙ‡Ø±Ø§Ù†' : '');
            echo '<tr><th><label for="' . esc_attr($field[0]) . '">' . esc_html($field[1])
                . '</label></th><td><input class="regular-text" id="' . esc_attr($field[0])
                . '" name="' . esc_attr($field[0]) . '" value="' . esc_attr($value) . '"></td></tr>';
        }
        echo '</tbody></table><p><button class="button button-primary" name="syf_phase517_save" value="1">Save settings</button></p></form></div>';
    }
}