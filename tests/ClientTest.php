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
        $json = file_get_contents(__DIR__ . '/deed.json');
        $body = \GuzzleHttp\Stream\Stream::factory($json);
        $mock = new \GuzzleHttp\Ring\Client\MockHandler([
            new \GuzzleHttp\Message\Response(200, [], $body)
        ]);
        
        $client = new \Picturae\Genealogy\Client($this->key);
        $client->getClient()->getEmitter($mock);
        
        $id = '0000b26c-76e8-0b20-9ebf-b9bb1776eae5';
        $deed = $client->getDeed($id);
        $this->assertEquals($deed->id, $id);
    }
}
