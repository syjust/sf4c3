<?php


namespace App\Services;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class Registration
 *
 * @package App\Services
 */
class Registration
{
    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function register(Player $player)
    {
        // this work is done by RegisterFormEventListener
        //$player->setPassword($this->encoder->encodePassword($player, $player->getPassword()));
        $this->em->persist($player);
        $this->em->flush();

    }

}