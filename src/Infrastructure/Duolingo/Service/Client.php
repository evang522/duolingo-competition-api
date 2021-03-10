<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Service;

use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\Domain\Competition\Entity\HostAuth;
use App\Infrastructure\Duolingo\Model\UserInformation;
use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;

class Client
{
    private HttpClient $httpClient;

    public function __construct(
        HttpClient $httpClient
    )
    {
        $this->httpClient = $httpClient;
    }

    public function getTokenForHost(Host $host): string
    {
        $request = new Request('POST', 'https://www.duolingo.com/login', [], json_encode([
            'login' => $host->credentials()->username(),
            'password' => $host->credentials()->password()
        ], JSON_THROW_ON_ERROR));

        return $this->httpClient->sendRequest($request)->getHeader('jwt')[0];
    }

    public function getCompetitorInformation(Competitor $competitor, Host $host): UserInformation
    {

        // https://www.duolingo.com/2017-06-30/users/52146611?fields=name,streak,learningLanguage&_=1532406936067
        // https://www.duolingo.com/users/evang522

        //https://www.duolingo.com/2017-06-30/users/52146611?fields=name,streak,totalXp,learningLanguage,picture,username,email&_=1532406936067
        $request = new Request(
            'GET',
            'https://www.duolingo.com/2017-06-30/users/' . $competitor->duolingoId() . '?fields=name,streak,totalXp,learningLanguage,picture,username,email&_=1532406936067',
            [
                'Authorization' => 'Bearer ' . $host->credentials()->authToken()
            ]
        );

        $response = $this->httpClient->sendRequest($request);

        $body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return new UserInformation(
            $body['username'],
            (int)$body['totalXp'],
            $body['picture'],
            $body['learningLanguage']
        );


    }
}
