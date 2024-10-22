<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Form\BookType;

#[Route('/book')]
class BookController extends AbstractController
{


    private $bookRepo;
    private $entityManager;
    public function __construct(BookRepository $bookRepoParam,EntityManagerInterface $entityManagerParam){
        $this->bookRepo = $bookRepoParam;
        
        $this->entityManager = $entityManagerParam;
    }

    #[Route('/bookList', name: 'app_book_list', methods:['GET'])]
    public function BookList(): Response
    {
        // Récupérer la liste des auteurs
        $books = $this->bookRepo->findAll();
         

        // Rendre la vue avec la liste des auteurs
        return $this->render('book/bookList.html.twig', [
            'books' => $books,
        ]);
    }

    

    
   
    //ajouter un livre
    #[Route('/new', name:'app_new_book')]
    public function addBook(Request $request):Response{
        //créer une instance de la classe Book
        $book=new Book();
        //Créer une interface form
        $form=$this->createForm(BookType::class,$book);
        //Traitement des données pour remplir l'entité avec les données soumises
        $form=$form->handleRequest($request);
        //Validation des données
        if($form->isSubmitted() && $form->isValid()){
            //Enregistrer l'entité dans la base de données
            $this->entityManager->persist($book);
            $this->entityManager->flush();
            //Redirection vers la page de liste des livres
            return $this->redirectToRoute('app_book_list');

    }
    return $this->render('book/new.html.twig',[
        'form'=>$form->createView()]);
}

#[Route('/update/{id}', name:'app_update_book')]
public function updateBook(Book $book,Request $request){
    $form=$this->createForm(BookType::class,$book);
    $form=$form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $this->entityManager->flush();
        return $this->redirectToRoute('app_book_list');
    }
    return $this->render('book/update.html.twig',[
        'form'=>$form->createView()]);

}
#[Route('/delete/{id}', name: 'app_delete_book')]
public function deleteBook(Book $book): Response
{
    // Remove the book entity
    $this->entityManager->remove($book);
    $this->entityManager->flush();

    // Return a response, you can redirect or return JSON
    return $this->redirectToRoute('app_book_list');
}


}
