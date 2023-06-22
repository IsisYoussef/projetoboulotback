 bin/console make:auth

 What style of authentication do you want? [Empty authenticator]:
  [0] Empty authenticator
  [1] Login form authenticator
 > 1

 The class name of the authenticator to create (e.g. AppCustomAuthenticator):
 > Authentificator

 Which firewall do you want to update? [login]:
  [0] login
  [1] api
  [2] main
 > 0

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 > 

 Enter the User class that you want to authenticate (e.g. App\Entity\User) [App\Entity\User]:
 > 

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 > 

 created: src/Security/AuthentificatorAuthenticator.php
 updated: config/packages/security.yaml
 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig

           
  Success! 
           

 Next:
 - Customize your new authenticator.
 - Finish the redirect "TODO" in the App\Security\AuthentificatorAuthenticator::onAuthenticationSuccess() method.
 - Review & adapt the login template: templates/security/login.html.twig.
student@isis-youssef-oclock-student:/var/www/html/apotheose/projet-o-boulot-back$ 

#Création des Fakers
- https://fakerphp.github.io/
- https://fakerphp.github.io/locales/fr_FR/
- https://github.com/FakerPHP/Faker/blob/main/src/Faker/Provider/fr_FR/Person.php