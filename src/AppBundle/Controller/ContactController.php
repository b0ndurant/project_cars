<?php
/**
 * ContactController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ContactController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 * @license  Hem Tennis Club
 * @link     https://www.hemtennisclub.com/
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Contact controller.
 *
 * @category ContactController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 * @license  Hem Tennis Club
 * @link     https://www.hemtennisclub.com/
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @param Request $request posted info
     *
     * @Route          ("/contact",  name="contact_index")
     * @Method({"GET", "POST"})
     * @return         \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(
            'AppBundle\Form\ContactType', null, [
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('contact_index'),
            'method' => 'POST',
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->_sendEmail($form->getData())) {
                $this->addFlash("success", "Votre message a bien été envoyé.");
                return $this->redirectToRoute('homepage');
            } else {
                throw $this->
                createNotFoundException('Erreur : L\'email n\'a pas pu s\'envoyer.');
            }
        }

        return $this->render(
            'contact/index.html.twig', [
            'form' => $form->createView()
            ]
        );
    }
    /**
     * Creates email function for send newsletter.
     *
     * $data function to send email
     *
     * @param string int array $data function send email
     *
     * @return string int array
     */
    private function _sendEmail($data)
    {

        $message = \Swift_Message::newInstance($data["subject"])
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setCharset('UTF-8')
            ->setTo($this->container->getParameter('mailer_user'))
            ->setBody(
                $this->renderView(
                    'email/registration.html.twig',
                    [
                        'name'    => $data['name'],
                        'email'   => $data['email'],
                        'subject' => $data['subject'],
                        'message' => $data['message'],
                    ]
                ),
                'text/html'
            );

        return $this->get('mailer')->send($message);
    }
}
