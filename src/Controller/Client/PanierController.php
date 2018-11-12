<?php

namespace App\Controller\Client;


use App\Entity\Panier;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;



 /**
  * @Route(name="", path="/panier")
  */
class PanierController extends Controller
{
    /**
     * @Route("/show", name="panier.index")
     */
    public function indexClient(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository(Produit::class)->findAll();

        return $this->render("frontOff/frontOFFICE.html.twig", [
            "produits" => $produits,
        ]);

    }

    /**
     * @Route("/addProduit", name="panier.addProduit")
     */
    public function panierAddProduit(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $id_produit = $request->request->get('id_produit');


        $produit = $em->getRepository(Produit::class)->findOneBy(['id' => $id_produit]);

        $user = $this->getUser();

        if(!$produit){
            return $this->redirectToRoute('client.index');
        }

        $res = $em->getRepository(Panier::class)->findProduit($produit->getId(), $user);


        if (!$res){
            $panier = new Panier();
            $panier->setProduit($produit)
                ->setQuantite(1)
                ->setUser($user);
        }else{
            $panier = $res[0];
            $panier->setQuantite($panier->getQuantite() + 1);
        }

        $em->persist($panier);
        $em->flush();


        return $this->redirectToRoute('client.index');
    }

    /**
     * @Route("/deleteProduit", name="panier.deleteProduit")
     */
    public function deleteProduit(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $id_panier = $request->request->get('id_panier');

        $panier = $em->getRepository(Panier::class)->findOneBy(['id' => $id_panier]);

        if (!$panier){
            return $this->redirectToRoute('client.index');
        }

        if($panier->getQuantite() != 1){
            $panier->setQuantite($panier->getQuantite() - 1);
            $em->persist($panier);
        }else{
            $em->remove($panier);
        }

        $em->flush();

        return $this->redirectToRoute('client.index');
    }
}