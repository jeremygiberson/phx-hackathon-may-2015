<?php


namespace Application\Service\RemindMe;


use Application\Service\CollectionDays\CollectionDay;
use RuntimeException;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\TableGateway\TableGateway;

class DbAdapterRemindMe implements RemindMeInterface, AdapterAwareInterface
{
    /** @var  Adapter */
    protected $adapter;

    /**
     * @param string $email
     * @param string $address
     * @param CollectionDay[] $days
     */
    public function subscribe($email, $address, $days)
    {
        try {
            $subscription = new TableGateway('subscription', $this->adapter);
            $id = $subscription->insert([
                'email' => $email,
                'address' => $address
            ]);
        } catch (InvalidQueryException $e){
            // catch duplicate insert for already subscribed
            if(strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
                throw new RuntimeException('Email/address is already subscribed');
            } else {
                // don't know what this is
                throw $e;
            }
        }

        foreach($days as $day)
        {
            $reminder = new TableGateway('reminder', $this->adapter);
            $reminder->insert([
                'subscription_id' => $id,
                'day' => $day->getDay(),
                'service' => $day->getService()
            ]);
        }
    }

    /**
     * @param string $email
     * @param string $address
     */
    public function unsubscribe($email, $address)
    {
        $subscription = new TableGateway('subscription', $this->adapter);
        $subscription->delete([
            'address' => $address,
            'email' => $email
        ]);
    }

    /**
     * Set db adapter
     *
     * @param Adapter $adapter
     * @return AdapterAwareInterface
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}