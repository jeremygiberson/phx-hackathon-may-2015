<?php


namespace Application\Service\TwitterStream\Listener;


use Zend\EventManager\Event;
use Zend\EventManager\EventManager;

class TwitterQueueListener
{
    /** @var  EventManager */
    protected $eventManager;

    /**
     * TwitterQueueListener constructor.
     * @param EventManager $eventManager
     */
    public function __construct(EventManager $eventManager)
    {
        $this->setEventManager($eventManager);
    }

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @param EventManager $eventManager
     * @return self
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }



    public function __invoke($message)
    {
        $status = json_decode($message->body, true);

        $event = new Event('twitter.event', $this, $status);

        $this->getEventManager()->trigger($event);
    }
}