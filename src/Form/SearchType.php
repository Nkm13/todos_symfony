<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'q',
                TextType::class,
                [
                    "label" => false,
                    "required" => false,
                    "attr" => [
                        "placeholder" => "Rechercher"
                    ]
                ]
            )
            ->add(
                'statut',
                CheckboxType::class,
                [
                    "label" => false,
                    "required" => false,

                ]
            )
            ->add(
                "network",
                ChoiceType::class,
                [
                    'label' => false,
                    "required" => false,
                    'choices' => ['moov', 'telecel', 'orange'],
                    'data' => [4, 5, 7],
                    "expanded" => true,
                    'multiple' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => SearchData::class,
            "method" => "GET",
            "csrf_protection" => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
