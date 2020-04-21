<?php

namespace App\Form;

use App\Entity\Contribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                array(
                    'required' => true,
                    'attr' => array('placeholder' => 'Write descriptive title about this contribution')
                )
            )
            ->add(
                'summary',
                TextType::class,
                array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Write small summary about the usage/importance of this contribution'
                    )
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array('label' => 'Contribution Body', 'required' => true,)
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contribution::class,
        ]);
    }
}
