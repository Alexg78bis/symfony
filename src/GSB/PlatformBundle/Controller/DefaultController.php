<?php

namespace GSB\PlatformBundle\Controller;

use GSB\PlatformBundle\Entity\RapportVisite;
use GSB\PlatformBundle\Entity\Visiteur;
use GSB\PlatformBundle\Form\RapportVisiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('GSBPlatformBundle:Default:index.html.twig', array(

        ));
    }

    public function allVisitesAction()
    {

        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $rapports = $em->getRepository('GSBPlatformBundle:RapportVisite')->findAll();

        return $this->render('GSBPlatformBundle:Pages:visites.html.twig', array(
            'rapports' => $rapports
        ));
    }

    public function selectedVisiteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $rapport = $em->getRepository('GSBPlatformBundle:RapportVisite')->find($id);

        return $this->render('GSBPlatformBundle:Pages:oneVisite.html.twig', array(
            'rapport' => $rapport
        ));
    }

    public function addVisiteAction(Request $request){
        $rapportVisite = new RapportVisite();

        $form = $this->get('form.factory')->create(RapportVisiteType::class, $rapportVisite);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $em->persist($rapportVisite);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Raport bien enregistré.');

            return $this->redirectToRoute('gsb_platform_visites_all', array());
        }



        return $this->render('GSBPlatformBundle:Pages:addVisite.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
