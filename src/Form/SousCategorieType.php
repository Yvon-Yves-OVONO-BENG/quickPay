<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SousCategorieType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
        )
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sousCategorie', TextType::class, [
                'label' => $this->translator->trans("Nom de la sous catégorie :"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Veuillez saisir le nom de la sous catégorie"),
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'categorie',
                'required' => true,
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'placeholder' => $this->translator->trans('- - -'),
                ],
                'query_builder' => function(CategorieRepository $categorieRepository){
                    
                    return $categorieRepository->createQueryBuilder('c')->orderBy('c.categorie');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousCategorie::class,
        ]);
    }
}
