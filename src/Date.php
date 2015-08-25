<?php
namespace Picturae\Genealogy;

/**
 * Helper to format date's normally returned as int by the genealogy API
 * The format of the returned date is YYYYMMDD
 */
class Date {
    
    /**
     * @var int
     */
    private $date;
    
    /**
     * Format type 
     */
    const FORMAT_DD_MM_YYYY = 'dd-mm-yyyy';
    
    /**
     * Format type
     */
    const FORMAT_YYYY_MM_DD = 'yyyy-mm-dd';
    
    /**
     * @param int $date Date returned by genealogy API as YYYYMMDD
     */
    public function __construct($date)
    {
        $this->date = $date;
    }        
    
    /**
     * Format the date
     * 
     * @param string $type
     * @param string $seperator
     * @return string
     */
    public function getFormat($type = self::FORMAT_DD_MM_YYYY, $seperator = '-')
    {
        switch ($type) {
            case self::FORMAT_DD_MM_YYYY:                
                return substr($this->date, 6, 2) . $seperator . substr($this->date, 4, 2) . $seperator . substr($this->date, 0, 4);
                break;
            case self::FORMAT_YYYY_MM_DD:
                return substr($this->date, 0, 4) . $seperator . substr($this->date, 4, 2) . $seperator . substr($this->date, 6, 2);
                break;
            default:
                throw new Exception\Date\InvalidArgumentException('Invalid format :' . $type);
                break;
        }
    }    
}