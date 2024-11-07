<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\LigneDeCommande;
use App\Repository\ProduitRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LigneDeCommandeType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator,
        )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('produit', TextType::class, [
        //     'label' => $this->translator->trans("Produit"),
        //     'required' => true,
        //     'attr' => [
        //         'class' => 'form-control',
        //         'placeholder' => $this->translator->trans("Produit"),
        //     ]
        // ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'libelle',
                'required' => true,
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'placeholder' => $this->translator->trans('- - -'),
                ],
                'query_builder' => function(ProduitRepository $produitRepository){
                    
                    return $produitRepository->createQueryBuilder('p')->orderBy('p.libelle');
                },
            ])
            ->add('quantite', NumberType::class, [
                'label' => $this->translator->trans("Quantité"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Quantité"),
                ]
            ])
            ->add('prixAchat', IntegerType::class, [
                'label' => $this->translator->trans("Prix d'achat"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Prix d'achat du produit"),
                ]
            ])
            
            ->add('coef', NumberType::class, [
                'label' => $this->translator->trans("Coefficient du produit"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Coefficient"),
                ]
            ])
            
            // ->add('prixVente', IntegerType::class, [
            //     'label' => $this->translator->trans("Prix de vente"),
            //     'required' => true,
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => $this->translator->trans("Prix de vente du produit"),
            //     ]
            // ])
            
            ->add('datePeremptionAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneDeCommande::class,
        ]);
    }
}
