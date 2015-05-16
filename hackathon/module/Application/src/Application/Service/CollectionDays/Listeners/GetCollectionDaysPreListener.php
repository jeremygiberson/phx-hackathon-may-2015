<?php


namespace Application\Service\CollectionDays\Listeners;


use Zend\Cache\Storage\StorageInterface;
use Zend\EventManager\Event;

class GetCollectionDaysPreListener
{
    /** @var  StorageInterface */
    protected $cache;

    /**
     * GetCollectionDaysPreListener constructor.
     * @param StorageInterface $cache
     */
    public function __construct(StorageInterface $cache)
    {
        $this->cache = $cache;
    }


    public function __invoke(Event $e)
    {
        $address = $e->getParam('address', null);
        $key = md5($address);
        if($this->cache->hasItem($key)){
            return $this->cache->getItem($key);
        }
    }
}