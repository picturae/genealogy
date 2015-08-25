<?php
namespace Test\Picturae\Genealogy;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $key = '509544d0-1c67-11e4-9016-c788dee409dc';
    
    public function testConstruct()
    {
        new \Picturae\Genealogy\Client($this->key);
    }
    
    public function testGetApiKey()
    {
        $client = new \Picturae\Genealogy\Client($this->key);
        $this->assertEquals($this->key, $client->getApiKey());
    }
    
    public function testGetDeed()
    {
        $json = file_get_contents(__DIR__ . '/result/deed.json');
        $body = \GuzzleHttp\Stream\Stream::factory($json);
        $mock = new \GuzzleHttp\Subscriber\Mock([
            new \GuzzleHttp\Message\Response(200, [], $body)
        ]);
        
        $client = new \Picturae\Genealogy\Client($this->key);
        $client->getClient()->getEmitter()->attach($mock);
        
        $id = '01792869-7556-f1ad-ef04-aacb0be11b49';
        $deed = $client->getDeed($id);
        $this->assertEquals($deed->id, $id);
    }
    
    public function testGetDeeds()
    {
        $json = file_get_contents(__DIR__ . '/result/deed-list.json');
        $body = \GuzzleHttp\Stream\Stream::factory($json);
        $mock = new \GuzzleHttp\Subscriber\Mock([
            new \GuzzleHttp\Message\Response(200, [], $body)
        ]);
        
        $client = new \Picturae\Genealogy\Client($this->key);        
        $client->getClient()->getEmitter()->attach($mock);
        
        $deeds = $client->getDeeds();
        $this->assertEquals(count($deeds->deed), 1);
    }
}
