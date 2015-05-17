<?php


namespace Application\Service\TwitterStream\Listener;


use Application\Service\RefuseBot\RefuseBotInterface;
use Zend\EventManager\Event;

class MentionedInTweetListener
{
    /** @var  RefuseBotInterface */
    protected $refuseBotService;

    /**
     * MentionedInTweetListener constructor.
     * @param RefuseBotInterface $refuseBotService
     */
    public function __construct(RefuseBotInterface $refuseBotService)
    {
        $this->setRefuseBotService($refuseBotService);
    }


    /**
     * @return RefuseBotInterface
     */
    public function getRefuseBotService()
    {
        return $this->refuseBotService;
    }

    /**
     * @param RefuseBotInterface $refuseBotService
     * @return self
     */
    public function setRefuseBotService($refuseBotService)
    {
        $this->refuseBotService = $refuseBotService;
        return $this;
    }



    public function __invoke(Event $event)
    {
        if(($text = $event->getParam('text', null)) === null)
        {
            return;
        }

        try {
            $recommendations = $this->getRefuseBotService()->recommend($text);
        } catch (\Exception $e)
        {
            echo $e->getMessage();
        }

        var_dump($recommendations);
    }
}