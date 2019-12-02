<?php


namespace App\Security;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;

/**
 * Class HangmanSuccessAuthenticationHandler
 *
 * @package App\Security
 */
class HangmanSuccessAuthenticationHandler extends DefaultAuthenticationSuccessHandler
{

    /** @var EntityManagerInterface */
    private $em;

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var Player $user */
        $user = $token->getUser();
        $user->recordLastLogin();
        $this->em->flush();

        return parent::onAuthenticationSuccess($request, $token);
    }

    /**
     * @required
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}