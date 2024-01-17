<?php

namespace mirazmac\plugins\GNewsSitemap;

use spark\controllers\Controller;
use spark\helpers\UrlSlug;
use spark\models\CategoryModel;
use spark\models\PostModel;

/**
* GNewsSitemapController
*/
class GNewsSitemapController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sitemap
     *
     * @return
     */
    public function sitemap()
    {
        $app = app();
        $page = 1;
        $data = [];
        $app->response->headers->set('content-type', 'application/xml');

        $postModel    = new PostModel;
        $table = $postModel->getTable();

        $itemsPerPage = (int) get_option('gnews_sitemap_links_per_page', 1000);

        $sql = "SELECT post_id , post_title , post_featured_image, post_pubdate FROM {$table} WHERE post_pubdate > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) ORDER BY post_pubdate DESC LIMIT 0 , {$itemsPerPage}";

        $items = $postModel->db()->query($sql)->fetchAll();

        $data['slug'] = new UrlSlug;

        $data['entries'] = $items;

        return view('gnews-sitemap::sitemap.php', $data);
    }
}
