<?php


namespace Application\Service\RemindMe;


use Application\Service\CollectionDays\CollectionDay;

interface RemindMeInterface
{
    /**
     * @param string $email
     * @param string $address
     * @param CollectionDay[] $days
     */
    public function subscribe($email, $address, $days);

    /**
     * @param string $email
     * @param string $address
     */
    public function unsubscribe($email, $address);

}