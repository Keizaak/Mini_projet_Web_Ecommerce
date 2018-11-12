<?php


namespace App\Controller\Admin;

use App\Entity\Panier;
use App\Entity\Produit;
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
class CommandeController extends Controller
{
    /**
     * @Route("/commande/client/{id}", name="admin.commande.commandeClient")
     */
    public function showCommandeClient(Request $request, Environment $twig, $id){
        $em = $this->getDoctrine()->getManager();

        return new Response($twig->render('backOff/backOFFICE.html.twig'));
    }
}