<?php
namespace Picturae\Genealogy;

/**
 * Picturae webkitchen client for genealogy
 * This client allows you to query the API servside
 */
class Client
{
    /**
     * Path where the API is located
     * 
     * @var string
     */
    private $path = 'genealogy';
    
    /**
     * Client default options
     * 
     * @var array
     */
    private $options = [
        'base_url' => 'https://webservices.picturae.com',
        'defaults' => [
            'headers' => [
                'apiKey' => '{apiKey}'
            ]
        ]
    ];
    
    /**
     * Genealogy API key
     * @var string
     */
    private $apiKey;
    
    /**
     * HTTP Client
     * @var \GuzzleHttp\Client 
     */
    private $client;
    
    /**
     * Instantiate genealogy client
     * 
     * @param string $apiKey Your webkitchen API key
     * @param array $options Options override
     */
    public function __construct($apiKey, $options = null)
    {
        $this->apiKey = $apiKey;
        if ($options) {
            $this->options = array_merge($this->options, $options);
        }
    }
    
    /**
     * Get API key
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    /**
     * Get deed by uuid
     * 
     * @param string $uuid
     * @return stdClass|null
     */
    public function getDeed($uuid)
    {
        $response = $this->getClient()->get($this->path . '/deed/' . $uuid);
        $body = json_decode($response->getBody()->getContents());
        
        if (isset($body->deed[0])) {
            return $body->deed[0];
        }
    }

    /**
     * Get HTTP client
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }
        
        $config = $this->options;
        $config['defaults']['headers']['apiKey'] = $this->apiKey;
        $this->client = new \GuzzleHttp\Client($config);
        
        return $this->client;
    }
}
