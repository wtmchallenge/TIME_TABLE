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
      <a href="/edt/create?semaine=<?= $semaine ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un créneau
      </a>
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

    <!-- Semaines déjà planifiées -->
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
      <thead class="table-dark">
        <tr>
          <th style="width:100px">Horaires</th>
          <?php foreach ($jours as $jour): ?>
            <th><?= $jour ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($creneaux_horaires as $debut => $fin): ?>
          <tr>
            <!-- Cellule horaire -->
            <td class="fw-semibold text-nowrap bg-light">
              <?= $debut ?><br><small><?= $fin ?></small>
            </td>

            <!-- Cellules jours -->
            <?php foreach ($jours as $jour): ?>
              <td class="p-1 align-top" style="min-height:90px; min-width:130px;">
                <?php
                  $cellules = $grille[$jour][$debut] ?? [];
                  foreach ($cellules as $cr):
                ?>
                  <div onclick="window.location.href='/edt/edit/<?= $cr['id'] ?>'"
                    class="card border mb-1 shadow-sm position-relative"
                    style="cursor:pointer; transition:0.2s;"
                    onmouseover="this.style.transform='scale(1.02)'"
                    onmouseout="this.style.transform='scale(1)'">

                  <?php if ($isAdmin): ?>
                    <a href="/edt/delete/<?= $cr['id'] ?>"
                      class="position-absolute top-0 end-0 m-1 text-danger"
                      style="font-size: 0.8rem;"
                      onclick="event.stopPropagation(); event.preventDefault(); if(confirm('Supprimer ce créneau ?')) window.location.href=this.href;">
                      <i class="bi bi-x-circle-fill"></i>
                    </a>
                  <?php endif; ?>

                  <div class="card-body p-1 text-start" style="font-size:.78rem">
                    <strong><?= esc($cr['cours_nom']) ?></strong>

                    <?php if (!empty($cr['cours_code'])): ?>
                      <span class="badge bg-light text-dark ms-1"><?= esc($cr['cours_code']) ?></span>
                    <?php endif; ?>

                    <div class="mt-1">
                      <i class="bi bi-person-fill me-1"></i>
                      <?= esc($cr['ens_prenom'] . ' ' . $cr['ens_nom']) ?>
                    </div>

                    <div>
                      <i class="bi bi-door-closed me-1"></i>
                      <?= esc($cr['salle_nom']) ?>
                    </div>
                  </div>

                </div>
                <?php endforeach; ?>

                <!-- Bouton ajout rapide (admin) -->
                <?php if ($isAdmin && empty($cellules)): ?>
                  <a href="/edt/create?semaine=<?= $semaine ?>&jour=<?= urlencode($jour) ?>&heure_debut=<?= urlencode($debut) ?>&heure_fin=<?= urlencode($fin) ?>"
                     class="btn btn-outline-light btn-sm w-100 h-100 text-muted opacity-50"
                     style="min-height:60px; font-size:.75rem">
                    <i class="bi bi-plus"></i>
                  </a>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>

          <!-- Ligne PAUSE après 11H30-13H30 -->
          <?php if ($debut === '11:30'): ?>
            <tr class="table-warning">
              <td class="fw-bold text-center" colspan="<?= count($jours) + 1 ?>">
                PAUSE — 13H30 à 14H00
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<style>
.edt-grid td { vertical-align: top; }
.btn-xs { font-size: .7rem; line-height: 1.2; }
</style>

<script>
function allerSemaine(weekValue) {
    if (!weekValue) return;
    // weekValue = "2026-W18" → convertir en lundi
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
