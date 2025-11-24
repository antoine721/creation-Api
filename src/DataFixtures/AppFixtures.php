<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = (new User())
            ->setEmail('dj_techno@djforum.com')
            ->setUsername('DJ_TechnoMaster')
            ->setBio('Spécialiste techno et house depuis 10 ans 🎧⚡');
        
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password123'));
        $manager->persist($user1);

        $user2 = (new User())
            ->setEmail('vinyl_collector@djforum.com')
            ->setUsername('VinylCollector')
            ->setBio('Collectionneur de vinyles rares et passionné de mix analogique 💿');
        
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'password123'));
        $manager->persist($user2);

        $user3 = (new User())
            ->setEmail('beatmaker_pro@djforum.com')
            ->setUsername('BeatMakerPro')
            ->setBio('Producteur et beatmaker, toujours à la recherche de nouveaux sons 🎵');
        
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'password123'));
        $manager->persist($user3);

        $user4 = (new User())
            ->setEmail('club_dj@djforum.com')
            ->setUsername('ClubDJ_Max')
            ->setBio('DJ résident dans plusieurs clubs parisiens, spécialisé en deep house 🎹');
        
        $user4->setPassword($this->passwordHasher->hashPassword($user4, 'password123'));
        $manager->persist($user4);

        $post1 = (new Post())
            ->setContent('Nouveau mix techno disponible ! 2h de set avec mes dernières découvertes. Link en bio 🎧⚡ Qu\'en pensez-vous ?')
            ->setAuthor($user1);
        $manager->persist($post1);

        $post2 = (new Post())
            ->setContent('Trouvé un pressing rare de Daft Punk dans une brocante aujourd\'hui ! 💿✨ Les trésors existent encore')
            ->setAuthor($user2);
        $manager->persist($post2);

        $post3 = (new Post())
            ->setContent('Besoin de conseils : quel logiciel utilisez-vous pour vos productions ? Je cherche à passer de FL Studio à Ableton...')
            ->setAuthor($user3);
        $manager->persist($post3);

        $post4 = (new Post())
            ->setContent('Set de demain soir au club : 3h de deep house et progressive. Qui vient ? 🎹🌙')
            ->setAuthor($user4);
        $manager->persist($post4);

        $post5 = (new Post())
            ->setContent('Nouvelle track en préparation, mélange de techno et d\'éléments ambient. Preview bientôt disponible ! 🎵')
            ->setAuthor($user3);
        $manager->persist($post5);

        $post6 = (new Post())
            ->setContent('Quel est votre setup idéal pour mixer en live ? Je cherche à améliorer mon équipement actuel 🎛️')
            ->setAuthor($user1);
        $manager->persist($post6);

        $manager->flush();
    }
}
