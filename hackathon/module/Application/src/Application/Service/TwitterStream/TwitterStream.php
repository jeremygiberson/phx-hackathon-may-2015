<?php


namespace Application\Service\TwitterStream;


use Application\Service\Queue\QueueInterface;
use UserstreamPhirehose;

class TwitterStream extends UserstreamPhirehose
{
    /** @var  QueueInterface */
    protected $queue;

    /**
     * @return QueueInterface
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param QueueInterface $queue
     * @return self
     */
    public function setQueue($queue)
    {
        $this->queue = $queue;
        return $this;
    }

    public function enqueueStatus($status)
    {

        $data = json_decode($status, true);
        echo date("Y-m-d H:i:s (").strlen($status)."):".print_r($data,true)."\n";

        $this->getQueue()->produce($status);
    }
}