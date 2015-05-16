<?php


namespace Application\Service\CollectionDays;


interface CollectionDaysInterface
{
    /**
     * @param string $address
     * @return CollectionDay[]
     */
    public function getCollectionDays($address);
}