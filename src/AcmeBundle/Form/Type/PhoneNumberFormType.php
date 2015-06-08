<?php

namespace AcmeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use AcmeBundle\Form\DataTransformer\PhoneNumberTransformer;
use Symfony\Component\Validator\ExecutionContextInterface;

class PhoneNumberFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('area', 'text')
           ->add('number', 'text');

         $builder->addModelTransformer(new PhoneNumberTransformer);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // 'constraints' => new Assert\Callback(function($value, ExecutionContextInterface $context) {
            //     if (!!$value['area'] ^ !!$value['number']) {
            //         $context->buildViolation('Area code and number are required.')
            //             ->addViolation();
            //     }
            // })
            'error_bubbling' => false
        ));
    }

    public function getName()
    {
        return 'phone_number';
    }

}
