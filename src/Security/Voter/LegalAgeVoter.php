<?php

namespace App\Security\Voter;

use App\Entity\Player;
use DateTime;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class LegalAgeVoter
 *
 * @package App\Security\Voter
 */
class LegalAgeVoter extends Voter
{
    /** @var int */
    private $legalAge;

    /**
     * LegalAgeVoter constructor.
     */
    public function __construct(int $legalAge)
    {
        $this->legalAge = $legalAge;
    }

    /**
     * @param string $attribute (IsGranted first arg)
     * @param mixed  $subject (IsGranted second arg)
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return ($attribute === 'HAS_LEGAL_AGE');
    }

    /**
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     * @throws \Exception
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($token instanceof AnonymousToken) {
            return false;
        }

        /** @var Player $user */
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }



        return ($user->getDateOfBirth() < new DateTime(sprintf('now - %d years', $this->legalAge)));
    }
}
