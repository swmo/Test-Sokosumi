<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Create admin user
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('Benutzer');
        $admin->setPhone('+41 79 123 45 67');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        // Create regular users
        $user1 = new User();
        $user1->setEmail('maria.mueller@example.com');
        $user1->setFirstName('Maria');
        $user1->setLastName('Mueller');
        $user1->setPhone('+41 79 234 56 78');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password123'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('thomas.schmidt@example.com');
        $user2->setFirstName('Thomas');
        $user2->setLastName('Schmidt');
        $user2->setPhone('+41 79 345 67 89');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'password123'));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail('anna.weber@example.com');
        $user3->setFirstName('Anna');
        $user3->setLastName('Weber');
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'password123'));
        $manager->persist($user3);

        // Create events
        $event1 = new Event();
        $event1->setTitle('Fruehjahrputz im Stadtpark');
        $event1->setDescription('Gemeinsam raeumen wir den Stadtpark auf und machen ihn fit fuer den Fruehling. Bitte bringen Sie Handschuhe und festes Schuhwerk mit. Getraenke und Verpflegung werden gestellt.');
        $event1->setLocation('Stadtpark Bern');
        $event1->setDate(new \DateTime('+14 days 09:00'));
        $event1->setMaxParticipants(20);
        $event1->setCreatedBy($admin);
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setTitle('Seniorenheim Besuchstag');
        $event2->setDescription('Wir besuchen die Bewohner des Seniorenheims Sonnenberg. Gemeinsames Kaffeetrinken, Spiele und Gespraeche. Ihre Zeit ist das wertvollste Geschenk!');
        $event2->setLocation('Seniorenheim Sonnenberg, Zurich');
        $event2->setDate(new \DateTime('+7 days 14:00'));
        $event2->setMaxParticipants(10);
        $event2->setCreatedBy($admin);
        $manager->persist($event2);

        $event3 = new Event();
        $event3->setTitle('Lebensmittelausgabe Tafel');
        $event3->setDescription('Helfen Sie bei der woechentlichen Lebensmittelausgabe der Tafel. Aufgaben: Sortieren, Verpacken und Verteilen von Lebensmitteln an Beduerftige.');
        $event3->setLocation('Gemeindezentrum Basel');
        $event3->setDate(new \DateTime('+3 days 08:00'));
        $event3->setMaxParticipants(15);
        $event3->setCreatedBy($admin);
        $manager->persist($event3);

        $event4 = new Event();
        $event4->setTitle('Fluechtlingshilfe Sprachkurs');
        $event4->setDescription('Unterstuetzen Sie Gefluechtete beim Deutschlernen. Keine Lehrerfahrung noetig - Geduld und Freundlichkeit genuegen!');
        $event4->setLocation('Volkshochschule Luzern');
        $event4->setDate(new \DateTime('+21 days 18:00'));
        $event4->setMaxParticipants(8);
        $event4->setCreatedBy($admin);
        $manager->persist($event4);

        $event5 = new Event();
        $event5->setTitle('Tierheim Aktionstag');
        $event5->setDescription('Das Tierheim braucht Ihre Hilfe! Gassi gehen mit den Hunden, Katzen streicheln und bei der Reinigung der Gehege helfen.');
        $event5->setLocation('Tierheim Arche, Winterthur');
        $event5->setDate(new \DateTime('+10 days 10:00'));
        $event5->setMaxParticipants(12);
        $event5->setCreatedBy($admin);
        $manager->persist($event5);

        // Create some registrations
        $reg1 = new Registration();
        $reg1->setUser($user1);
        $reg1->setEvent($event1);
        $manager->persist($reg1);

        $reg2 = new Registration();
        $reg2->setUser($user2);
        $reg2->setEvent($event1);
        $manager->persist($reg2);

        $reg3 = new Registration();
        $reg3->setUser($user1);
        $reg3->setEvent($event2);
        $manager->persist($reg3);

        $reg4 = new Registration();
        $reg4->setUser($user3);
        $reg4->setEvent($event3);
        $manager->persist($reg4);

        $manager->flush();
    }
}
