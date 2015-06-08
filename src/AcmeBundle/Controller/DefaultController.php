<?php

namespace AcmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AcmeBundle\Entity\Contact;
use AcmeBundle\Form\Type\ContactFormType;

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

         $form = $this->createForm(new ContactFormType, $contact);

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
         );
     }

     /**
      * @Route("/contact/delete/{id}", name="contact_delete")
      */
     public function deleteAction(Request $request, $id)
     {
         $om = $this->get('doctrine')->getManager();
         $session = $this->get('session');

         $contact = $om
            ->getRepository('AcmeBundle:Contact')->find($id);

         $om->remove($contact);
         $om->flush();

         $session->getFlashBag()->set('success', 'Contact removed');

         return $this->redirect($this->generateUrl('contacts'));
     }

     /**
      * @Route("/contact/edit/{id}", name="contact_edit")
      * @Template()
      */
     public function editAction(Request $request, $id)
     {
         $om = $this->get('doctrine')->getManager();
         $session = $this->get('session');

         $contact = $om
            ->getRepository('AcmeBundle:Contact')->find($id);

         $form = $this->createForm(new ContactFormType, $contact);

         if ($request->isMethod('post')) {
             $form->handleRequest($request);

             if ($form->isValid()) {

                 $om->persist($contact);
                 $om->flush();

                 $session->getFlashBag()->set('success', 'Contact Updated');

                 return $this->redirect($this->generateUrl('contact_edit', array(
                     'id' => $contact->getId()
                 )));
             }
         }

         return array(
             'form' => $form->createView(),
             'contact' => $contact,
         );
     }

}
