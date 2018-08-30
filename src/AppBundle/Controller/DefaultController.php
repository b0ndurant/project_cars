<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use AppBundle\Entity\Visitor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')
            ->findBy(array(), array('id'=> 'desc'), 4, 0);

        //Count Visitor
        $visitor = new Visitor();
        $count_visit = $em->getRepository(Visitor::class)->findAll();

        $ip = $_SERVER['REMOTE_ADDR'];
        $hash = hash('md5',$ip);
        $result = $em->getRepository(Visitor::class)->findOneBy(['hashIp'=> $hash]);
        if ($result == null) {
            $visitor->setHashIp($hash);
            $em->persist($visitor);
            $em->flush();
        }


        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'count_visit' => $count_visit,
        ]);
    }

    /**
     * @Route("/vehicules", name="vehicules_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function  carsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        /**
         * Pagination Bundle
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result    = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('cars/index.html.twig', array(
            'articles' => $result,
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/vehicules/{id}", name="article_show")
     * @Method("GET")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Article $article)
    {

        return $this->render('article/show.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * @Route("/mentions legales", name="mentions_legals")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentions_legalsAction()
    {
        return $this->render('mentions_legals/mentions_legals.html.twig');
    }
}
