<?php block('form-content'); ?>
    <div class="alert alert-secondary">
        Google News Sitemap can be found here: <a class="alert-link" href="<?= e_attr(url_for('gnews-sitemap.index')); ?>"><?= e(url_for('gnews-sitemap.index')); ?></a>
    </div>
<div class="form-group">
    <label for="gnews_sitemap_links_per_page" class="form-label">Number of entries to show</label>
    <input type="number" name="gnews_sitemap_links_per_page" id="gnews_sitemap_links_per_page" class="form-control"
    value="<?= sp_post('gnews_sitemap_links_per_page', get_option('gnews_sitemap_links_per_page', 1000)); ?>">
    <span class="form-text text-muted">Number of latest posts published within the last two days to show in the sitemap.</span>
</div>

<div class="form-group">
    <label for="gnews_sitemap_language" class="form-label">Sitemap Language Code</label>
    <input type="text" name="gnews_sitemap_language" id="gnews_sitemap_language" class="form-control"
    value="<?= sp_post('gnews_sitemap_language', get_option('gnews_sitemap_language', 'en')); ?>">
    <span class="form-text text-muted">The language of your publication. Use an <a href="http://www.loc.gov/standards/iso639-2/php/code_list.php" rel="external" target="_blank">ISO 639 language code</a> (two or three letters).</span>
</div>

<div class="form-group">
    <label for="gnews_sitemap_name" class="form-label">Google News Publication name</label>
    <input type="text" name="gnews_sitemap_name" id="gnews_sitemap_name" class="form-control"
    value="<?= sp_post('gnews_sitemap_name', get_option('gnews_sitemap_name', 'ExampleTimes')); ?>">
    <span class="form-text text-muted">The exact publication name of your Google News</span>
</div>
<?php endblock(); ?>
<?php
// Extends the plugins options skeleton
extend(
    'admin::layouts/settings_skeleton.php',
    [
        'title'           => 'Google News SiteMap Settings',
        'body_class'      => 'plugin-options gnews-sitemap',
        'page_heading'    => 'Google News SiteMap Settings',
        'page_subheading' => 'Customize Google News SiteMap',
    ]
);
