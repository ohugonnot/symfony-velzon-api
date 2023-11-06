<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\File;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\directoryExists;

#[Route('/company')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'app_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('company/apps-crm-companies.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/test', name: 'app_company_indextest', methods: ['GET'])]
    public function test(): Response
    {
        return $this->render('charts-apex-area.html.twig', [
            'companies' => '',
        ]);
    }

    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $company = new Company();
        $files = new File();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('added_files');
            /** @var File $file */
            foreach ($files as $file) {
                $file = $file->getData();
                $uploadfile = $file->getFile();
                if (!$uploadfile) {
                    continue;
                }

                $fileSystem = new Filesystem();
                $submittedFile = $uploadfile->getClientOriginalName();
                $originalFilename = pathinfo($submittedFile, PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid('', false) . '.' . $uploadfile->guessExtension();
                $rootDirectory = './assets/uploads';
                $category = $file->getCategory();
                $targetDirectory = $rootDirectory . "/" . $category;
                $targetFile = $targetDirectory . '/' . $newFilename;

                if (!directoryExists($targetDirectory)) {
                    $fileSystem->mkdir($targetDirectory);
                }

                $fileSystem->copy($uploadfile, $targetFile);
                $file->setUrl($targetFile);
                $file->setFileName($newFilename);
                $file->setFileSize($uploadfile->getSize());
                $company->addFile($file);
            }

            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('added_files');
            /** @var File $file */
            foreach ($files as $file) {
                $file = $file->getData();
                $uploadfile = $file->getFile();
                if (!$uploadfile) {
                    continue;
                }

                $fileSystem = new Filesystem();
                $submittedFile = $uploadfile->getClientOriginalName();
                $originalFilename = pathinfo($submittedFile, PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid('', false) . '.' . $uploadfile->guessExtension();
                $rootDirectory = './assets/uploads';
                $category = $file->getCategory();
                $targetDirectory = $rootDirectory . "/" . $category;
                $targetFile = $targetDirectory . '/' . $newFilename;

                if (!directoryExists($targetDirectory)) {
                    $fileSystem->mkdir($targetDirectory);
                }

                $fileSystem->copy($uploadfile, $targetFile);
                $file->setUrl($targetFile);
                $file->setFileName($newFilename);
                $file->setFileSize($uploadfile->getSize());
                $company->addFile($file);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
