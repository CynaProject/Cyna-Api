<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageController extends AbstractController
{
    private $params;

    // Injection du service ParameterBagInterface pour accéder aux paramètres définis
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/upload-image', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(Request $request): Response
    {
        // Récupérer l'URL de l'application depuis la configuration
        $appUrl = $this->params->get('app_url');
        
        $data = json_decode($request->getContent(), true);
        
        // Vérifier si le type d'image est spécifié
        if (!isset($data['image']) || !isset($data['type'])) {
            return new Response('No image or type provided', Response::HTTP_BAD_REQUEST);
        }

        $base64Image = $data['image'];
        $imageType = $data['type'];  // carrousel, products, categories
        $imageData = base64_decode($base64Image);
        
        if ($imageData === false) {
            return new Response('Failed to decode base64 image', Response::HTTP_BAD_REQUEST);
        }

        // Définir le répertoire en fonction du type d'image
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/images/';
        $subDir = $imageType;  // carrousel, products, categories
        $finalDir = $uploadDir . $subDir . '/';

        // Assurer que le répertoire existe
        $filesystem = new Filesystem();
        if (!$filesystem->exists($finalDir)) {
            $filesystem->mkdir($finalDir);
        }

        // Créer un nom d'image unique
        $imageName = $imageType . '_' . time() . '.png';
        $filePath = $finalDir . $imageName;
        
        try {
            file_put_contents($filePath, $imageData);
        } catch (\Exception $e) {
            return new Response('Failed to save image: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Retourner l'URL de l'image téléchargée
        return new Response(json_encode(['url' => $imageName]), Response::HTTP_OK);
    }
}


