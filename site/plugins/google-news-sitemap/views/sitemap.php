<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>
<urlset
xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"       
xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($t['entries'] as $item) : ?>
      <url>
         <loc><?= e(url_for('site.read', ['slug' => $t['slug']->generate($item['post_title']), 'id' => $item['post_id']])); ?></loc>
        <news:news>
        <news:publication>
        <news:name><?= e(get_option('gnews_sitemap_name', 'ExampleTimes')); ?></news:name>
        <news:language><?= e(get_option('gnews_sitemap_language', 'en')); ?></news:language>
    </news:publication>
    <news:publication_date><?= date('c', $item['post_pubdate']); ?></news:publication_date>
    <news:title><?= e($item['post_title']); ?></news:title>
</news:news>

<image:image>
<image:loc><?= e(feat_img_url($item['post_featured_image'])); ?></image:loc>
</image:image>
  </url>
<?php endforeach; ?>
</urlset>
