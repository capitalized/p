<?php

/*
Plugin Name: Google News Sitemap
Plugin URI: http://github.com/MirazMac
Description: This plugin provides sitemap for Google News consumption
Author: Miraz Mac
Version: 1.0
Author URI: https://mirazmac.com/
*/


$app = app();

// Absolute to Plugin Directory
define('GNEWS_SITEMAP_PLUGIN_PATH', sp_plugin_path(__FILE__));

// We need to register PSR-4 namespaces if we're gonna use OOP
sp_register_psr4('mirazmac\\plugins\\GNewsSitemap\\', trailingslashit(GNEWS_SITEMAP_PLUGIN_PATH) . 'lib/');

// Register our own templates to use in options and others
register_templates('gnews-sitemap', trailingslashit(GNEWS_SITEMAP_PLUGIN_PATH) . 'views');

// Define the routes
add_action('plugins.loaded', function () use ($app) {
    $app->get('/news-sitemap.xml', 'mirazmac\\plugins\\GNewsSitemap\\GNewsSitemapController:sitemap')->name('gnews-sitemap.index');
    $app->get('/news-sitemap-:id.xml', 'mirazmac\\plugins\\GNewsSitemap\\GNewsSitemapController:sitemap')->name('gnews-sitemap.list');
});


register_plugin_options(
    __FILE__,
    'gnews-sitemap::options.php',
    function () use ($app) {
        if (is_demo()) {
            flash('settings-info', $GLOBALS['_SPARK_I18N']['demo_mode']);
            return false;
        }
    
        $data = [
            'gnews_sitemap_links_per_page' => (int) $app->request->post('gnews_sitemap_links_per_page'),
            'gnews_sitemap_language' => sp_strip_tags($app->request->post('gnews_sitemap_language'), true),
            'gnews_sitemap_name' => sp_strip_tags($app->request->post('gnews_sitemap_name'), true),
        ];

        foreach ($data as $key => $value) {
            set_option($key, $value);
        }

        flash('settings-success', 'Settings were updated successfully!');
    },
    'GNews Sitemap Options'
);
