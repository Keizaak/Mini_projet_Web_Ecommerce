<?php


namespace App\Controller\Client;


use App\Entity\Panier;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/**
 * @Route(name="", path="/client")
 * @Security("has_role('ROLE_CLIENT')")
 */
class ClientController extends Controller
{
    /**
     * @Route("/show", name="client.index")
     */
    public function indexClient(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $produits = $em->getRepository(Produit::class)->findAll();
        $panier = $em->getRepository(Panier::class)->findBy(['user' => $user]);


        return $this->render("frontOff/frontOFFICE.html.twig", [
            "produits" => $produits,
            "panier" => $panier
        ]);

    }
}