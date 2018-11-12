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
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin.index")
     */
    public function indexAdmin(Request $request, Environment $twig){
        return new Response($twig->render('backOff/backOFFICE.html.twig'));
    }
}