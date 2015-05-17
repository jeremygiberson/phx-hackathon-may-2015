<?php


namespace Application\Service\Queue;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpQueue implements QueueInterface
{
    /** @var  string */
    protected $queueName;
    /** @var  AMQPConnection */
    protected $connection;
    /** @var  AMQPChannel */
    protected $channel;

    /**
     * AmqpQueue constructor.
     * @param AMQPConnection $connection
     */
    public function __construct($queueName, AMQPConnection $connection)
    {
        $this->setQueueName($queueName);
        $this->setConnection($connection);
    }

    /**
     * @return AMQPConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param AMQPConnection $connection
     * @return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
        $this->channel->queue_declare($this->getQueueName(), false, true);
        return $this;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @param string $queueName
     * @return self
     */
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;


        return $this;
    }

    public function produce($message)
    {
        $this->channel->basic_publish(new AMQPMessage($message), '', $this->getQueueName());
    }

    public function consume($callback)
    {
        $this->channel->basic_consume($this->getQueueName(), '', false, true, false, false, $callback);
        while(count($this->channel->callbacks)){
            $this->channel->wait();
        }
    }
}