<?php
if (!defined('ABSPATH')) {
    fwrite(STDERR, "WordPress must be loaded.\n");
    exit(1);
}

$manifestPath = WP_CONTENT_DIR . '/sakhtyar-content/data/site.json';
if (!file_exists($manifestPath)) {
    WP_CLI::error("Missing content manifest: {$manifestPath}");
}

$data = json_decode(file_get_contents($manifestPath), true);
if (!is_array($data)) {
    WP_CLI::error("Invalid site.json");
}

$site = $data['site'] ?? [];
if (!empty($site['title'])) update_option('blogname', $site['title']);
if (!empty($site['tagline'])) update_option('blogdescription', $site['tagline']);
if (!empty($site['timezone'])) update_option('timezone_string', $site['timezone']);
update_option('start_of_week', 6);
update_option('blog_public', 0);

$pageIds = [];

foreach (($data['pages'] ?? []) as $page) {
    $slug = sanitize_title($page['slug'] ?? '');
    $title = sanitize_text_field($page['title'] ?? '');
    if (!$slug || !$title) continue;

    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing) {
        $pageIds[$slug] = (int)$existing->ID;
        continue;
    }

    $id = wp_insert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $title,
        'post_name' => $slug,
        'post_content' => ''
    ], true);

    if (is_wp_error($id)) {
        WP_CLI::warning("Could not create page {$slug}: " . $id->get_error_message());
        continue;
    }
    $pageIds[$slug] = (int)$id;
}

if (!empty($pageIds['home'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $pageIds['home']);
}
if (!empty($pageIds['blog'])) {
    update_option('page_for_posts', $pageIds['blog']);
}

WP_CLI::success('SakhtYar project source synchronized into WordPress.');