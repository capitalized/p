<?php

require __DIR__ . '/constants.php';

// Toggle Errors
if (defined('DEV_MODE') && DEV_MODE) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// If we have cloudflare pro, set the real IP
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

$composer = require SRCPATH . '/vendor/autoload.php';

// Load core functions, so the $app instance is available to them
require SRCPATH . '/functions/core.php';

// First create the app instance
$app = new \Slim\Slim(require(srcpath('/settings/app.php')));

// Set Site URL as config value
if (!$app->config('uri')) {
    $app->config('uri', $app->request->getUrl() . $app->request->getRootUri());
}

$trustedHosts = $app->config('trusted_domains');
$trustedHosts[] = get_domain_name($app->config('uri'));
$trustedHosts = array_unique($trustedHosts);
$app->config('trusted_domains', $trustedHosts);


// Turn on gzip compression
//enable_gzip_compression();

// Update character set
ini_set('default_charset', $app->config('charset'));
mb_internal_encoding($app->config('charset'));
mb_http_output($app->config('charset'));

// Configure session and shit -_-
session_name($app->config('session.name'));
session_cache_limiter(false);
session_save_path($app->config('session.save_path'));
session_set_cookie_params(
    $app->config('session.lifetime'),
    $app->config('cookies.path'),
    $app->config('cookies.domain'),
    (bool) $app->config('cookies.secure'),
    (bool) $app->config('cookies.httponly')
);

if ($app->config('session.autostart')) {
    session_start();
}

// Halt on Invalid API Keys
if (JSON_REQUEST && !in_array($app->request->get('key'), $app->config('api_keys'))) {
    fatal_server_error('Invalid API Key', 'The API <strong>key</strong> parameter is missing or invalid.');
}

// Load dependencies
require srcpath('dependencies.php');

// Set timezone
date_default_timezone_set(get_option('timezone', $app->config('timezone')));

// and the middlewares as well
require srcpath('middlewares.php');

// finally.. the routes
$routes = ['base', 'search', 'dashboard'];

foreach ($routes as $route) {
    require srcpath("routes/{$route}.routes.php");
}

// By default we assume we're on the frontend
registry_store('is_frontend', true);

// Load the plugins
$app->plugins->load();

do_action('plugins.loaded');
