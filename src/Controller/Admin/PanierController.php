<?php


namespace App\Controller\Admin;


use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route(name="", path="/admin")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PanierController extends Controller
{
    /**
     * @Route("/panier/client/{id}", name="admin.panier.panierClient")
     */
    public function showPanierClient(Request $request, Environment $twig, $id){
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        if (!$client){
            return $this->redirectToRoute("admin.index");
        }

        $panier = $em->getRepository(Panier::class)->findBy(['user' => $client]);

        return new Response($twig->render('backOff/Panier/clientPanierShow.html.twig', [
            'panier' => $panier,
            'client' => $client,
        ]));
    }

    public function add(RegistryInterface $doctrine, Request $request){
        $idProduit = $request->get("produit_id");
        $produit_select = $doctrine->getRepository(Produit::class)->find($idProduit);

        $ligne_panier = $doctrine->getRepository(Panier::class)
            ->findOneBy(["produit" => $produit_select, "user"=> $this->getUser()]);
        if($produit_select->getStock() > 0){
            if($ligne_panier){
                $quantite = $ligne_panier->getQuantite();
                $ligne_panier->setQuantite($quantite);
            }
        }

    }

    public function delete(){

    }
}