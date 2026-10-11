<?php
if (!defined('ABSPATH')) { exit; }

final class SYF_Core_Backend {

    public static function base(): string {
        if (
            defined('SAKHTYAR_BACKEND_BASE_URL') &&
            SAKHTYAR_BACKEND_BASE_URL
        ) {
            return untrailingslashit(
                (string) SAKHTYAR_BACKEND_BASE_URL
            );
        }

        return untrailingslashit(
            trim((string) get_option('syf_backend_base_url', ''))
        );
    }

    public static function valid_base(string $base): bool {
        $parts = wp_parse_url($base);

        return is_array($parts)
            && ($parts['scheme'] ?? '') === 'https'
            && !empty($parts['host'])
            && empty($parts['user'])
            && empty($parts['pass'])
            && empty($parts['query'])
            && empty($parts['fragment'])
            && (
                empty($parts['path']) ||
                $parts['path'] === '/'
            );
    }

    public static function valid_path(string $path): bool {
        return (
            (bool) preg_match(
                '~^/api/[a-zA-Z0-9/_-]+$~D',
                $path
            )
            && strpos($path, '..') === false
        );
    }

    public static function request(
        string $method,
        string $path,
        ?array $payload = null,
        array $query = []
    ) {
        $base = self::base();

        if (
            !$base ||
            !self::valid_base($base) ||
            !self::valid_path($path)
        ) {
            return new WP_Error(
                'syf_config',
                'Backend configuration invalid.'
            );
        }

        $url = $base . $path;

        if ($query) {
            $url = add_query_arg($query, $url);
        }

        if (!wp_http_validate_url($url)) {
            return new WP_Error(
                'syf_unsafe_url',
                'Unsafe backend address.'
            );
        }

        $headers = [
            'Accept' => 'application/json'
        ];

        $token = defined('SAKHTYAR_BACKEND_TOKEN')
            ? trim((string) SAKHTYAR_BACKEND_TOKEN)
            : '';

        if ($token !== '') {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        $args = [
            'method' => $method,
            'timeout' => 8,
            'redirection' => 0,
            'sslverify' => true,
            'reject_unsafe_urls' => true,
            'headers' => $headers,
            'limit_response_size' => 1048576
        ];

        if ($payload !== null) {
            $args['headers']['Content-Type'] = 'application/json';
            $args['body'] = wp_json_encode($payload);
        }

        $response = wp_safe_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = (int) wp_remote_retrieve_response_code(
            $response
        );

        if ($status < 200 || $status >= 300) {
            return new WP_Error(
                'syf_backend_http',
                'Backend request failed.',
                ['status' => $status]
            );
        }

        $body = wp_remote_retrieve_body($response);

        if (trim($body) === '' && $method === 'POST') {
            return ['accepted' => true];
        }

        $decoded = json_decode($body, true);

        return is_array($decoded)
            ? $decoded
            : new WP_Error(
                'syf_invalid_json',
                'Unexpected backend response.'
            );
    }
}