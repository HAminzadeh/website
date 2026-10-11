<?php
/**
 * Plugin Name: SakhtYar Core
 * Plugin URI: https://sakhtyarflow.ir/
 * Description: Account access, analytics bridge, admin access management, release packaging and core integrations for SakhtYar Flow.
 * Version: 0.6.1
 * Requires at least: 6.5
 * Requires PHP: 8.0
 * Author: SakhtYar
 * Text Domain: sakhtyar-core
 */

if (!defined('ABSPATH')) { exit; }

define('SYF_CORE_VERSION', '0.6.1');
define('SYF_CORE_DB_VERSION', '0.6.1');
define('SYF_CORE_FILE', __FILE__);
define('SYF_CORE_DIR', plugin_dir_path(__FILE__));
define('SYF_CORE_URL', plugin_dir_url(__FILE__));

require_once SYF_CORE_DIR . 'includes/class-syf-backend.php';
require_once SYF_CORE_DIR . 'includes/class-syf-access.php';
require_once SYF_CORE_DIR . 'includes/class-syf-analytics.php';
require_once SYF_CORE_DIR . 'includes/class-syf-admin.php';
require_once SYF_CORE_DIR . 'includes/class-syf-release.php';

final class SakhtYar_Core {
    public static function boot(): void {
        SYF_Core_Access::boot();
        SYF_Core_Analytics::boot();
        SYF_Core_Admin::boot();
        SYF_Core_Release::boot();
    }

    public static function activate(): void {
        SYF_Core_Access::install_or_upgrade(true);
        flush_rewrite_rules();
    }
}

register_activation_hook(__FILE__, ['SakhtYar_Core', 'activate']);
SakhtYar_Core::boot();

function syf_core_can(string $capability): bool {
    return current_user_can($capability);
}

function syf_core_account_url(string $next = ''): string {
    $url = home_url('/account/');
    if ($next !== '') {
        $url = add_query_arg('next', rawurlencode($next), $url);
    }
    return $url;
}

function syf_core_render_analytics_promo(): void {
    SYF_Core_Analytics::render_home_promo();
}
