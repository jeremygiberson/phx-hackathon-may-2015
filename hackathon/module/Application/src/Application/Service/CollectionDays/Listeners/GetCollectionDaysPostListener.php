<?php


namespace Application\Service\CollectionDays\Listeners;


use Zend\Cache\Storage\StorageInterface;
use Zend\EventManager\Event;

class GetCollectionDaysPostListener
{
    /** @var StorageInterface */
    protected $cache;

    /**
     * GetCollectionDaysPostListener constructor.
     * @param StorageInterface $cache
     */
    public function __construct(StorageInterface $cache)
    {
        $this->cache = $cache;
    }


    public function __invoke(Event $e)
    {
        $address = $e->getParam('address', null);
        $results = $e->getParam('results', []);
        $key = md5($address);
        $this->cache->setItem($key, $results);
    }
}