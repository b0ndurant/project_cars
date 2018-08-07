<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,
                array('attr' => array('placeholder' => 'Titre de l\'annonce'),
                    'constraints' => array(
                        new notblank(
                            array(
                                "message" => "Vous avez oublié de mettre un titre")
                        ),
                    )
                ))
            ->add('years',TextType::class,
                array('attr' => array('placeholder' => 'Année du vehicule'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Vous avez oublié de mettre l'année")
                        ),
                    )
                ))
            ->add('miles',TextType::class,
                array('attr' => array('placeholder' => 'Nombre de Kilometre'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Vous avez oublié de mettre le kilometrage")
                        ),
                    )
                ))
            ->add('energy',ChoiceType::class, array(
                'choices' => array(
                    'gazoil' => 'gazoil',
                    'essence' => 'essence',
                ),
            ))
            ->add('content',TextareaType::class,
                array('attr' => array('placeholder' => 'Description de l\'annonce', 'rows' => '7'),
                    'constraints' => array(
                        new notblank(
                            array(
                                "message" => "Vous avez oublié la description de l'annonce")
                        ),
                    )
                ))
            ->add('price',TextType::class,
                array('attr' => array('placeholder' => 'Prix du vehicule'),
                    'constraints' => array(
                        new notblank(
                            array(
                                "message" => "Vous avez oublié de mettre un prix")
                        ),
                    )
                ))
            ->add('mainPicture',FileType::class, array(
                'data_class' =>null,
                'required' => null,
            ))
            ->add('galleryPicture',FileType::class, array(
                'required' => null,
                'data_class' => null,
                'multiple' => true,
            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
