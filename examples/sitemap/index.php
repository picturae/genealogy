<?php
require_once 'vendor/autoload.php';

$url = new Picturae\Genealogy\URL;
$link = $url->getCurrentURL();

// Change to your API key
$apiKey = '509544d0-1c67-11e4-9016-c788dee409dc';

// Your base url for the genealogy application (note the deeds at the end is to link directly to the deed)
// your application would be installed under http://demo.webservices.picturae.pro/genealogie/ 
$baseURL = 'http://demo.webservices.picturae.pro/genealogie/deeds/';

$client = new Picturae\Genealogy\Client($apiKey);

// This part should be cached to avoid the extra request
$deedsCount = 100;
$result = $client->getDeeds(['rows' => $deedsCount]);
$pages = $result->metadata->pagination->pages;

$currentPage = null;
if (isset($_GET['page'])) {
    $currentPage = (int)$_GET['page'];        
}

$collection = new \Sitemap\Collection;

if ($currentPage) {
    
    // Render the sitemap for the current page
    $result = $client->getDeeds([
        'rows' => $deedsCount,
        'page' => $currentPage
    ]);
    
    foreach ($result->deeds as $deed) {
        $basic = new \Sitemap\Sitemap\SitemapEntry($baseURL . $deed->id);
        $collection->addSitemap($basic);    
    }
    
} else {
    
    // Render the sitemap with all other sitemap
    for ($index = 0; $index < $pages; $index++) {
        $basic = new \Sitemap\Sitemap\SitemapEntry($url->getCurrentURL() . '?page=' . ($index + 1));
        $collection->addSitemap($basic);    
    }
    
}

$collection->setFormatter(new \Sitemap\Formatter\XML\URLSet);
$collection->setFormatter(new \Sitemap\Formatter\XML\SitemapIndex);

header("Content-type: text/xml; charset=utf-8");
echo $collection->output();