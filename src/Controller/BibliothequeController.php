<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreFormType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BibliothequeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'Accueil')]
    public function index(LivreRepository $LivreRepository): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'livres' => $LivreRepository->findAll(),
        ]);
    }

    #[Route('/liste', name: 'bibliotheque')]
    public function liste(LivreRepository $LivreRepository): Response
    {
        return $this->render('bibliotheque/liste.html.twig', [
            'livres' => $LivreRepository->findAll(),
        ]);
    }

    #[Route('/livre/{id}', name: 'livre')]
    public function show(Livre $livre): Response
    {
        return $this->render('bibliotheque/livre.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/editer/{id}', name: 'editer')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function editer(Livre $livre, Request $request): Response
    {
        if ($livre) {
            $form = $this->createForm(LivreFormType::class, $livre);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $this->entityManager->persist($livre);
                $this->entityManager->flush();

                return $this->redirectToRoute('livre', ['id' => $livre->getId()]);
            }
            return $this->render('bibliotheque/ajout.html.twig', [
                'livre' => $livre,
                'formulaire' => $form->createView()
            ]);
        }
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function supprimer(Livre $livre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->entityManager->remove($livre);
        $this->entityManager->flush();
        return $this->redirectToRoute('bibliotheque');
    }

    #[Route('/ajout', name: 'ajout')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function ajout(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreFormType::class, $livre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($livre);
            $this->entityManager->flush();

            return $this->redirectToRoute('bibliotheque');
        }


        return $this->render('bibliotheque/ajout.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}
