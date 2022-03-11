<?php

namespace App\Controller;



use App\Entity\Comment;

use App\Entity\Product;
use App\Form\CommentType;
use App\Entity\SearchFilters;
use App\Form\SearchFiltersType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produits/{page}", name="products")
     */
    public function index(ProductRepository $repo, Request $request, PaginatorInterface $paginator, $page = 1): Response
    {

        // $repo = $this->getDoctrine()->getRepository(Product::class);

        // $products = $repo->find(21);
        // findbyX  ( X nom d'un champ)
        // $products = $repo->findByName('in omnis omnis');



        //$products = $repo->findBy(['category'=>74],['price'=>'desc'],2,0);
        $search = new SearchFilters();

        $form = $this->createForm(SearchFiltersType::class, $search);

        //dump($user);

        $form->handleRequest($request); // on recupère la requete

        if ($form->isSubmitted() && $form->isValid()) {




            // $products = $repo->findBy(['category' => $idCat]);
            $donnees = $repo->myFindSearch($search);

            $products = $paginator->paginate(
                $donnees, // données
                $page, // page sur laquelle on se trouve
                2 // nbrs d'éléments par page
            );

            if (count($donnees) < 1) {
                $error = "Aucun produit ne correspond à votre recherche";
            } else $error = null;
        } else {

            $donnees = $repo->myFindAll();
            $products = $paginator->paginate(
                $donnees, // données
                $page, // page sur laquelle on se trouve
                2 // nbrs d'éléments par page
            );

            $error = null;
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'error' => $error,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/produit/{slug}", name="show_product")
     */
    public function show(Product $product): Response
    {

        // $product =$repo->findOneBySlug($slug);



        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }



    /**
     * @Route("/compte/mes-commandes/{slug}/comment", name="comment_product")
     */
    public function comment(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        //dump($user);

        $form->handleRequest($request); // on recupère la requete

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime());
            $comment->setUser($this->getUser());
            $comment->setProduct($product);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'le commentaire pour le produit ' . $product->getName() . ' a bien été enregistré'
            );

            return $this->redirectToRoute('show_product', ['slug' => $product->getSlug()]);
        }

        return $this->render('product/comment.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
