<?php


namespace Application\Service\TwitterRest;


interface TwitterRestInterface
{
    /**
     * @param string $message
     */
    public function tweet($message);

    /**
     * @param int $status_id
     * @param string $status_user
     * @param string $message
     */
    public function reply($status_id, $status_user, $message);
}