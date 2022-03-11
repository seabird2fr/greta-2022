<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    // obtenir le contenu du panier
    public function get_cart()
    {

        return $this->session->get('cart', []);
    }

    // ajouter des produits
    public function add($id)
    {

        $cart =  $this->session->get('cart', []);

        if (!empty($cart[$id])) {

            $cart[$id]++;
        } else {

            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    // diminution d'un produit
    public function decrease($id)
    {

        $cart =  $this->session->get('cart', []);

        if (($cart[$id] > 1)) {

            $cart[$id]--;
        } else{

            unset($cart[$id]);
        }

            $this->session->set('cart', $cart);
    }

    //supprimer un produit
    public function delete($id)
    {

        $cart =  $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    // vide le panier
    public function remove_cart()
    {


        return $this->session->remove('cart');
    }
}
