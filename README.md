# Création de la BDD 

- Création de la BDD dans adminer
- Créer un fichier env.local et parametrer la BDD : 

  - login : oboulot
  - oboulot
  - le nom de la BDD : oboulot
  
on utilise mariaDB (Open Source) plutot que MySQL (payant-appartient à Oracle), donc il faut ABSOLUMENT modifier la version du serveur
  - serverVersion=8 à changer en : `serverVersion=mariadb-10.3.38`
  - j'ai obtenu ma version de mariaDB avec la commande 'mysql -V'
`mysql  Ver 15.1 Distrib 10.3.38-MariaDB, for debian-linux-gnu (x86_64) using readline 5.2`

la BDD de dev
` DATABASE_URL="mysql://oboulot:oboulot@127.0.0.1:3306/oboulot?serverVersion=mariadb-10.3.38&charset=utf8mb4" `

Afin de vérifier si le parametrage de la BDD est opérationnelle :`bin/console doctrine:schema:validate`
