<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Service;

use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\UserInformation;
use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;

class Client
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCompetitorInformation(Competitor $competitor, Host $host): UserInformation
    {
        $request = new Request(
            'GET',
            'https://www.duolingo.com/2017-06-30/users/' . $competitor->duolingoId() . '?fields=name,streak,totalXp,learningLanguage,picture,username,streak',
            [
                'Authorization' => 'Bearer ' . $host->credentials()->authToken(),
            ]
        );

        $response = $this->httpClient->sendRequest($request);

        $body = \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);

        return new UserInformation(
            $body['username'],
            (int) $body['totalXp'],
            $body['picture'],
            $body['learningLanguage'],
            (int) $body['streak']
        );
    }
}
