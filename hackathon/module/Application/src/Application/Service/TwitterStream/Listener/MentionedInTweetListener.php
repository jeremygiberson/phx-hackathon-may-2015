<?php


namespace Application\Service\TwitterStream\Listener;


use Application\Service\RefuseBot\RefuseBotInterface;
use Application\Service\TwitterRest\TwitterRestInterface;
use Zend\EventManager\Event;

class MentionedInTweetListener
{
    /** @var  RefuseBotInterface */
    protected $refuseBotService;

    /** @var  TwitterRestInterface */
    protected $twitterRestService;

    /**
     * @param RefuseBotInterface $refuseBotService
     * @param TwitterRestInterface $twitterRestService
     */
    public function __construct(RefuseBotInterface $refuseBotService,
                                TwitterRestInterface $twitterRestService)
    {
        $this->setRefuseBotService($refuseBotService);
        $this->setTwitterRestService($twitterRestService);
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

    /**
     * @return TwitterRestInterface
     */
    public function getTwitterRestService()
    {
        return $this->twitterRestService;
    }

    /**
     * @param TwitterRestInterface $twitterRestService
     * @return self
     */
    public function setTwitterRestService($twitterRestService)
    {
        $this->twitterRestService = $twitterRestService;
        return $this;
    }


    public function __invoke(Event $event)
    {
        if(($text = $event->getParam('text', null)) === null)
        {
            return;
        }

        $status_id = $event->getParam('id',null);
        $status_user = $event->getParam('user', ['screen_name' => null]);
        $status_screen_name = $status_user['screen_name'];

        try {
            $recommendations = $this->getRefuseBotService()->recommend($text);
        } catch (\Exception $e)
        {
            $this->getTwitterRestService()->reply(
                $status_id,
                $status_screen_name,
                $e->getMessage());
            return;
        }


        foreach($recommendations as $recommendation)
        {
            $this->getTwitterRestService()->reply(
                $status_id,
                $status_screen_name,
                sprintf("To dispose of %s, please %s",
                    $recommendation->getNoun(),
                    $recommendation->getInstructions()));
        }
    }
}