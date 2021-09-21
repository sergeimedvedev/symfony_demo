<?php

declare(strict_types=1);

namespace App\Controller\Api\Common;

use App\Util\ConstHelper;
use JsonException;
use LogicException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

trait RequestBodyTrait
{
    abstract protected function getLogger(): LoggerInterface;

    /**
     * @param Request $request
     * @return array
     * @throws BadRequestException
     * @throws LogicException
     */
    protected function getJsonToArrayFromRequestBody(Request $request): array
    {
        try {
            return json_decode(
                $request->getContent(),
                true,
                ConstHelper::JSON_DEFAULT_RECURSION_DEPTH,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            $errorMessage = ConstHelper::MESSAGE_BAD_JSON;
            $this->getLogger()->notice(
                $errorMessage,
                [
                    'category' => 'api.requestBody',
                    'trace'    => $exception->getTraceAsString(),
                    'headers'  => $request->headers->all(),
                    'content'  => $request->getContent(),
                ]
            );
            throw new BadRequestException($errorMessage);
        }
    }
}
