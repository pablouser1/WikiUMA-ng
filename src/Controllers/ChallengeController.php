<?php

namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use AltchaOrg\Altcha\ChallengeOptions;
use App\Wrappers\Env;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ChallengeController
{
    public static function index(ServerRequestInterface $request): Response
    {
        $altcha = new Altcha(Env::app_key());

        $options = new ChallengeOptions(
            maxNumber: 50000, // the maximum random number
            expires: (new \DateTimeImmutable())->add(new \DateInterval('PT10S')),
        );

        $challenge = $altcha->createChallenge($options);

        return new JsonResponse($challenge);
    }
}
