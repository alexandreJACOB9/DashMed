# Projet DashMed 

FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali

⚠️ Problèmes critiques identifiés

Incohérence dans la structure de la base de données

Le fichier SQL définit : user_id, name, last_name, password (sans _hash)
Le modèle User utilise : first_name, last_name, password (au lieu de password_hash)
AuthController cherche : id, name, password_hash


Méthode findByEmail() manquante

AuthController appelle User::findByEmail() qui n'existe pas dans le modèle


Timestamps non gérés

Les champs created_at, updated_at sont définis mais jamais renseignés
Pour la base de donnée il est conseillé de faire ca : 

🌐 Hébergement de la base de données
Solution  : AlwaysData (Recommandé pour vous)
Avantages :

100 MB de base de données gratuite
Interface en français
Accès phpMyAdmin inclus
Compatible avec votre hébergement actuel

Étapes :

Créez un compte sur alwaysdata.com
Dans le panneau, créez une base MySQL
Notez les informations de connexion
Importez votre fichier SQL via phpMyAdmin
