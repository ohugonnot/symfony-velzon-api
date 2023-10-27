<?php

namespace App\Controller;

use App\Repository\ObjectifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    public function __construct(Environment $twig)
    {
        $this->loader = $twig->getLoader();
    }

    #[Route('/', name: 'home')]
    public function index(ObjectifRepository $objectifRepository): Response
    {
        return $this->render('yann/charts-apex-line.html.twig', [
            'objectifs' => $objectifRepository->findAll(),
        ]);
    }

    #[Route('/{path}', priority: -1)]
    public function root($path)
    {
        if ($this->loader->exists($path . '.html.twig')) {
            if ($path == '/' || $path == 'home' || $path == 'index') {
                return $this->render('index.html.twig');
            }
            return $this->render($path . '.html.twig');
        }
        throw $this->createNotFoundException();
    }

//    #[Route('/assets/uploads/Documents/{name}', name: 'app_file_delete', methods: ['GET'])]
//    public function downloadfile(Request $request): Response
//    {
//        dd("ici");
//    }
}
