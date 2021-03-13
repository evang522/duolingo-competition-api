<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\User\Service;

use App\Domain\User\Entity\AdminUser;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\SelfSaltingEncoderInterface;

class UserPasswordUpdater
{
    private EncoderFactoryInterface $passwordEncoderFactory;

    public function __construct(EncoderFactoryInterface $passwordEncoderFactory)
    {
        $this->passwordEncoderFactory = $passwordEncoderFactory;
    }

    public function updatePassword(AdminUser $user): void
    {
        $plainPassword = $user->plainTextPassword();
        if ($plainPassword === null || $plainPassword === '') {
            return;
        }

        $encoder = $this->passwordEncoderFactory->getEncoder($user);

        if (! $encoder instanceof SelfSaltingEncoderInterface && ! $encoder instanceof PlaintextPasswordEncoder) {
            throw new \RuntimeException('Encoder for this user should be self salting.');
        }

        $hashedPassword = $encoder->encodePassword($plainPassword, '');
        $user->setEncryptedPassword($hashedPassword);
        $user->eraseCredentials();
    }
}
