<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Fournisseur;
use App\Entity\LigneDeCommande;
use Symfony\Component\Form\AbstractType;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommandeType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator,
        )
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'fournisseur',
                'required' => true,
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'placeholder' => $this->translator->trans('- - -'),
                ],
                'query_builder' => function(FournisseurRepository $fournisseurRepository){
                    
                    return $fournisseurRepository->createQueryBuilder('f')->orderBy('f.fournisseur');
                },
            ])
            ->add('ligneDeCommandes', CollectionType::class, [
                'label' => false,
                'entry_type' => LigneDeCommandeType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
