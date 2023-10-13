<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/loan')]
class LoanCalculatorController extends AbstractController
{
    #[Route('/', name: 'app_loan_calculator', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('yann/loan-calculator.html.twig');
    }

}
