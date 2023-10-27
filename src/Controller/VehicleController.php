<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\EmployeeRepository;
use App\Repository\VehiclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\directoryExists;

#[Route('/vehicle')]
class VehicleController extends AbstractController
{
    #[Route('/', name: 'app_vehicle_index', methods: ['GET'])]
    public function index(VehiclesRepository $vehiclesRepository): Response
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('assets/images/brands/bitbucket2.png');

        //test de requete dql
        //        $table = $vehiclesRepository->getVehiclesByImmat();
        //        dd($table);


        return $this->render('yann/basic-datatable.html.twig', [
            'vehicles' => $vehiclesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehicle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiclesRepository $vehiclesRepository, EmployeeRepository $employeeRepo, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

//        if ($form->isSubmitted()) {
//            dd($vehicle);
//        }

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($form);
            $files = $form->get('uploaded_files');
            /** @var File $file */
            foreach ($files as $file) {
                $file = $file->getData();
                $uploadfile = $file->getFile();
//                dd($uploadfile);
                if (!$uploadfile) {
                    continue;
                }

                $fileSystem = new Filesystem();
                $submittedFile = $uploadfile->getClientOriginalName();
                $originalFilename = pathinfo($submittedFile, PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid('', false) . '.' . $uploadfile->guessExtension();
                $rootDirectory = './assets/uploads';
                $category = 'Vehicles';
                $targetDirectory = $rootDirectory . "/" . $category;
                $targetFile = $targetDirectory . '/' . $newFilename;

                if (!directoryExists($targetDirectory)) {
                    $fileSystem->mkdir($targetDirectory);
                }

                $fileSystem->copy($uploadfile, $targetFile);
                $file->setUrl($targetFile);
                $file->setFileName($newFilename);
                $file->setCategory('Vehicles');
                $file->setFileSize($uploadfile->getSize());
                $vehicle->addFile($file);
//                dd($vehicle);
            }

            $entityManager->persist($vehicle);
            $entityManager->flush();
//            $vehiclesRepository->save($vehicle, true);

            return $this->redirectToRoute('app_vehicle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yann/vehicle-form.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
            'employees' => $employeeRepo
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_show', methods: ['GET'])]
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehicle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicle $vehicle, VehiclesRepository $vehiclesRepository): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiclesRepository->save($vehicle, true);

            return $this->redirectToRoute('app_vehicle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicle $vehicle, VehiclesRepository $vehiclesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vehicle->getId(), $request->request->get('_token'))) {
            $vehiclesRepository->remove($vehicle, true);
        }

        return $this->redirectToRoute('app_vehicle_index', [], Response::HTTP_SEE_OTHER);
    }
}
