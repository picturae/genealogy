<?php
namespace Picturae\Genealogy;

interface ClientInterface
{
    /**
     * Get deed by id
     * 
     * @param string $uuid
     * @return \stdClass|null
     */
    public function getDeed($uuid);
}
