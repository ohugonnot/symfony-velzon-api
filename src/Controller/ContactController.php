<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/apps-crm-contacts.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagForm = $form->getData();
            $submittedTags = $tagForm->getTags();
            if ($submittedTags) {
//                dd($submittedTags);
                foreach ($submittedTags as $tag) {
                    $contact->addTag($tag);

                }
            }
            $newTags = $form->get('newtags')->getData();
            if ($newTags) {
                foreach ($newTags as $newTag) {
                    $contact->addTag($newTag);
                }
            }
            $companiesForm = $form->getData();
            $submittedCompanies = $companiesForm->getCompanies();
            if ($submittedCompanies) {
//                dd($submittedTags);
                foreach ($submittedCompanies as $submittedCompany) {
                    $contact->addCompany($submittedCompany);

                }
            }
            $newCompanies = $form->get('newcompanies')->getData();
            if ($newCompanies) {
                foreach ($newCompanies as $newCompany) {
                    $contact->addCompany($newCompany);
                }
            }
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Cascading save of selected and updated Tag entities
            $formDatas = $form->getData();

            $submittedTags = $formDatas->getTags();
            if ($submittedTags) {
                foreach ($submittedTags as $tag) {
                    $contact->addTag($tag);
//                    dd($contact);

                }
            }
            $newTags = $form->get('newtags')->getData();
            if ($newTags) {
                foreach ($newTags as $newTag) {
                    $contact->addTag($newTag);
//                    dd($contact);
                }
            }
            // Cascading save of selected and updated Company entities

            $submittedCompanies = $form->get('companies')->getData();
            if ($submittedCompanies) {
                foreach ($submittedCompanies as $company) {
//                    dd($submittedCompanies->isDirty());
                    $contact->addCompany($company);
                    $entityManager->persist($company);
//                    dd($contact);
                }
            }
//            dd($contact);

            $newCompanies = $form->get('newcompanies')->getData();
            if ($newCompanies) {
                foreach ($newCompanies as $company) {
                    $contact->addCompany($company);
                    $entityManager->persist($company);
//                    dd($contact);
                }
            }

//            dd($contact);

            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
