# 📅 Gestion des Emplois du Temps — Département INFOTEL (ENSPM)

## 👥 Équipe — Groupe 1
| Membre | Matricule | Rôle principal |
|---|---|---|
| Bounyamine Ousmanou | 24ENSPM445 | Auth · Construction EDT · Dashboard |
| Nouga Mfangnia Ange Merveille | 24ENSPM340 | Ressources · Consultation · Export PDF |

## 📌 Description
Application web de gestion des emplois du temps du département INFOTEL de l'ENSPM.  
Permet la création, la gestion et la diffusion des plannings hebdomadaires avec détection automatique des conflits.

## ⚙️ Technologies utilisées
- **Framework** : CodeIgniter 4 (PHP)
- **Base de données** : MySQL
- **Frontend** : Bootstrap 5, FullCalendar.js, Chart.js, jsPDF
- **Outils** : GitHub, XAMPP

## 🗂️ Modules fonctionnels
- ✅ Module Authentification (Login, rôles admin/enseignant)
- ✅ Module Gestion des Ressources (CRUD enseignants, cours, salles, filières)
- ✅ Module Construction de l'EDT (affectation, conflits, modifications)
- ✅ Module Consultation & Diffusion (filtrage, export PDF ENSPM)
- ✅ Module Dashboard (statistiques, historique)

## 🚀 Installation
```bash
git clone https://github.com/votre-username/gestion-edt.git
cd gestion-edt
cp env .env  # configurer DB_HOST, DB_USER, DB_PASS
php spark serve
```

## 🗄️ Base de données
Importer le fichier `database/schema.sql` dans MySQL avant de lancer.

## 📁 Organisation des branches
| Branche | Responsable | Contenu |
|---|---|---|
| `main` | — | Code stable validé |
| `develop` | Les 2 | Intégration |
| `feature/auth` | Bounyamine | Authentification |
| `feature/gestion-ressources` | Nouga Ange | CRUD ressources |
| `feature/construction-edt` | Bounyamine | Grille EDT |
| `feature/consultation` | Nouga Ange | Filtrage + Export |
| `feature/dashboard` | Bounyamine | Stats + Historique |
