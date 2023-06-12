<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Job;
use App\Entity\User;
use DateTime;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Oboulot extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //---- Creation Admin ----

        $admin = new User();
        $admin->setEmail("admin@oboulot.io");
        // mot de passe gwen
        $admin->setPassword('$2y$13$XgoXu6T1z3xSvBlajvRRT.XbXikblcTeZtwpzDdu.XmzLjC8BSuU2');
        $admin->setGender("Madame");
        $admin->setFirstname("Gwen");
        $admin->setLastname("admin");
        $admin->setPhone("0000000000");
        $admin->setAddress("rue de l'admin");
        $admin->setPostalCode("45698");
        $admin->setCity("Lyon");
        $admin->setPresentation("Je suis admin");
        $admin->setCreatedAt(new Datetime("2023-06-09"));
        $admin->setRoles(['ROLE_ADMIN']);
         

        $manager->persist($admin);

        //---- Creation Manager ----

        $managerUser = new User();
        $managerUser->setEmail("manager@oboulot.io");
        // mot de passe isis
        $managerUser->setPassword('$2y$13$l4PG0gvTr3W1rhaUSL6xj.4jAKS33.vkgfx/EH4KzKPUx6xeS11Dq');
        $managerUser->setGender("Madame");
        $managerUser->setFirstname("Isis");
        $managerUser->setLastname("manager");
        $managerUser->setPhone("1111111111");
        $managerUser->setAddress("rue du manager");
        $managerUser->setPostalCode("54896");
        $managerUser->setCity("Cannes");
        $managerUser->setpresentation("Je suis manager");
        $managerUser->setCreatedAt(new Datetime("2023-07-09"));
        $managerUser->setRoles(['ROLE_MANAGER']);

        $manager->persist($managerUser);

        //---- Creation User (employee) ----

        $employee = new User();
        $employee->setEmail("employee@oboulot.io");
        // mot de passe carole
        $employee->setPassword('2y$13$SHc9Lyykg//iQPIKtSoLA.wy3Esz5LCX024q1GneTxZx6AlNb3006');
        $employee->setGender("Madame");
        $employee->setFirstname("Carole");
        $employee->setLastname("employee");
        $employee->setPhone("2222222222");
        $employee->setAddress("rue du stagiaire");
        $employee->setPostalCode("64986");
        $employee->setCity("Paris");
        $employee->setpresentation("Je suis stagiaire");
        $employee->setCreatedAt(new Datetime("2023-09-04"));
        $employee->setRoles(['ROLE_USER']);

        $manager->persist($employee);

        

        // ---- Creation de category ----
        
        $categories = ["Evenementiel", "Secretariat", "Administratif", "Batiment", "restauration"];
        $allCategory = [];
        foreach ($categories as $category) {
        $newCategory = new Category();
        $newCategory->setTitle($category);

        $manager->persist($newCategory);

        $allCategory[] = $newCategory;
        }
        
        //---- Creation Job ----

        $allJobs = [];
        for ($i=0; $i <20; $i++) {
        $newJob = new Job();

        $newJob->setEntitled("Offre n°" . $i);
        $newJob->setDateFrom(new DateTime("2023-02-03"));
        $newJob->setDateTill(new DateTime("2023-02-13"));
        $newJob->setNbVacancy(1);
        $newJob->setPlace("Région parisienne");
        $newJob->setDescription("Cette offre d'emploi est la meillleure du monde car elle proposait par l'entreprise la plus géniale");
        $newJob->setIsValid(true);
        $newJob->setCreatedAt(new DateTime("2023-05-25"));
        $newJob->setPublishedAt(new DateTime("2023-05-30"));

        $manager->persist($newJob);

        $allJobs[] = $newJob;

}
    $manager->flush();
    
    }


}
