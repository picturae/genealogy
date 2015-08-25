<?php
namespace Picturae\Genealogy;

class URL
{
    /**
     * url to parse e.g http://example.com
     * @var string
     */
    private $url;
    
    /**
     * 
     * @param string $url the url to work with leave empty for current url
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function __construct($url = null)
    {
        if ($url === null) {
            $url = $this->getCurrentURL();
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception\InvalidArgumentException('Invalid url given ' .$url);
        }
                
        $this->url = $url;
    }
    
    /**
     * Get URL used by this object
     * 
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }
    
    /**
     * Get current url
     * @return string
     */
    public function getCurrentURL()
    {
        $url = $this->getCurrentScheme();
        if (!isset($_SERVER['HTTP_HOST'])) {
            throw new Exception\RuntimeException('No url given and $_SERVER[\'HTTP_HOST\'] is undefined');
        }
        $url .= $_SERVER['HTTP_HOST'];
        
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new Exception\RuntimeException('No url given and $_SERVER[\'REQUEST_URI\'] is undefined');
        }
        
        $url .= $_SERVER['REQUEST_URI'];
        return $url;
    }
    
    /**
     * Check if the url is a permalink for a deed
     * 
     * @return boolean
     */
    public function isDeedDetail()
    {
        if (preg_match('/deeds\/[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}/', $this->url) === 1) {
            return true;
        }
        return false;
    }
    
    /**
     * Get the deed uuid from the url only use this if isDeedDetail returns true
     * 
     * @return string
     */
    public function getDeedUUID()
    {
        $matches = [];
        preg_match('/deeds\/(?P<uuid>[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12})/', $this->url, $matches);
        if (!empty($matches['uuid'])) {
            return $matches['uuid'];
        }
    }

    /**
     * Get current scheme
     * 
     * @return string
     */
    private function getCurrentScheme()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        return $protocol;
    }
}
