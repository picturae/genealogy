<?php
namespace Test\Picturae\Genealogy;

use PHPUnit_Framework_TestCase;
use Picturae\Genealogy\Date;

class DateTest extends PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $date = 20121012;
        $gdate = new Date($date);
        
        $this->assertEquals('12-10-2012', $gdate->getFormat(Date::FORMAT_DD_MM_YYYY));
        
        $this->assertEquals('2012-10-12', $gdate->getFormat(Date::FORMAT_YYYY_MM_DD));
        
        $this->assertEquals('2012/10/12', $gdate->getFormat(Date::FORMAT_YYYY_MM_DD, '/'));
    }
}
