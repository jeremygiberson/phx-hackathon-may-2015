<?php


namespace Application\Service\RemindMe;


use Application\Service\CollectionDays\CollectionDay;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
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
        $subscription = new TableGateway('subscription', $this->adapter);
        $id = $subscription->insert([
            'email' => $email,
            'address' => $address
        ]);

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
     * @param string $address
     * @param string $email
     */
    public function unsubscribe($address, $email)
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