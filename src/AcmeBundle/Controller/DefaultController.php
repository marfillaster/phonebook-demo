<?php

namespace AcmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AcmeBundle\Entity\Contact;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}", name="hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
     public function indexAction(Request $request)
     {
         if ($request->isMethod('post')) {

             $url = $this->generateUrl('hello', array(
                 'name' => $request->request->get('name')
             ));

             return $this->redirect($url);
         }


         return array();
     }

     /**
      * @Route("/contacts", name="contacts")
      * @Template()
      */
     public function contactsAction(Request $request)
     {
         $om = $this->get('doctrine')->getManager();

         $repository = $om->getRepository('AcmeBundle:Contact');

         $contacts = $repository->findAll();

         $contact = new Contact; 

         $formBuilder = $this->createFormBuilder($contact)
            ->add('name')
            ->add('mobile', 'number');

         $form = $formBuilder->getForm();

         $session = $this->get('session');

         if ($request->isMethod('post')) {
             $form->handleRequest($request);

             if ($form->isValid()) {
                 $om->persist($contact);
                 $om->flush();

                 $session->getFlashBag()->set('success', 'Contact Added: '. ($contact->getId()));

                 return $this->redirect($this->generateUrl('contacts'));
             }
         }

         return array(
             'contacts' => $contacts,
             'form' => $form->createView(),
             'exitingContacts' => $exitingContacts,
         );
     }

}
