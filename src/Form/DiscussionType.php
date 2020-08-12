<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Discussion;
use App\Entity\Places;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscussionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('first_post')
            ->add('categorie', EntityType::class, [
            'class'=>Categorie::class,
            'choice_label'=>'name'
            ])
            ->add('place', EntityType::class, [
                'class'=>Places::class,
                'choice_label'=>'name'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discussion::class,
        ]);
    }
}
