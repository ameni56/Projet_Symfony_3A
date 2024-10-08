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
{//Cette ligne déclare une propriété privée $authorRepository, qui sera utilisée dans toute la classe pour interagir avec la base de données via le repository.

    // Propriété de la classe pour stocker l'instance de AuthorRepository
    private $authorRepo; // Nouveau nom pour la propriété


    // Constructeur qui prend une instance de AuthorRepository
    //Le constructeur de la classe reçoit une instance de AuthorRepository. Cela permet d'injecter automatiquement le service repository via l'injection de dépendance. Il est ensuite assigné à la propriété $authorRepository pour être utilisé dans les autres méthodes.
    public function __construct(AuthorRepository $authorRepositoryParam)
    {
        // Assignation de l'instance à la propriété
        $this->authorRepo = $authorRepositoryParam; // Nouveau nom pour l'argument
      
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
        $authors = $this->authorRepo->findAllAuthors(); // Utilisation de la nouvelle propriété

        // Rendre la vue avec la liste des auteurs
        return $this->render('author/authorList.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/details/{id}', name: 'author_details', methods: ['GET'])]
    public function authorDetails(int $id): Response
    {
        // Récupérer l'auteur en fonction de l'ID en utilisant le repository
        $author = $this->authorRepo->findAuthorById($id); // Utilisation de la nouvelle propriété

        // Rendre la vue avec les détails de l'auteur
        return $this->render('author/details.html.twig', [
            'author' => $author,
        ]);
    }

   
}
