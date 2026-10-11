<?php
if (!defined('ABSPATH')) { exit; }

final class SYF_Core_Release {
    public static function boot(): void {
        add_action('admin_menu', [__CLASS__, 'menu'], 20);
        add_action('admin_post_syf_export_theme', [__CLASS__, 'export_theme']);
        add_action('admin_post_syf_export_plugin', [__CLASS__, 'export_plugin']);
    }

    public static function menu(): void {
        add_submenu_page(
            'sakhtyar',
            'Release Center',
            'Release Center',
            'syf_export_packages',
            'sakhtyar-release',
            [__CLASS__, 'page']
        );
    }

    public static function page(): void {
        if (!current_user_can('syf_export_packages')) return;

        $theme = wp_get_theme('sakhtyar-flow');
        $theme_version = $theme->exists() ? (string)$theme->get('Version') : 'unknown';
        ?>
        <div class="wrap syf-admin-wrap">
          <h1>Release Center</h1>
          <p class="description">برای انتشار Production فقط دو بسته استاندارد بسازید. Theme ظاهر را حمل می‌کند؛ Plugin منطق، نقش‌ها، Migrationها، Analytics و Admin را.</p>

          <div class="syf-release-grid">
            <article>
              <span class="dashicons dashicons-admin-appearance"></span>
              <small>Theme package</small>
              <h2>SakhtYar Flow</h2>
              <p>نسخه <strong><?php echo esc_html($theme_version); ?></strong></p>
              <a class="button button-primary button-hero" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=syf_export_theme'), 'syf_export_theme')); ?>">دانلود Theme ZIP</a>
            </article>

            <article>
              <span class="dashicons dashicons-admin-plugins"></span>
              <small>Core package</small>
              <h2>SakhtYar Core</h2>
              <p>نسخه <strong><?php echo esc_html(SYF_CORE_VERSION); ?></strong></p>
              <a class="button button-primary button-hero" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=syf_export_plugin'), 'syf_export_plugin')); ?>">دانلود Plugin ZIP</a>
            </article>
          </div>

          <div class="syf-release-info">
            <h2>روش انتشار پیشنهادی</h2>
            <ol>
              <li>از Production یک Backup فایل و Database بگیرید.</li>
              <li>Plugin ZIP را Upload و جایگزین نسخه فعلی کنید؛ Migrationهای نسخه‌ای خودکار اجرا می‌شوند.</li>
              <li>Theme ZIP را Upload و جایگزین نسخه فعلی کنید؛ Bootstrap تم بر اساس Version اجرا می‌شود.</li>
              <li>صفحه‌های حساب، Analytics، نقش‌ها و تنظیمات در Database باقی می‌مانند و فقط ساختار لازم به‌روزرسانی می‌شود.</li>
            </ol>
          </div>
        </div>
        <?php
    }

    public static function export_theme(): void {
        if (!current_user_can('syf_export_packages')) wp_die('Access denied.');
        check_admin_referer('syf_export_theme');

        $theme = wp_get_theme('sakhtyar-flow');
        if (!$theme->exists()) wp_die('Theme not found.');

        $source = $theme->get_stylesheet_directory();
        $version = (string)$theme->get('Version');
        self::send_package($source, 'sakhtyar-flow', 'sakhtyar-flow-theme-' . sanitize_file_name($version) . '.zip');
    }

    public static function export_plugin(): void {
        if (!current_user_can('syf_export_packages')) wp_die('Access denied.');
        check_admin_referer('syf_export_plugin');

        self::send_package(SYF_CORE_DIR, 'sakhtyar-core', 'sakhtyar-core-' . sanitize_file_name(SYF_CORE_VERSION) . '.zip');
    }

    private static function send_package(string $source, string $top_level, string $filename): void {
        @set_time_limit(120);
        $source = realpath($source);
        if (!$source || !is_dir($source)) wp_die('Package source not found.');

        $tmp = wp_tempnam($filename);
        if (!$tmp) wp_die('Could not allocate a temporary file.');
        @unlink($tmp);
        $tmp .= '.zip';

        $ok = self::create_zip($source, $top_level, $tmp);
        if (!$ok || !file_exists($tmp)) {
            @unlink($tmp);
            wp_die('ZIP package could not be created. Enable PHP ZipArchive on the host.');
        }

        nocache_headers();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tmp));
        header('X-Content-Type-Options: nosniff');

        readfile($tmp);
        @unlink($tmp);
        exit;
    }

    private static function create_zip(string $source, string $top_level, string $zip_path): bool {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) return false;

            $source_len = strlen(rtrim($source, DIRECTORY_SEPARATOR)) + 1;
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                $name = $item->getPathname();
                $relative = substr($name, $source_len);
                if (self::should_skip($relative)) continue;
                $archive_path = $top_level . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $relative);

                if ($item->isDir()) {
                    $zip->addEmptyDir($archive_path);
                } else {
                    $zip->addFile($name, $archive_path);
                }
            }

            return $zip->close();
        }

        if (!class_exists('PclZip')) {
            require_once ABSPATH . 'wp-admin/includes/class-pclzip.php';
        }
        if (!class_exists('PclZip')) return false;

        $archive = new PclZip($zip_path);
        $result = $archive->create(
            $source,
            PCLZIP_OPT_REMOVE_PATH, dirname($source),
            PCLZIP_OPT_ADD_PATH, ''
        );
        return $result !== 0;
    }

    private static function should_skip(string $relative): bool {
        $normalized = str_replace('\\', '/', $relative);
        foreach (['/.git/', '/.local/', '/node_modules/', '/dist/', '.DS_Store', 'Thumbs.db'] as $needle) {
            if (strpos('/' . $normalized, $needle) !== false) return true;
        }
        return false;
    }
}
