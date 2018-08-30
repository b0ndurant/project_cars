<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("/")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("admin/article/", name="article_index")
     * @Method("GET")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(request $request)
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

        return $this->render('article/index.html.twig', array(
            'articles' => $result,
        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("admin/article/new/", name="article_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $article->getGalleryPicture();
            $mainPicture = $article->getMainPicture();


            if ($mainPicture == null) {
                $this->addFlash("no_picture", "il vous manque des photos");
                return $this->render('article/new.html.twig', array(
                    'article' => $article,
                    'form' => $form->createView(),
                ));
            }
            $fileMain = md5(uniqid()).'.'. $mainPicture->guessExtension();
            $mainPicture->move($this->getParameter('image_directory'),$fileMain);
            $compress = imagecreatefromjpeg('../web/uploads/images/'.$fileMain);
            imagejpeg($compress,'../web/uploads/images/'.$fileMain,50);

            $images = array();

            if ($files != null) {
                foreach ($files as $file) {
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move($this->getParameter('image_directory'), $filename);
                    $compress = imagecreatefromjpeg('../web/uploads/images/'.$filename);
                    imagejpeg($compress,'../web/uploads/images/'.$filename,50);
                    $images[] = $filename;
                }
            }

            $article->setGalleryPicture($images);
            $article->setMainPicture($fileMain);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash("article_new", "Votre vehicule a bien été enregistré.");
            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("admin/article/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Article $article)
    {
        $galleryPicture = $article->getGalleryPicture();
        $mainPicture = $article->getMainPicture();
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);
        $files = $article->getGalleryPicture();
        $file = $article->getMainPicture();



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($file == null) {
                $fileMain = $mainPicture;
            }
            else {
                unlink('uploads/images/'.$mainPicture);
                $fileMain = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('image_directory'), $fileMain);
                $compress = imagecreatefromjpeg('../web/uploads/images/'.$fileMain);
                imagejpeg($compress,'../web/uploads/images/'.$fileMain,50);
            }
            if ($files == null) {
                $images = $galleryPicture;
            }
            else {
                foreach ($galleryPicture as $file) {
                    unlink('uploads/images/'.$file);
                }
                $images = array();

                foreach ($files as $file) {
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move($this->getParameter('image_directory'), $filename);
                    $compress = imagecreatefromjpeg('../web/uploads/images/'.$filename);
                    imagejpeg($compress,'../web/uploads/images/'.$filename,50);
                    $images[] = $filename;
                }
            }
            $article->setMainPicture($fileMain);
            $article->setGalleryPicture($images);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("article_edit", "Votre vehicule a bien été modifié.");
            return $this->redirectToRoute('article_index');
        }
        else {
            $article->setMainPicture($mainPicture);
            $article->setGalleryPicture($galleryPicture);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("admin/article/{id}", name="article_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            unlink('uploads/images/'.$article->getMainPicture());
            foreach ($article->getGalleryPicture() as $file) {
                unlink('uploads/images/'.$file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
