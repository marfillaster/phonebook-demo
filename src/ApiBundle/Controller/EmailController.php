<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class EmailController extends FOSRestController
{
    /**
     * List contact emails
     *
     * @ApiDoc(
     *  resource=true,
     *  description="List contact emails",
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
    public function getEmailsAction($contact)
    {
        return $contact->getEmails();
    }
}
