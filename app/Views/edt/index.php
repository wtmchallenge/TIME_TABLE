
<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid py-3">

  <!-- ── En-tête & navigation ────────────────────────────────────────── -->
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h4 class="mb-0">
      <i class="bi bi-calendar-week me-2"></i>
      Emploi du Temps — Semaine du <?= date('d/m/Y', strtotime($semaine)) ?>
    </h4>

    <?php if ($isAdmin): ?>
    <div class="d-flex gap-2 flex-wrap">
      <a href="/edt/create?semaine=<?= $semaine ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un créneau
      </a>
      <a href="/consultation/pdf?semaine=<?= $semaine ?>&filiere_id=<?= $filiere_id_actif ?>&salle_id=<?= $salle_id_actif ?>"
         class="btn btn-danger btn-sm" target="_blank">
        <i class="bi bi-file-pdf me-1"></i> Exporter PDF
      </a>
    </div>
    <?php endif; ?>
  </div>

  <!-- ── Flash messages ──────────────────────────────────────────────── -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($conflits = session()->getFlashdata('conflits')): ?>
    <div class="alert alert-danger">
      <strong><i class="bi bi-exclamation-triangle me-1"></i>Conflits détectés :</strong>
      <ul class="mb-0 mt-1">
        <?php foreach ($conflits as $c): ?>
          <li><?= esc($c['message']) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- ── Navigation semaines ─────────────────────────────────────────── -->
  <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
    <a href="/edt/semaine/<?= $semaine_prev ?>" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-chevron-left"></i> Semaine préc.
    </a>

    <input type="week" id="semaineInput" class="form-control form-control-sm" style="width:180px"
           value="<?= date('Y-\WW', strtotime($semaine)) ?>"
           onchange="allerSemaine(this.value)">

    <a href="/edt/semaine/<?= $semaine_next ?>" class="btn btn-outline-secondary btn-sm">
      Semaine suiv. <i class="bi bi-chevron-right"></i>
    </a>

    <?php if (!empty($semaines_dispo)): ?>
    <select class="form-select form-select-sm" style="width:220px"
            onchange="if(this.value) window.location='/edt/semaine/'+this.value">
      <option value="">— Semaines planifiées —</option>
      <?php foreach ($semaines_dispo as $sd): ?>
        <option value="<?= $sd['semaine'] ?>" <?= $sd['semaine'] === $semaine ? 'selected' : '' ?>>
          <?= date('d/m/Y', strtotime($sd['semaine'])) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php endif; ?>
  </div>

  <!-- ── Filtres ─────────────────────────────────────────────────────── -->
  <form method="GET" action="/edt/semaine/<?= $semaine ?>" class="row g-2 mb-3">
    <div class="col-auto">
      <select name="filiere_id" class="form-select form-select-sm">
        <option value="">Toutes les filières</option>
        <?php foreach ($filieres as $f): ?>
          <option value="<?= $f['id'] ?>" <?= $filiere_id_actif == $f['id'] ? 'selected' : '' ?>>
            <?= esc($f['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <select name="salle_id" class="form-select form-select-sm">
        <option value="">Toutes les salles</option>
        <?php foreach ($salles as $s): ?>
          <option value="<?= $s['id'] ?>" <?= $salle_id_actif == $s['id'] ? 'selected' : '' ?>>
            <?= esc($s['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary btn-sm">
        <i class="bi bi-funnel me-1"></i>Filtrer
      </button>
      <a href="/edt/semaine/<?= $semaine ?>" class="btn btn-outline-secondary btn-sm ms-1">
        <i class="bi bi-x-circle me-1"></i>Réinitialiser
      </a>
    </div>
  </form>

  <!-- ── Grille EDT ──────────────────────────────────────────────────── -->
  <div class="table-responsive">
    <table class="table table-bordered table-sm edt-grid align-middle text-center">
      <thead>
        <tr>
          <th class="edt-th" style="width:100px">Horaires</th>
          <?php foreach ($jours as $jour): ?>
            <th class="edt-th"><?= $jour ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($creneaux_horaires as $debut => $fin): ?>
          <tr>
            <!-- Cellule horaire -->
            <td class="fw-semibold text-nowrap edt-horaire-cell">
              <?= $debut ?><br><small class="text-muted"><?= $fin ?></small>
            </td>

            <!-- Cellules jours -->
            <?php foreach ($jours as $jour): ?>
              <td class="p-1 align-top edt-day-cell">
                <?php
                  $cellules = $grille[$jour][$debut] ?? [];
                  foreach ($cellules as $cr):
                ?>
                  <div onclick="window.location.href='/edt/edit/<?= $cr['id'] ?>'"
                       class="edt-card position-relative"
                       onmouseover="this.classList.add('edt-card-hover')"
                       onmouseout="this.classList.remove('edt-card-hover')">

                    <?php if ($isAdmin): ?>
                      <a href="/edt/delete/<?= $cr['id'] ?>"
                         class="edt-delete-btn"
                         onclick="event.stopPropagation(); event.preventDefault(); if(confirm('Supprimer ce créneau ?')) window.location.href=this.href;">
                        <i class="bi bi-x-circle-fill"></i>
                      </a>
                    <?php endif; ?>

                    <div class="edt-card-body">
                      <div class="edt-cours-nom"><?= esc($cr['cours_nom']) ?></div>

                      <?php if (!empty($cr['cours_code'])): ?>
                        <span class="edt-code-badge"><?= esc($cr['cours_code']) ?></span>
                      <?php endif; ?>

                      <div class="edt-meta mt-1">
                        <i class="bi bi-person-fill me-1"></i>
                        <span class="edt-enseignant"><?= esc($cr['ens_prenom'] . ' ' . $cr['ens_nom']) ?></span>
                      </div>

                      <div class="edt-meta">
                        <i class="bi bi-door-closed me-1"></i>
                        <span><?= esc($cr['salle_nom']) ?></span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

                <!-- Bouton ajout rapide (admin) -->
                <?php if ($isAdmin && empty($cellules)): ?>
                  <a href="/edt/create?semaine=<?= $semaine ?>&jour=<?= urlencode($jour) ?>&heure_debut=<?= urlencode($debut) ?>&heure_fin=<?= urlencode($fin) ?>"
                     class="edt-add-btn">
                    <i class="bi bi-plus"></i>
                  </a>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>

          <!-- Ligne PAUSE après 11H30-13H30 -->
          <?php if ($debut === '11:30'): ?>
            <tr class="edt-pause-row">
              <td class="edt-pause-horaire fw-bold text-center">13H30<br><small>14H00</small></td>
              <td class="edt-pause-cell fw-bold text-center" colspan="<?= count($jours) ?>">
                <i class="bi bi-cup-hot me-2"></i>PAUSE — 13H30 à 14H00
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<style>
/* ═══════════════════════════════════════════════════════
   EDT — Styles personnalisés
   ═══════════════════════════════════════════════════════ */

/* En-têtes du tableau : blanc avec texte noir, bordure noire */
.edt-th {
  background-color: #ffffff !important;
  color: #000000 !important;
  border: 2px solid #000 !important;
  font-weight: bold;
  font-size: 0.85rem;
  text-align: center;
  padding: 8px 6px;
  letter-spacing: 0.5px;
}

/* Cellule horaire (colonne gauche) */
.edt-horaire-cell {
  background-color: #f8f9fa;
  border: 2px doublr solid #00af50;
  font-size: 0.82rem;
  text-align: center;
  vertical-align: middle;
  padding: 6px 4px;
}

/* Cellules jours */
.edt-day-cell {
  min-height: 90px;
  min-width: 140px;
  vertical-align: top;
  border: 4px double solid #00af50;
}

/* Carte cours */
.edt-card {
  background: #fff;
  border: 4px double solid #00af50;
  border-left: 3px solid #6c42b3;
  border-radius: 6px;
  margin-bottom: 4px;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  overflow: hidden;
}

.edt-card-hover {
  transform: scale(1.02);
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.edt-card-body {
  padding: 5px 8px;
  text-align: left;
  font-size: 0.76rem;
}

.edt-cours-nom {
  font-weight: 700;
  font-size: 0.78rem;
  color: #1a1a2e;
  line-height: 1.3;
  margin-bottom: 2px;
}

.edt-code-badge {
  display: inline-block;
  background: #e9ecef;
  color: #495057;
  font-size: 0.68rem;
  padding: 1px 5px;
  border-radius: 3px;
  margin-bottom: 3px;
}

.edt-meta {
  font-size: 0.72rem;
  color: #555;
  line-height: 1.4;
}

.edt-enseignant {
  color: #cc0000;
  font-weight: 600;
}

/* Bouton supprimer */
.edt-delete-btn {
  position: absolute;
  top: 3px;
  right: 4px;
  font-size: 0.78rem;
  color: #dc3545;
  text-decoration: none;
  line-height: 1;
  opacity: 0.7;
  transition: opacity 0.15s;
}
.edt-delete-btn:hover { opacity: 1; }

/* Bouton ajout rapide */
.edt-add-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-height: 60px;
  color: #adb5bd;
  font-size: 1.1rem;
  text-decoration: none;
  border: 1px dashed #dee2e6;
  border-radius: 6px;
  transition: all 0.15s;
}
.edt-add-btn:hover {
  color: #6c42b3;
  border-color: #6c42b3;
  background: #f8f4ff;
}

/* Ligne PAUSE */
.edt-pause-row td {
  border: 1px solid #7B2D8B;
}
.edt-pause-horaire {
  background-color: #b8cfe8 !important;
  font-size: 0.78rem;
  vertical-align: middle;
}
.edt-pause-cell {
  background-color: #b8cfe8 !important;
  font-size: 1rem;
  letter-spacing: 2px;
  color: #1a1a2e;
  padding: 10px;
}

/* Tableau global */
.edt-grid {
  border: 2px solid #000;
}
.edt-grid td, .edt-grid th {
  vertical-align: top;
}
</style>

<script>
function allerSemaine(weekValue) {
  if (!weekValue) return;
  const [year, week] = weekValue.split('-W');
  const jan4 = new Date(year, 0, 4);
  const dayOfWeek = jan4.getDay() || 7;
  const lundi = new Date(jan4);
  lundi.setDate(jan4.getDate() - dayOfWeek + 1 + (week - 1) * 7);
  const iso = lundi.toISOString().split('T')[0];
  window.location = '/edt/semaine/' + iso;
}
</script>

<?php $this->endSection(); ?>