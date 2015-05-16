<?php


namespace Application\Service\CollectionDays;


use GuzzleHttp\Client;
use ZF\ApiProblem\ApiProblem;

class PhxGovCollectionDays implements CollectionDaysInterface
{
    const API_URL = 'https://apps-secure.phoenix.gov/fls/AddrSearch';

    /** @var  Client */
    protected $client;

    /**
     * @return Client
     */
    public function getClient()
    {
        if(!$this->client)
        {
            $this->client = new Client();
        }
        return $this->client;
    }

    /**
     * @param string $address
     * @return CollectionDay[]
     */
    public function getCollectionDays($address)
    {
        $response = $this->getClient()->get(self::API_URL, [
            'query' => [
                'address' => $address,
                'returnas' => 'json',
                'layers' => 'pw_collections'
            ]
        ]);

        if(!$response->getStatusCode() === 200)
        {
            return new ApiProblem('503', 'city of phoenix service not available',
                null, null, $response->getReasonPhrase());
        }

        $body = $response->getBody()->getContents();
        $json = json_decode($body, true);
        if(!isset($json['pw_collections'])){
            return new ApiProblem(400, 'Sorry that address is not serviced by Phoenix waste collection');
        }

        $days = [];
        foreach($json['pw_collections'] as $pickup)
        {
            foreach($pickup as $service => $day)
            {
                $days[] = new CollectionDay($day, $service);
            }
        }

        return $days;
    }
}