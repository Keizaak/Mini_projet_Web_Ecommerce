<?php


namespace App\Controller\Client;

use App\Entity\Commande;
use App\Entity\Etat;
use App\Entity\LigneCommande;
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
class CommandeController extends Controller
{
    /**
     * @Route("/commande/create", name="client.commandeCreate")
     */
    public function commandeCreate(Request $request, Environment $twig){

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $produits = $em->getRepository(Produit::class)->findAll();

        $panier = $em->getRepository(Panier::class)->findBy(['user' => $user]);

        $etat = $em->getRepository(Etat::class)->findOneBy(["nom" => "Créée"]);

        $commandes = $em->getRepository(Commande::class)->findBy(["user" => $user, "etat" => $etat]);

        foreach ($commandes as $commande){
            $em->remove($commande);
        }
        $em->flush();

        $commande = new Commande();
        $commande->setUser($user)
            ->setEtat($etat)
            ->setDate(\DateTime::createFromFormat("Y/m/d", date('Y/m/d')));

        $em->persist($commande);



        foreach ($panier as $row){
            $ligne = new LigneCommande();
            $ligne->setCommande($commande)
                ->setProduit($row->getProduit())
                ->setQuantite($row->getQuantite());
            $em->persist($ligne);

        }


        $em->flush();

        $lignes_commande = $em->getRepository(LigneCommande::class)->findBy(["commande" => $commande]);

        return new Response($twig->render('frontOff/Commande/showCommande.html.twig', [
            "lignes" => $lignes_commande
        ]));
    }

    /**
     * @Route("/commande/deleteCreee", name="client.commandeDeleteCreee")
     */
    public function commandeDeleteCreee(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $etat = $em->getRepository(Etat::class)->findOneBy(["nom" => "Créée"]);

        $commandes = $em->getRepository(Commande::class)->findBy(["user" => $user, "etat" => $etat]);

        foreach ($commandes as $commande){
            $em->remove($commande);
        }
        $em->flush();

        return $this->redirectToRoute('client.index');
    }

    /**
     * @Route("/commande/valider", name="client.commandeValider")
     */
    public function commandeValider(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $etat = $em->getRepository(Etat::class)->findOneBy(["nom" => "Créée"]);


        $commande = $em->getRepository(Commande::class)->findOneBy(["user" => $user, "etat" => $etat]);

        $etat = $em->getRepository(Etat::class)->findOneBy(["nom" => "A prépare"]);

        $commande->setEtat($etat);
        $em->persist($commande);

        $paniers = $em->getRepository(Panier::class)->findBy(["user" => $user]);

        foreach ($paniers as $panier){
            $em->remove($panier);
        }

        $em->flush();

        $produits = $em->getRepository(Produit::class)->findAll();
        $panier = $em->getRepository(Panier::class)->findBy(['user' => $user]);


        return $this->render("frontOff/frontOFFICE.html.twig", [
            "produits" => $produits,
            "panier" => $panier,
            "commande" => $commande
        ]);
    }

    /**
     * @Route("/commande/vider", name="client.viderPanierCommande")
     */
    public function commandePanierVider(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $etat = $em->getRepository(Etat::class)->findOneBy(["nom" => "Créée"]);

        $commandes = $em->getRepository(Commande::class)->findBy(["user" => $user, "etat" => $etat]);
        $paniers = $em->getRepository(Panier::class)->findBy([
            "user" => $user
        ]);

        foreach ($commandes as $commande){
            $em->remove($commande);
        }
        foreach ($paniers as $panier){
            $em->remove($panier);
        }
        $em->flush();

        return $this->redirectToRoute('client.index');
    }
}