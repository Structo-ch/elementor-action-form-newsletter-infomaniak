# Elementor - Intégration Infomaniak Newsletter

## Description

Ce plugin ajoute une action personnalisée pour le module de formulaire d'Elementor Pro, permettant d'inscrire automatiquement les utilisateurs à une liste de diffusion Infomaniak via leur API.

## Fonctionnalités

- Inscription automatique des utilisateurs à une liste Infomaniak.
- Intégration directe avec Elementor Pro.
- Configuration des paramètres API depuis l'interface Elementor.
- Validation et gestion des erreurs.

## Prérequis

- WordPress 5.8 ou supérieur.
- Elementor Pro installé et activé.
- Un compte Infomaniak avec accès à l'API newsletter.

## Installation

1. **Installation manuelle** :
   - Téléchargez les fichiers du plugin.
   - Uploadez-les dans le répertoire `wp-content/plugins/` de votre site WordPress.
   - Activez le plugin depuis le menu "Extensions" de WordPress.

2. **Installation via WordPress** :
   - Rendez-vous dans le menu "Extensions" > "Ajouter".
   - Cliquez sur "Téléverser une extension".
   - Importez le fichier `.zip` du plugin.
   - Activez-le après l'installation.

## Configuration

1. **Création d'une clé API Infomaniak** :
   - Connectez-vous à votre compte Infomaniak.
   - Accédez à la section "API & Documentation".
   - Générez une clé API et notez vos identifiants.

2. **Ajout de l'action Infomaniak dans Elementor** :
   - Créez ou modifiez un formulaire avec Elementor Pro.
   - Dans l'onglet "Actions après envoi", ajoutez "Newsletter Infomaniak".
   - Renseignez les paramètres suivants :
     - **URL de l'API Infomaniak**
     - **Clé API** et **Clé secrète**
     - **ID de la liste Infomaniak**
     - **Champ Email du formulaire**

## Fonctionnement

1. Lorsqu'un utilisateur soumet le formulaire Elementor, le plugin vérifie les paramètres et envoie une requête à l'API Infomaniak.
2. En cas de succès, l'utilisateur est ajouté à la liste de diffusion.
3. En cas d'erreur, un message est enregistré dans les logs WordPress.

## Debug & Logs

- Les erreurs API sont enregistrées dans le fichier `error_log` de WordPress.
- Vous pouvez activer le mode debug de WordPress en ajoutant dans `wp-config.php` :
  ```php
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
  ```
- Les logs seront disponibles dans `wp-content/debug.log`.

## Améliorations futures

- Support du double opt-in.
- Gestion des champs personnalisés.
- Compatibilité avec d'autres systèmes d'emailing.

## Licence

Ce plugin est open-source et distribué sous la licence MIT.

## Contact

Si vous avez des questions ou suggestions, n'hésitez pas à ouvrir une issue sur GitHub ou à nous contacter directement.

