<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractApiController extends AbstractController
{
    private const API_FORMAT = 'json';

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function buildObject(string $className, Request $request): object
    {
        return $this->serializer->deserialize($request->getContent(), $className, self::API_FORMAT);
    }

    protected function buildResponse(?object $object, int $status = Response::HTTP_OK): Response
    {
        return new JsonResponse(
            $this->serializer->serialize($object, self::API_FORMAT),
            $status,
            [],
            true
        );
    }
}
