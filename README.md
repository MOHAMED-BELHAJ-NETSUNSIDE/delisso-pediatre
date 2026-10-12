# Delisso Tournée Pédiatre

Application pour délégués médicaux.

- **Admin** : Laravel + Filament (pas de React)
- **API** : Laravel (Sanctum), consommée par le mobile
- **Mobile** : React + shadcn/ui + Capacitor

## Comptes (mot de passe : `Delisso2026!`)

| Email | Rôle | Accès |
|-------|------|--------|
| admin@delisso.local | admin | Filament |
| gestionnaire@delisso.local | gestionnaire | Filament (stock) |
| stats@delisso.local | statistiques | Filament (visites) |
| delegue@delisso.local | délégué | Application mobile uniquement |

## Admin et API (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

- Back-office : http://localhost:8000/admin
- API : http://localhost:8000/api

En local, la base par défaut est SQLite (`backend/database/database.sqlite`). Pour MySQL (OVH), renseigner `DB_CONNECTION=mysql` et les variables `DB_*` dans `backend/.env`, puis relancer les migrations.

## Mobile (React + shadcn/ui)

```bash
cd mobile
npm install
cp .env.example .env   # VITE_API_URL=http://localhost:8000
npm run dev
```

Build Android :

```bash
cd mobile
npm run build
npx cap add android   # une seule fois
npx cap sync android
npx cap open android
```

## Logo

- Admin Filament : `backend/public/images/logo-delisso.png`
- Mobile : `mobile/src/assets/logo-mobile.png`

Source : `logo-delisso.png` à la racine.
