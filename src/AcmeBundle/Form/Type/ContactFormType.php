<?php

namespace AcmeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('name', 'text')
           ->add('mobile', new PhoneNumberFormType);

        if ($builder->getData() && $builder->getData()->getId()) {
            $builder->add('company');

            $builder->add('emails', 'collection', array(
                'type' => new EmailFormType,
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ));
        }

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}
