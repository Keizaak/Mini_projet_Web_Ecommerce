<?php


namespace App\Controller\Admin;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
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
class ClientController extends Controller
{
    /**
     * @Route("/client/show", name="admin.showClients")
     */
    public function adminShowClient(Request $request, Environment $twig){
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository(User::class)->findBy(['roles' => "ROLE_CLIENT"]);

        return new Response($twig->render('backOff/Client/clientsShow.html.twig', [
            'clients' => $clients,
        ]));
    }
}