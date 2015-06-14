<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ContactController extends FOSRestController
{
    /**
     * List all contacts
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Contact",
     *  description="List all contacts"
     * )
     */
    public function getContactsAction()
    {
        $om = $this->get('doctrine')->getManager();
        $repository = $om->getRepository('AcmeBundle:Contact');

        return $repository->findAll();
    }

    /**
     * Get a contact
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a contact",
     *  section="Contact",
     *  requirements={
     *      {
     *          "name"="contact",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="contact ID"
     *      }
     *  }
     * )
     *
     * @ParamConverter("contact", class="AcmeBundle:Contact")
     */
    public function getContactAction($contact)
    {
        return $contact;
    }
}
