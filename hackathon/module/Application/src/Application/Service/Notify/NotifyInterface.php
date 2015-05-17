<?php


namespace Application\Service\Notify;


interface NotifyInterface
{
    /**
     * @param string $address
     * @param string $subject
     * @param string $message
     */
    public function notify($address, $subject, $message);
}