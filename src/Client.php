<?php
namespace Picturae\Genealogy;

/**
 * Picturae webkitchen client for genealogy
 * This client allows you to query the API servside
 */
class Client implements ClientInterface
{
    /**
     * Used to fetch the register part of the API
     */
    const TYPE_REGISTER = 'register';
    
    /**
     * Used to fetch the deed part of the API
     */
    const TYPE_DEED = 'deed';
    
    /**
     * Used to fetch the person part of the API
     */
    const TYPE_PERSON = 'person';
    
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
     * Instantiate genealogy client.
     * To override the api url for testing purpose you can use the options parameter for the override
     * <code>
     * new Client('some-key', [
     *  'base_url' => 'http://example.com'
     * ]);
     * </code>
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
        return $this->getDetail($uuid, self::TYPE_DEED);
    }
    
    /**
     * Get person by uuid
     * 
     * @param string $uuid
     * @return stdClass|null
     */
    public function getPerson($uuid)
    {
        return $this->getDetail($uuid, self::TYPE_PERSON);
    }

    /**
     * Get register by uuid
     * 
     * @param string $uuid
     * @return stdClass|null
     */
    public function getRegister($uuid)
    {
        return $this->getDetail($uuid, self::TYPE_REGISTER);
    }
    
    /**
     * Get registers result set
     * all parameters are optional
     * 
     * self:;getDeeds([
     *  'q' => 'something', // search query
     *  'rows' => 100,      // amount of rows to return
     *  'page' => 1,        // page to return
     *  'facetFields' => [  // facet's to return
     *    'search_s_place'
     *  ],
     *  'fq' => [
     *    'search_s_place: "Amsterdam"' // apply filter query
     *  ],
     *  'sort' => 'search_s_place asc'   // sort result set (default by relevance)
     * ]);
     * 
     * @param array $query
     * @return \stdClass
     */
    public function getRegisters($query = [])
    {
        return $this->getList(self::TYPE_REGISTER, $query);
    }
    
    /**
     * Get deeds result set
     * all parameters are optional
     * 
     * self:;getDeeds([
     *  'q' => 'something', // search query
     *  'rows' => 100,      // amount of rows to return
     *  'page' => 1,        // page to return
     *  'facetFields' => [  // facet's to return
     *    'search_s_place'
     *  ],
     *  'fq' => [
     *    'search_s_place: "Amsterdam"' // apply filter query
     *  ],
     *  'sort' => 'search_s_place asc'   // sort result set (default by relevance)
     * ]);
     * 
     * @param array $query
     * @return \stdClass
     */
    public function getDeeds($query = [])
    {
        return $this->getList(self::TYPE_DEED, $query);
    }
    
    /**
     * Get persons result set
     * all parameters are optional
     * 
     * self:;getDeeds([
     *  'q' => 'something', // search query
     *  'rows' => 100,      // amount of rows to return
     *  'page' => 1,        // page to return
     *  'facetFields' => [  // facet's to return
     *    'search_s_place'
     *  ],
     *  'fq' => [
     *    'search_s_place: "Amsterdam"' // apply filter query
     *  ],
     *  'sort' => 'search_s_place asc'   // sort result set (default by relevance)
     * ]);
     * 
     * @param array $query
     * @return \stdClass
     */
    public function getPersons($query = [])
    {
        return $this->getList(self::TYPE_PERSON, $query);
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
    
    /**
     * Get result list
     * all parameters are optional
     * 
     * self::getList[
     *  'q' => 'something', // search query
     *  'rows' => 100,      // amount of rows to return
     *  'page' => 1,        // page to return
     *  'facetFields' => [  // facet's to return
     *    'search_s_place'
     *  ],
     *  'fq' => [
     *    'search_s_place: "Amsterdam"' // apply filter query
     *  ],
     *  'sort' => 'search_s_place asc'   // sort result set (default by relevance)
     * ]);
     * 
     * @param string $type
     * @param array $query
     * @return \stdClass
     */
    public function getList($type, $query = [])
    {
        $response = $this->getClient()->get($this->path . '/' . $type . '/', ['query' => $query]);
        $body = json_decode($response->getBody()->getContents());
        return $body;
    }
    
    /**
     * Get deed by uuid
     * 
     * @param string $uuid
     * @param string $type a genealogy type
     * @return stdClass|null
     */
    private function getDetail($uuid, $type)
    {
        $response = $this->getClient()->get($this->path . '/' . $type . '/' . $uuid);
        $body = json_decode($response->getBody()->getContents());
        
        if (isset($body->{$type}[0])) {
            return $body->{$type}[0];
        }
    }
}
