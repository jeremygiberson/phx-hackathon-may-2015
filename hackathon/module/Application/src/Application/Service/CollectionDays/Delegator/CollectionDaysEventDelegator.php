<?php


namespace Application\Service\CollectionDays\Delegator;


use Application\Service\CollectionDays\CollectionDay;
use Application\Service\CollectionDays\CollectionDaysInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;

class CollectionDaysEventDelegator implements CollectionDaysInterface
{
    const EVENT_PRE = 'pre.getCollectionDays';
    const EVENT_POST = 'post.getCollectionDays';

    /** @var  EventManager */
    protected $eventManager;

    /** @var  CollectionDaysInterface */
    protected $collectionDaysService;

    /**
     * CollectionDaysEventDelegator constructor.
     * @param CollectionDaysInterface $collectionDaysService
     */
    public function __construct(CollectionDaysInterface $collectionDaysService)
    {
        $this->collectionDaysService = $collectionDaysService;
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

    /**
     * @param string $address
     * @return CollectionDay[]
     */
    public function getCollectionDays($address)
    {
        $pre_event = new Event(self::EVENT_PRE, $this);
        $pre_event->setParam('address', $address);

        $results = $this->getEventManager()->trigger($pre_event);
        $last = $results->last();
        if($last !== null)
        {
            return $last;
        }

        $real_results = $this->collectionDaysService->getCollectionDays($address);

        $post_event = new Event(self::EVENT_POST, $this);
        $post_event->setParam('results', $real_results);
        $post_event->setParam('address', $address);

        $results = $this->getEventManager()->trigger($post_event);
        $last = $results->last();
        if($last !== null)
        {
            return $last;
        }

        return $real_results;
    }
}