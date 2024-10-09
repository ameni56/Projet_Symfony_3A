<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Author;

#[Route('/author')]
class AuthorController extends AbstractController
{
    // Propriété de la classe pour stocker l'instance de AuthorRepository
    private $authorRepo;
    private $entityManager;



    // Constructeur qui prend une instance de AuthorRepository
    public function __construct(AuthorRepository $authorRepositoryParam,EntityManagerInterface $entityManagerParam)
    {
        // Assignation de l'instance à la propriété
        $this->authorRepo = $authorRepositoryParam; 
        $this->entityManager=$entityManagerParam;
}

    #[Route('/author', name: 'app_author', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('author/index.html.twig');
    }

    #[Route('/showAuthor/{name}', name: 'app_showAuthor', defaults:['name'=>'victor hugo'], methods:['GET'])]
    public function showAuthor($name): Response
    {
        return $this->render('author/showAuthor.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/authorList', name: 'app_authorList', methods:['GET'])]
    public function AuthorList(): Response
    {
        // Récupérer la liste des auteurs
        $authors = $this->authorRepo->findAllAuthors(); 

        // Rendre la vue avec la liste des auteurs
        return $this->render('author/authorList.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/details/{id}', name: 'author_details', methods: ['GET'])]
    public function authorDetails(int $id): Response
    {
        // Récupérer l'auteur en fonction de l'ID en utilisant le repository
        $author = $this->authorRepo->findAuthorById($id); 

        // Rendre la vue avec les détails de l'auteur
        return $this->render('author/details.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/addAuthor', name: 'add_author', methods: ['GET'])]
   public function addAuthor():Response{
    $author=new Author();
    $author->setUsername('Ali');
    $author->setEmail('Ali@esprit.tn');
    $author->setPicture('sdkhbk.png');
    $author->setNb_Books(500);

    $this->entityManager->persist($author);
    $this->entityManager->flush();

    return $this->redirectToRoute('app_authorList');

   }

   #[Route('/delete/{id}', name: 'delete', methods: ['GET','DELETE'])]
   public function delete_Author($id):Response{

    $author=$this->authorRepo->findAuthorById($id);
    $this->entityManager->remove($author);
    $this->entityManager->flush();
    return $this->redirectToRoute('app_authorList');
   }
}
