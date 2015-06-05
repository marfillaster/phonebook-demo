<?php

namespace AcmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
         $contacts = array(
             array(
                 'name' => 'Obama 1',
                 'mobile' => '0911111111'
             ),
             array(
                 'name' => 'Obama 2',
                 'mobile' => '0911111111'
             ),
             array(
                 'name' => 'Obama 3',
                 'mobile' => '0911111111'
             ),
         );

         $formBuilder = $this->createFormBuilder()
            ->add('name')
            ->add('mobile', 'number');

         $form = $formBuilder->getForm();

         $session = $this->get('session');
         $exitingContacts = array();

         if ($session->has('contacts')) {
             $exitingContacts = $session->get('contacts');
         }

         if ($request->isMethod('post')) {
             $form->handleRequest($request);

             if ($form->isValid()) {

                 array_push($exitingContacts, $form->getData());

                 $session->set('contacts', $exitingContacts);


                 $session->getFlashBag()->set('success', 'Contact Added');

                 return $this->redirect($this->generateUrl('contacts'));
             }
         }

         $contacts = array_merge($contacts, $exitingContacts);

         return array(
             'contacts' => $contacts,
             'form' => $form->createView(),
             'exitingContacts' => $exitingContacts,
         );
     }

}
