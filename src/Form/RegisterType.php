<?php

namespace App\Form;

use App\Entity\Player;
use App\Form\Listener\RegisterFormEventListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class RegisterType
 *
 * @package App\Form
 */
class RegisterType extends AbstractType
{
    /** @var RegisterFormEventListener */
    private $registerListener;

    /**
     * RegisterType constructor.
     *
     * @param RegisterFormEventListener $registerListener
     */
    public function __construct( RegisterFormEventListener $registerListener)
    {
        $this->registerListener = $registerListener;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('fullname', TextType::class)
            ->add('email', EmailType::class)
            ->add('dateOfBirth', BirthdayType::class)
            ->add('password', RepeatedType::class, ['type' => PasswordType::class])
            ->add('register', SubmitType::class)
        ;
        $builder->get('password')->addEventListener(FormEvents::SUBMIT, $this->registerListener);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Player::class,
            ]
        );
    }
}
