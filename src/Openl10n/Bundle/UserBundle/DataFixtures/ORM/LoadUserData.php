<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Domain\User\Value\Username;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;

class LoadUserData extends AbstractFixtureLoader
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('users') as $username => $data) {
            $user = $this->createUser($username, $data);
            $this->addReference('user-'.$username, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    private function createUser($username, $data)
    {
        return (new User(new Username($username)))
            ->setName(new Name($data['name']))
            ->setEmail(new Email($data['email']))
            ->setPreferredLocale(Locale::parse($data['locale']))
        ;
    }
}
