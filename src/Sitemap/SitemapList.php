<?php
namespace Picturae\Genealogy\Sitemap;

/* 
 * Generate a list with sitemaps example:
 * 
 * <?xml version="1.0" encoding="UTF-8"?>
 *  <sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 *      si:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
 *      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
 *      <sitemap>
 *          <loc>http://example.com/sitemap/genealogy?page=1</loc>
 *      </sitemap>
 *      <sitemap>
 *          <loc>http://example.com/sitemap/genealogy?page=2</loc>
 *      </sitemap>
 *  </sitemapindex>      
 */
class SitemapList
{
    /**
     * Amount of pages
     * @var int
     */
    private $pages;
    
    /**
     * The url where the details of the sitemap can be retrieved e.g http://example.com/sitemap/genealogy/deeds?page={page}
     * @var string
     */
    private $siteMapURL;
    
    /**
     * Amount of records to show per sitemap
     * @var int
     */
    private $recordsPerSitemap;
    
    /**
     * 
     * @param int $pages Amount of pages (either deed or register total page count from the API)
     * @param string $siteMapURL The url where the details of the sitemap can be retrieved e.g http://example.com/sitemap/genealogy/deeds?page={page}
     */
    public function __construct($pages, $siteMapURL)
    {
        $this->pages = $pages;
        $this->siteMapURL = $siteMapURL;
    }
    
    public function getXML()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
    }
}
