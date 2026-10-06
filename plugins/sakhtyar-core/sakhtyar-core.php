<?php
/**
 * Plugin Name: SakhtYar Core
 * Description: Core application integration and source-driven content bootstrap for SakhtYar Flow.
 * Version: 0.1.0
 * Author: SakhtYar
 */

if (!defined('ABSPATH')) { exit; }

final class SakhtYar_Core {
    public static function boot(): void {
        add_action('init', [__CLASS__, 'register']);
    }

    public static function register(): void {
        // Future: CPTs, REST API bridges, application integrations, forms, etc.
    }
}

SakhtYar_Core::boot();