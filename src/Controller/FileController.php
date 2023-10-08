<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\StoredFileType;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\directoryExists;

#[Route('/file')]
class FileController extends AbstractController
{
    #[Route('/', name: 'app_file_index', methods: ['GET'])]
    public function index(FileRepository $fileRepository): Response
    {
        //we load files and Finder tools
        //

        $allFiles = $fileRepository->findAll();
        $finder = new Finder();

        //we define files directories
        $mediasDirectory = './assets/uploads/Media';
        $documentsDirectory = './assets/uploads/Documents';
        $recentsDirectory = './assets/uploads/Recent';
        $importantsDirectory = './assets/uploads/Important';
        $deletedDirectory = './assets/uploads/Deleted';

        //we count files in each folder to render it
        $nbOfMediaFiles = 0;
        $nbOfDocumentFiles = 0;
        $nbOfRecentFiles = 0;
        $nbOfImportantFiles = 0;
        $nbOfDeletedFiles = 0;

        if (is_dir($mediasDirectory)) {
            $nbOfMediaFiles = $finder->in($mediasDirectory)->files()->count();
        }
        if (is_dir($documentsDirectory)) {

            $nbOfDocumentFiles = $finder->in($documentsDirectory)->files()->count();
        }
//        dd($finder->in($documentsDirectory)->files()->count());

        if (is_dir($recentsDirectory)) {
            $nbOfRecentFiles = $finder->in($recentsDirectory)->files()->count();
        }

        if (is_dir($importantsDirectory)) {
            $nbOfImportantFiles = $finder->in($importantsDirectory)->files()->count();
        }
        if (is_dir($deletedDirectory)) {
            $nbOfDeletedFiles = $finder->in($deletedDirectory)->files()->count();
        }

        //

        return $this->render('yann/filemanager.html.twig', [
            'files' => $fileRepository->findAll(),
            'mediaFiles' => $nbOfMediaFiles,
            'docFiles' => $nbOfDocumentFiles,
            'recentFiles' => $nbOfRecentFiles,
            'deletedFiles' => $nbOfDeletedFiles,
        ]);
    }

    #[Route('/new', name: 'app_file_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileRepository $fileRepository, SluggerInterface $slugger): Response
    {
        $file = new File();
        $form = $this->createForm(StoredFileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //init of filesystem
            $fileSystem = new Filesystem();

            //we handle uploaded file name and copy it to uploads directory
            //
            //
            //renaming
            $submittedFile = $form->get('url')->getData();
            $originalFilename = pathinfo($submittedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid('', false) . '.' . $submittedFile->guessExtension();
//            dd($safeFilename, $originalFilename, $newFilename);


            //if it doesn't exists, we create the directory
            //named as file->category

            $rootDirectory = './assets/uploads';
            $category = $file->getCategory();
            $targetDirectory = $rootDirectory . $category;
            $targetFile = $targetDirectory . '/' . $newFilename;

            if (!directoryExists($targetDirectory)) {
                $fileSystem->mkdir($targetDirectory);
            }

            //now we can copy the new file in the right folder
            $fileSystem->copy($form->get('url')->getData(), $targetFile);


            //setting new file url
            $file->setUrl($targetFile);
            $file->setFileName($newFilename);

            //setting new file size
            $finder = new Finder();
            $finder->files()->name($newFilename)->in($targetDirectory);

            foreach ($finder as $fileItem) {

                $fileSize = $fileItem->getSize();
                $file->setFileSize($fileSize);
            }

            $fileRepository->save($file, true);

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_show', methods: ['GET'])]
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, File $file, FileRepository $fileRepository): Response
    {
        $form = $this->createForm(StoredFileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileRepository->save($file, true);

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_delete', methods: ['POST'])]
    public function delete(Request $request, File $file, FileRepository $fileRepository): Response
    {
        $fileSystem = new Filesystem();
        $fileUrl = $file->getUrl();
        $fileSystem->remove($fileUrl);
        $fileRepository->remove($file, true);

        return $this->json(['success' => true], Response::HTTP_OK);
    }
}
