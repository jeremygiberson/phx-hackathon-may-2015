<?php


namespace Application\Service\Queue;


interface QueueInterface
{
    /**
     * @param string $message
     */
    public function produce($message);

    /**
     * @param callable $callback
     */
    public function consume($callback);
}