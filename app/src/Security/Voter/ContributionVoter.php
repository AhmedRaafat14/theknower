<?php

namespace App\Security\Voter;

use App\Entity\Contribution;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ContributionVoter extends Voter
{
    private const MANAGE = 'manage';

    /** @var Security $security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::MANAGE])
            && $subject instanceof Contribution;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var Contribution $subject */ # this just to help my editor :)

        // if the user is anonymous, do not grant access
        if (!$this->security->getUser() instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::MANAGE:
                if ($this->validateTheOwner($subject)) {
                    return true;
                }
                break;
        }

        return false;
    }

    /**
     * check if the logged in user is the owner of the selected contribution
     *
     * @param Contribution $contribution
     * @return mixed
     */
    private function validateTheOwner($contribution)
    {
        return $contribution->getUser() === $this->security->getUser();
    }
}
