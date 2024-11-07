<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Pays;
use App\Entity\Societe;
use App\Repository\PaysRepository;
use App\Repository\SocieteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PatientType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
        )
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => $this->translator->trans("Nom du patient"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Veuillez saisir le nom du patient"),
                ]
            ])
            ->add('villeResidence', TextType::class, [
                'label' => $this->translator->trans("Ville résidence"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Veuillez saisir la ville de résidence"),
                ]
            ])
            ->add('societe', EntityType::class, [
                'class' => Societe::class,
                'choice_label' => 'societe',
                'required' => true,
                'placeholder' => $this->translator->trans('Sélectionner une société'),
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(SocieteRepository $societeRepository){
                    
                    return $societeRepository->createQueryBuilder('c')->orderBy('c.societe');
                },
            ])
            
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'pays',
                'required' => true,
                'placeholder' => $this->translator->trans('Sélectionner un pays'),
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(PaysRepository $paysRepository){
                    
                    return $paysRepository->createQueryBuilder('p')->orderBy('p.pays');
                },
            ])
            ->add('dateNaissanceAt', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
