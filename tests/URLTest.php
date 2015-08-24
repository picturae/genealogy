<?php
namespace Test\Picturae\Genealogy;

class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Current URL Cannot be build from CLI
     * 
     * @expectedException \Picturae\Genealogy\Exception\RuntimeException
     */
    public function testInvalidURL()
    {
        new \Picturae\Genealogy\URL();
    }
    
    /**
     * Test invalid url
     * 
     * @expectedException \Picturae\Genealogy\Exception\InvalidArgumentException
     */
    public function testInvalidArgumentURL()
    {
        new \Picturae\Genealogy\URL('foo');
    }
    
    public function testCurrentURL()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5';
        $url = new \Picturae\Genealogy\URL();
        $this->assertEquals('http://example.com/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', $url->getCurrentURL());
    }
    
    public function testGetURL()
    {
        $url = new \Picturae\Genealogy\URL('http://example.com/foo/bar');
        $this->assertEquals('http://example.com/foo/bar', $url->getURL());
    }
    
    /**
     * Test deed permalink
     */
    public function testIsDeedDetail()
    {
        $url = new \Picturae\Genealogy\URL('http://example.com/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5');
        $this->assertEquals(true, $url->isDeedDetail());
        
        $url2 = new \Picturae\Genealogy\URL('http://example.com/deed/0000b26c-76e8-0b20-9ebf-b9bb1776eae5');
        $this->assertEquals(false, $url2->isDeedDetail());
    }
    
    /**
     * @dataProvider urlProvider
     */
    public function testGetDeedUUID($url, $expected)
    {
        $gen = new \Picturae\Genealogy\URL($url);
        $this->assertEquals($expected, $gen->getDeedUUID());
    }
    
    /**
     * Provide test data for url's
     * 
     * @return array
     */
    public function urlProvider()
    {
        return [
            'correct permalink' => ['http://example.com/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'correct permalink with extra path' => ['http://example.com/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5/foo', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'correct permalink with extra path and query' => ['http://example.com/deeds/0000b26c-76e8-0b20-9ebf-b9bb1776eae5?foo=bar', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'incorrect permalink' => ['http://example.com/deed/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', null],
        ];
    }
}
