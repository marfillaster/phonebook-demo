<?php

namespace AcmeBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PhoneNumberTransformer implements DataTransformerInterface
{
    public function transform($modelData)
    {
        return array(
            'area' => substr($modelData, 0, 2),
            'number' => substr($modelData, 2)
        );
    }

    public function reverseTransform($normalized)
    {
        if ($normalized['number'] && (strlen($normalized['area']) != 2)) {
            throw new TransformationFailedException('Area code is invalid');
        }


        return $normalized['area'].$normalized['number'];
    }
}
