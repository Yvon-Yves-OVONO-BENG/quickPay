<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FournisseurType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator,
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fournisseur', TextType::class, [
                'label' => $this->translator->trans("Fournisseur"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Fournisseur"),
                ]
            ])
            ->add('contact', TextType::class, [
                'label' => $this->translator->trans("Contact du fournisseur"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Contact du fournisseur"),
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => $this->translator->trans("Adresse du fournisseur"),
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans("Adresse du fournisseur"),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
