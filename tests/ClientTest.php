<?php
namespace Test\Picturae\Genealogy;

class ClientTest extends \PHPUnit\Framework\TestCase
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
        $response = new \GuzzleHttp\Psr7\Response('200', [], __DIR__ . '/result/deed.json');
        $handler = new \GuzzleHttp\Handler\MockHandler([
            $response
        ]);
        
        $client = new \Picturae\Genealogy\Client($this->key, [
            'handle' => $handler
        ]);

        $id = '01792869-7556-f1ad-ef04-aacb0be11b49';
        $deed = $client->getDeed($id);
        $this->assertEquals($deed->id, $id);
    }

    public function testGetDeeds()
    {
        $response = new \GuzzleHttp\Psr7\Response('200', [], __DIR__ . '/result/deed-list.json');
        $handler = new \GuzzleHttp\Handler\MockHandler([
            $response
        ]);
        
        $client = new \Picturae\Genealogy\Client($this->key, [
            'handle' => $handler
        ]);

        $deeds = $client->getDeeds();
        $this->assertEquals(count($deeds->deed), 100);        
    }
}
