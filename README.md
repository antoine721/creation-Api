# 🎧 DJ FORUM - Guide de démarrage

Forum communautaire pour DJs avec API Symfony et interface moderne.

## 📋 Prérequis

- PHP >= 8.2
- Composer
- Docker et Docker Compose
- PostgreSQL (via Docker)

## 🚀 Installation et démarrage

### 1. Installer les dépendances PHP

```bash
composer install
```

### 2. Démarrer la base de données PostgreSQL

```bash
docker compose up -d
```

Cela démarre PostgreSQL sur le port **5433**.

### 3. Configurer l'environnement

Le fichier `.env` devrait déjà exister. Si ce n'est pas le cas, créez-le avec la configuration suivante :

```bash
# .env
APP_ENV=dev
APP_SECRET=<générez une clé secrète>
DEFAULT_URI=http://127.0.0.1:8000
DATABASE_URL="postgresql://app:root@127.0.0.1:5433/app?serverVersion=16&charset=utf8"
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_jwt_passphrase_here_change_in_production
```

### 4. Créer la base de données et lancer les migrations

```bash
# Créer la base de données
php bin/console doctrine:database:create

# Lancer les migrations
php bin/console doctrine:migrations:migrate
```

### 5. Charger les données de test (optionnel)

```bash
php bin/console doctrine:fixtures:load
```

### 6. Générer les clés JWT pour l'authentification

```bash
# Générer les clés privée et publique JWT
php bin/console lexik:jwt:generate-keypair
```

### 7. Lancer le serveur Symfony

```bash
php bin/console lexik:jwt:generate-keypair
```

Ou avec PHP intégré :

```bash
php -S localhost:8000 -t public
```

Le serveur sera accessible sur : **http://localhost:8000**

## 🌐 Accès à l'application

- **Frontend** : http://localhost:8000
- **API** : http://localhost:8000/api
- **Documentation API** : http://localhost:8000/api/docs (si configuré)

## 📝 Commandes utiles

### Base de données

```bash
# Voir le statut des migrations
php bin/console doctrine:migrations:status

# Créer une nouvelle migration
php bin/console make:migration

# Réinitialiser la base de données
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### Cache

```bash
# Vider le cache
php bin/console cache:clear
```

### Docker

```bash
# Arrêter les conteneurs
docker compose down

# Voir les logs
docker compose logs -f

# Arrêter et supprimer les volumes (⚠️ supprime les données)
docker compose down -v
```

## 🔧 Configuration

### Variables d'environnement importantes

- `APP_ENV` : Environnement (dev, prod, test)
- `APP_SECRET` : Clé secrète de l'application
- `DEFAULT_URI` : URI par défaut pour générer les URLs (ex: http://127.0.0.1:8000)
- `DATABASE_URL` : URL de connexion PostgreSQL
- `CORS_ALLOW_ORIGIN` : Expression régulière pour les origines CORS autorisées
- `JWT_SECRET_KEY` : Clé secrète JWT (générée automatiquement)
- `JWT_PUBLIC_KEY` : Clé publique JWT (générée automatiquement)
- `JWT_PASSPHRASE` : Phrase secrète pour les clés JWT

### Ports utilisés

- **8000** : Serveur Symfony
- **5433** : PostgreSQL (mappé depuis 5432 du conteneur)

## 🎯 Structure du projet

```
├── public/          # Frontend (HTML, CSS, JS)
├── src/             # Code PHP Symfony
│   ├── Entity/      # Entités Doctrine
│   ├── Controller/  # Contrôleurs
│   ├── State/       # State Processors API Platform
│   └── ...
├── config/          # Configuration Symfony
├── migrations/      # Migrations Doctrine
└── compose.yaml     # Configuration Docker
```

## 🐛 Dépannage

### Erreur : Fichier .env manquant

Si vous voyez l'erreur "Unable to read the .env environment file", créez le fichier `.env` à la racine du projet avec :

```bash
# .env
APP_ENV=dev
APP_SECRET=<générez une clé secrète de 64 caractères>
DEFAULT_URI=http://127.0.0.1:8000
DATABASE_URL="postgresql://app:root@127.0.0.1:5433/app?serverVersion=16&charset=utf8"
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_jwt_passphrase_here_change_in_production
```

### Avertissement : Extension intl manquante

Si vous voyez "Unable to load dynamic library 'intl'", installez l'extension :

```bash
# Sur macOS avec Homebrew
brew install php-intl

# Ou avec PECL
pecl install intl
```

**Note** : Cet avertissement n'est pas bloquant, mais l'extension est recommandée pour certaines fonctionnalités Symfony.

### Erreur de connexion à la base de données

Vérifiez que Docker Compose est bien démarré :
```bash
docker compose ps
```

### Erreur JWT

Vérifiez que les clés JWT sont générées :
```bash
ls -la config/jwt/
```

Si elles n'existent pas :
```bash
php bin/console lexik:jwt:generate-keypair
```

### Port déjà utilisé

Si le port 8000 est occupé, utilisez un autre port :
```bash
symfony server:start -d --port=8001
```

N'oubliez pas de mettre à jour `DEFAULT_URI` dans le fichier `.env` si vous changez le port.

### Erreur : Variable DEFAULT_URI manquante

Si vous voyez l'erreur "Environment variable not found: DEFAULT_URI", ajoutez cette ligne dans votre fichier `.env` :

```bash
DEFAULT_URI=http://127.0.0.1:8000
```

Cette variable est utilisée par Symfony pour générer des URLs dans les contextes non-HTTP (comme les commandes CLI).

### Erreur : Variable CORS_ALLOW_ORIGIN manquante

Si vous voyez l'erreur "Environment variable not found: CORS_ALLOW_ORIGIN", ajoutez cette ligne dans votre fichier `.env` :

```bash
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$
```

Cette variable définit les origines autorisées pour les requêtes CORS. La valeur ci-dessus permet l'accès depuis localhost et 127.0.0.1 sur n'importe quel port (utile pour le développement).

Pour la production, remplacez par l'URL exacte de votre domaine :
```bash
CORS_ALLOW_ORIGIN=https://votre-domaine.com
```

## 📚 Documentation

- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [API Platform Documentation](https://api-platform.com/docs/)

