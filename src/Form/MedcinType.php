<?php

namespace App\Form;

use App\Entity\Medcin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MedcinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('matricule', HiddenType::class)
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('telephone')
            ->add('date_naissance' , DateType::class,[
                'widget' => 'single_text',
            
                'format' => 'yyyy-MM-dd'   
            ])
            
            ->add('services', EntityType::class,[
                'class'=>Service::class,
                'choice_label'=>'libelle'
            ])
            ->add('specialites', EntityType::class,[
                'class'=>Specialite::class,
                'choice_label'=>'libelle',
                'multiple'=>true,
                'by_reference'=>false
                            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medcin::class,
        ]);
    }
}
