<?php
/**
 * ContactType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ContactType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Contact Type
 *
 * @category ContactType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder The formBuilderInterface form
     * @param array                $options the attribute array
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', TextType::class,
                array('attr' => array('placeholder' => 'Votre nom'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Veuillez remplir votre nom")
                        ),
                    )
                )
            )
            ->add(
                'email', EmailType::class,
                array('attr' => array('placeholder' => 'Votre adresse Email'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez mettre un email valide")),
                    new Email(array("message" => "Votre email ne semble pas être valide")),
                )
            ))
            ->add(
                'subject', TextType::class,
                array('attr' => array('placeholder' => 'Sujet'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Veuillez entrer un sujet")
                        ),
                    )
                )
            )
            ->add(
                'message', TextareaType::class,
                array('attr' => array('placeholder' => 'Votre message'),
                    'constraints' => array(
                        new NotBlank(
                            array("message" => "veuillez écrire vôtre message")
                        ),
                    )
                )
            );
    }
    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver The optionResolver class
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'error_bubbling' => true
            )
        );
    }
    /**
     * {@inheritdoc}
     *
     * @return null
     */
    public function getName()
    {
        return 'contact_form';
    }
}