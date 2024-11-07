<?php

namespace App\Form;

use Assert\NotBlank;
use App\Entity\Facture;
use App\Entity\Patient;
use App\Entity\ModePaiement;
use App\Entity\Prescripteur;
use App\Repository\PatientRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\ModePaiementRepository;
use App\Repository\PrescripteurRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ConfirmerPanierType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator,
        protected PatientRepository $patientRepository,
        protected ModePaiementRepository $modePaiementRepository
        )
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $netApayer = $options['netApayer'];
        $builder
            ->add('nomPatient', TextType::class, [
                'label' => $this->translator->trans("Nom pour la facture"),
                'required' => false,
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => $this->translator->trans("Nom pour la facture"),
                    
                ]
            ])
            ->add('contactPatient', TextType::class, [
                'label' => $this->translator->trans("Numéro de téléphone"),
                'required' => false,
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => $this->translator->trans("Numéro de téléphone"),
                ]
            ])
            ->add('avance', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => $netApayer,
                    'value' => $netApayer,
                    'class' => "form-control",
                    'placeholder' => $this->translator->trans("L'avance doit être >= 0 ou <= à ").number_format($netApayer, 0, '', ' '),
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => $this->translator->trans("L'avance ne peut pas être vide!"),
                    ]),
                    new Assert\PositiveOrZero(),
                    new Assert\LessThanOrEqual([
                        'value' => $netApayer,
                        'message' => $this->translator->trans("L'avance doit être inférieure ou égale à ").number_format($netApayer, 0, '', ' ')." ! ",
                    ])
                ]
            ])
            ->add('modePaiement', EntityType::class, [
                'class' => ModePaiement::class,
                'choice_label' => 'modePaiement',
                'required' => true,
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'placeholder' => $this->translator->trans('- - -'),
                ],
                'query_builder' => function(ModePaiementRepository $modePaiementRepository){
                    
                    return $modePaiementRepository->createQueryBuilder('m')->orderBy('m.modePaiement');
                },
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'nom',
                'required' => false,
                'placeholder' => $this->translator->trans('- - -'),
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'value' => 'Client',
                ],
                'query_builder' => function(PatientRepository $patientRepository){
                    
                    return $patientRepository->createQueryBuilder('p')->andWhere('p.termine = 0')->orderBy('p.nom');
                }
            ])
            ->add('prescripteur', EntityType::class, [
                'class' => Prescripteur::class,
                'choice_label' => 'prescripteur',
                'required' => true,
                'placeholder' => $this->translator->trans('- - -'),
                'attr' => [
                    'class' => 'form-control select2-show-search',
                    'value' => 'Client',
                ],
                'query_builder' => function(PrescripteurRepository $prescripteurRepository){
                    
                    return $prescripteurRepository->createQueryBuilder('p')->orderBy('p.prescripteur');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Facture::class
        ]);

        $resolver->setRequired('netApayer');
    }
}
