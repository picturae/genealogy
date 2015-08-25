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

    /**
     * Get deeds result set
     *
     * @param array $query
     * @return \stdClass
     */
    public function getDeeds($query);

    /**
     * Get deed by id
     *
     * @param string $uuid
     * @return \stdClass|null
     */
    public function getPerson($uuid);

    /**
     * Get persons result set
     *
     * @param array $query
     * @return \stdClass
     */
    public function getPersons($query);

    /**
     * Get deed by id
     *
     * @param string $uuid
     * @return \stdClass|null
     */
    public function getRegister($uuid);

    /**
     * Get deed result set
     *
     * @param array $query
     * @return \stdClass
     */
    public function getRegisters($query);

    /**
     * Get api key
     *
     * @return string
     */
    public function getApiKey();
}
