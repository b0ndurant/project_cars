<?php
/**
 * ProfileType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ProfileType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Profile type.
 *
 * @category ProfileType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder The formBuilderInterface form
     * @param array                $options The attribute array
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $constraintsOptions = array(
            'message' => 'fos_user.current_password.invalid',
        );

        if (!empty($options['validation_groups'])) {
            $constraintsOptions['groups'] = array(
                reset($options['validation_groups']));
        }

        $builder
            ->add('username', TextType::class)
            ->add(
                'email', EmailType::class, array(
                    'translation_domain' => 'FOSUserBundle')
            )
            ->remove('current_password');
    }

    /**
     * GetParent profileFormType.
     *
     * @return null|string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    /**
     * GetBlockPrefix app_user_profile.
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    /**
     * GetName profile type.
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
