lien vers le dépot github: https://github.com/ElPulpitoLoco/gestion_tickets.git
nom du dossier: gestion_tickets

Admins :
  Email : admin@example.com | Mot de passe : adminpass
Staff :
  Email : staff@example.com | Mot de passe : staffpass

## Installation rapide
1. Clonez le dépôt :
   ```bash
   git clone <URL_DU_DEPOT>
   cd <NOM_DU_DOSSIER>
2. Installez les dépendances :
   composer install
   npm install
3. Configurez l'environnement :
   Copiez .env.example vers .env :
   cp .env.example .env
4. Compilez les assets et appliquez les migrations :
   npm run build
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
5. Lancer le serveur:
   symfony server:start

