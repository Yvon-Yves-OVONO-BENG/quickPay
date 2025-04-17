<?php

namespace App\Form;

use App\Entity\Cryptographie;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\CryptographieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('cryptographie', EntityType::class, [
                'label' => 'Cryptographie',
                'class' => Cryptographie::class,
                'query_builder' => function(CryptographieRepository $cryptographieRepository){
                    return $cryptographieRepository->createQueryBuilder('c');
                },
                'choice_label' => 'cryptographie',
                'placeholder'=> '---',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('messageCrypte', TextareaType::class, [
                'label' => "Message",
                'attr' => [
                    'rows' => 10,
                    'cols' => 5,
                    'placeholder' => "Veuillez saisir votre message",
                ]
            ])

            ->add('important', CheckboxType::class, [
                'label' => "Marquer comme important",
                'required' => false,
                'attr' => [
                    'class' => 'form-switch'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
