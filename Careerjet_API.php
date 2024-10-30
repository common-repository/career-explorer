<?php
if (!defined('ABSPATH')) {
    die("Can't access");
}

//class EasySearchCareerjetJobs {
class ESCJ {
    var $locale = '';
    var $version = '3.6';
    var $careerjet_api_content = '';

    function theJobsPluginCareerjet($locale = 'en_GB')
    {
        $this->locale = $locale;
    }

    function call($fname, $args)
    {
        $url = 'http://public.api.careerjet.net/' . $fname . '?locale_code=' . $this->locale;

        if (empty($args['affid'])) {
            return (object)array(
                'type' => 'ERROR',
                'error' => "Your Careerjet affiliate ID needs to be supplied. If you don't " .
                    "have one, open a free Careerjet partner account."
            );
        }

        foreach ($args as $key => $value) {
            $url .= '&' . $key . '=' . urlencode($value);
        }

        // Initialize $ip and $user_agent variables
        $ip = '';
        $user_agent = '';

        // Sanitize and validate user IP address
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        }

        // Sanitize and validate user agent
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
        }

        // Append sanitized and validated IP and user agent to the URL
        $url .= '&user_ip=' . urlencode($ip);
        $url .= '&user_agent=' . urlencode($user_agent);

        $current_page_url = '';

        // Build current page URL
        if (!empty($_SERVER["SERVER_NAME"]) && !empty($_SERVER["REQUEST_URI"])) {
            $server_name = filter_var($_SERVER["SERVER_NAME"], FILTER_SANITIZE_URL);
            $request_uri = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);

            $current_page_url = 'http';
            if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
                $current_page_url .= "s";
            }
            $current_page_url .= "://";

            if (!empty($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
                $server_port = absint($_SERVER["SERVER_PORT"]);
                if ($server_port && $server_port !== 80 && $server_port !== 443) {
                    $current_page_url .= $server_name . ":" . $server_port . $request_uri;
                } else {
                    $current_page_url .= $server_name . $request_uri;
                }
            } else {
                $current_page_url .= $server_name . $request_uri;
            }
        }

        // Set headers
        $headers = array(
            'User-Agent' => "careerjet-api-client-v{$this->version}-php-v" . phpversion()
        );

        if ($current_page_url) {
            $headers['Referer'] = $current_page_url;
        }

        $args = array(
            'sslverify' => false,
            'headers' => $headers,
        );

        // Perform HTTP request
        $response = wp_remote_get($url, $args);

        if (is_wp_error($response)) {
            return (object)array(
                'type' => 'ERROR',
                'error' => $response->get_error_message()
            );
        } else {
            return json_decode(wp_remote_retrieve_body($response));
        }
    }

    function search($args)
    {
        $result = $this->call('search', $args);
        if ($result->type == 'ERROR') {
            trigger_error(esc_html($result->error)); // Escape the error message
        }
        return $result;
    }
}
