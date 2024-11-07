<?php

namespace App\Form;

use App\Entity\Lot;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Repository\LotRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\SousCategorieRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProduitType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
        )
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //////DEBUT PRODUIT CLASSIC
            ->add('libelle', TextType::class, [
                'label' => $this->translator->trans("Libellé du produit :"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Désignation du produit"),
                ]
            ])
            
            ->add('photoFile', VichImageType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'delete_label' => "Supprimer",
                'download_uri' => false,
                'download_label' => "Télécharger",
                'image_uri' => true,
                'attr' => [
                    'class' => 'dropify'
                ]
            ])
            ->add('lot', EntityType::class, [
                'class' => Lot::class,
                'choice_label' => 'reference',
                'required' => true,
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'placeholder' => $this->translator->trans('- - -'),
                ],
                'query_builder' => function(LotRepository $lotRepository){
                    
                    return $lotRepository->createQueryBuilder('l')->orderBy('l.reference');
                },
            ])
            
            ->add('quantiteSeuil', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Quantite"),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
