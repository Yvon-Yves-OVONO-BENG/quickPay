<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProfilType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator,
        protected TokenStorageInterface $tokenStorage
        )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('imageFile', VichImageType::class, [
        //     'label' => false,
        //     'required' => false,
        //     'allow_delete' => true,
        //     'delete_label' => "Supprimer",
        //     'download_uri' => false,
        //     'download_label' => "Télécharger",
        //     'image_uri' => true,
        //     'attr' => [
        //         'class' => 'dropify'
        //     ]
        // ])
        ->add('username', TextType::class, [
            'label' => $this->translator->trans("Nom complet"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Nom complet de l'utilisateur"),
            ]
        ])

        ->add('numCni', TextType::class, [
            'label' => $this->translator->trans("Numéro CNI"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Numéro CNI"),
            ]
        ])
        ->add('code', TextType::class, [
            'label' => $this->translator->trans("Code de transfert"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Code de transfert"),
            ]
        ])
        ->add('contact', TextType::class, [
            'label' => $this->translator->trans("Contact"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Contact utilisateur"),
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => $this->translator->trans("Email"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Votre email"),
            ]
        ])
        ->add('adresse', TextType::class, [
            'label' => $this->translator->trans("Adresse"),
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans("Votre adresse"),
            ]
        ])
        ->add('genre', EntityType::class, [
            'class' => Genre::class,
            'choice_label' => 'genre',
            'required' => true,
            'placeholder' => $this->translator->trans('- - -'),
            'attr' => [
                'class' => 'form-control',
            ],
            'query_builder' => function(GenreRepository $genreRepository){
                
                return $genreRepository->createQueryBuilder('g')->orderBy('g.genre');
            },
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
