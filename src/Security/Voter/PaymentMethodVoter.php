<?php

namespace App\Security\Voter;

use App\Entity\PaymentMethod;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PaymentMethodVoter extends Voter
{
    public const DELETE = 'PAYMENTMETHOD_DELETE';

    public function __construct(private Security $security) {}

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::DELETE && $subject instanceof PaymentMethod;
    }

    protected function voteOnAttribute(string $attribute, $paymentMethod, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!is_object($user)) {
            return false;
        }

        foreach ($paymentMethod->getUserPaymentMethods() as $link) {
            if ($link->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
