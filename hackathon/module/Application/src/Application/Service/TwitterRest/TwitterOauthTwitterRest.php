<?php


namespace Application\Service\TwitterRest;


use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterOauthTwitterRest implements TwitterRestInterface
{
    /** @var  TwitterOAuth */
    protected $connection;

    /**
     * TwitterOauthTwitterRest constructor.
     * @param TwitterOAuth $connection
     */
    public function __construct(TwitterOAuth $connection)
    {
        $this->setConnection($connection);
    }

    /**
     * @return TwitterOAuth
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param TwitterOAuth $connection
     * @return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }



    /**
     * @param string $message
     * @return mixed
     */
    public function tweet($message)
    {
        return $this->getConnection()->post("statuses/update",
            [
                "status" => $message
            ]);
    }

    /**
     * @param int $status_id
     * @param string $status_user
     * @param string $message
     * @return mixed
     */
    public function reply($status_id, $status_user, $message)
    {
        if(!$status_id || !$status_user)
        {
            return $this->tweet($message);
        }

        return $this->getConnection()->post("statuses/update",
            [
                "status" => sprintf("@%s: %s", $status_user, $message),
                "in_reply_to_status_id" => $status_id
            ]);
    }
}