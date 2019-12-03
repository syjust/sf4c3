<?php


namespace App\Form\Listener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class RegisterFormEventListener
 *
 * @package App\Form\Listener
 */
class RegisterFormEventListener
{
    /** @var EncoderFactoryInterface */
    private $encoder;

    /**
     * RegisterFormEventListener constructor.
     *
     * @param EncoderFactoryInterface $encoder
     */
    public function __construct(EncoderFactoryInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param FormEvent $event
     */
    public function __invoke(FormEvent $event)
    {
        $password  = $event->getForm();
        $encrypted = $this->encoder
            ->getEncoder($password->getRoot()->getConfig()->getOption('data_class'))
            ->encodePassword($event->getData(), null)
        ;
        $event->setData($encrypted);
    }

}