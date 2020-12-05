<?php

namespace Api\Controller;

use Api\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends AbstractController
{
    public function random(): JsonResponse
    {
        $imageRepository = $this->getDoctrine()->getRepository(Image::class);

        $image = $imageRepository->random();

        if (! $image) {
            throw $this->createNotFoundException('Image not found.');
        }

        return new JsonResponse([
            'data' => $image->toArray(),
        ]);
    }
}
