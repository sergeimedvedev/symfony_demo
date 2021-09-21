<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\Api\Common\RequestBodyTrait;
use App\Model\ApiSchema\Error\ValidationError;
use App\Model\ApiSchema\Profile\ProfileList;
use App\Model\Service\ProfileDataCheckingService;
use App\Model\Service\ProfileDataServiceInterface;
use App\Model\Service\ProfileFullServiceInterface;
use App\Model\Service\ProfileUpdateServiceInterface;
use App\Model\Service\UuidValidationService;
use App\Model\Service\UuidValidationServiceInterface;
use App\Util\ConstHelper;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JMS\Serializer\Exception\RuntimeException;
use LogicException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends BaseController
{
    use RequestBodyTrait;

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get list of maximum profile fields.
     * @Route("/profile", name="profile", methods={"GET"})
     *
     * @Operation(
     *     tags={"Profile"},
     *     summary="Get list of maximum profile fields",
     *     @OA\Response(
     *         response="200",
     *         description="HTTP OK",
     *         @Model(type=ProfileList::class)
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="HTTP UNAUTHORIZED",
     *         content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="message",
     *                          example=ConstHelper::MESSAGE_AUTHENTICATION_REQUIRED,
     *                          type="string",
     *                          description="Error description"
     *                      )
     *                  )
     *              )
     *         }
     *     )
     * )
     * @Security(name="Bearer")
     * @param ProfileFullServiceInterface $profileFullService
     * @return JsonResponse
     */
    public function profile(ProfileFullServiceInterface $profileFullService): JsonResponse
    {
        $profileList = $profileFullService->getAll();
        return new JsonResponse($profileList, ConstHelper::HTTP_STATUS_200);
    }

    /**
     * Update profile fields.
     * @Route("/search_requests/{searchRequestId}/profile", name="profileUpdate", methods={"PUT"})
     *
     * @Operation(
     *     tags={"Profile"},
     *     summary="Update profile fields",
     *     @OA\RequestBody(
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     additionalItems=true
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="HTTP OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="bool",
     *                     example=true,
     *                     description="Result of Search Request updating"
     *                 ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="HTTP UNAUTHORIZED",
     *         content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="message",
     *                          example=ConstHelper::MESSAGE_AUTHENTICATION_REQUIRED,
     *                          type="string",
     *                          description="Error description"
     *                      )
     *                  )
     *              )
     *         }
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="BAD REQUEST",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(ref=@Model(type=ValidationError::class)),
     *             )
     *         )
     *     )
     * )
     * @Security(name="Bearer")
     * @param string $searchRequestId
     * @param Request $request
     * @param UuidValidationServiceInterface $uuidValidationService
     * @param ProfileDataCheckingService $profileDataCheckingService
     * @param ProfileUpdateServiceInterface $profileUpdateService
     * @return JsonResponse
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws LogicException
     * @throws NotFoundHttpException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RuntimeException
     */
    public function profileUpdate(
        string $searchRequestId,
        Request $request,
        UuidValidationServiceInterface $uuidValidationService,
        ProfileDataCheckingService $profileDataCheckingService,
        ProfileUpdateServiceInterface $profileUpdateService
    ): JsonResponse {
        if (!$uuidValidationService->validate($searchRequestId)) {
            throw new NotFoundHttpException(ConstHelper::MESSAGE_PAGE_NOT_FOUND);
        }
        $partnerId = $this->getCurrentPartnerId();
        $params = $this->getJsonToArrayFromRequestBody($request);
        $violationList = $profileDataCheckingService->getCheckingResult($partnerId, $searchRequestId, $params);
        if (count($violationList) !== 0) {
            $responseStatus = ConstHelper::HTTP_STATUS_400;
            $responseResult = [
                'errors' => $violationList,
            ];
        } else {
            $responseStatus = ConstHelper::HTTP_STATUS_200;
            $responseResult = [
                'success' => $profileUpdateService->updateParamsByPartnersSearchRequest(
                    $partnerId,
                    $searchRequestId,
                    $params
                ),
            ];
        }
        return new JsonResponse($responseResult, $responseStatus);
    }

    /** Участок кода удалён */

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
