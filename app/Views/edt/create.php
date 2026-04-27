<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="container py-4" style="max-width:780px">

  <div class="d-flex align-items-center mb-4 gap-3">
    <a href="/edt/semaine/<?= esc($semaine) ?>" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Ajouter un créneau</h4>
  </div>

  <!-- Conflits flash -->
  <?php if ($conf = session()->getFlashdata('conflits')): ?>
    <div class="alert alert-danger" id="conflitsFlash">
      <strong><i class="bi bi-exclamation-triangle me-1"></i>Conflits détectés :</strong>
      <ul class="mb-0 mt-1">
        <?php foreach ($conf as $c): ?>
          <li><?= esc($c['message']) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Erreurs de validation -->
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-warning">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Conflits AJAX (temps réel) -->
  <div id="conflitsAjax" class="alert alert-danger d-none">
    <strong><i class="bi bi-exclamation-triangle me-1"></i>Conflits détectés :</strong>
    <ul id="conflitsListe" class="mb-0 mt-1"></ul>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <form id="formEdt" action="/edt/store" method="POST">
        <?= csrf_field() ?>

        <!-- Semaine -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Semaine <span class="text-danger">*</span></label>
          <input type="date" name="semaine" class="form-control"
                 value="<?= old('semaine', $semaine) ?>" required>
          <div class="form-text">Indiquez le lundi de la semaine concernée.</div>
        </div>

        <div class="row g-3">
          <!-- Filière -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Filière <span class="text-danger">*</span></label>
            <select name="filiere_id" id="filiere_id" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php foreach ($filieres as $f): ?>
                <option value="<?= $f['id'] ?>" <?= old('filiere_id') == $f['id'] ? 'selected' : '' ?>>
                  <?= esc($f['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Cours (dynamique selon filière) -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Cours <span class="text-danger">*</span></label>
            <select name="cours_id" id="cours_id" class="form-select" required>
              <option value="">— Sélectionnez d'abord une filière —</option>
              <?php foreach ($cours as $c): ?>
                <option value="<?= $c['id'] ?>" data-filiere="<?= $c['filiere_id'] ?>"
                        <?= old('cours_id') == $c['id'] ? 'selected' : '' ?>>
                  <?= esc($c['intitule']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Enseignant -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Enseignant <span class="text-danger">*</span></label>
            <select name="enseignant_id" id="enseignant_id" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php foreach ($enseignants as $e): ?>
                <option value="<?= $e['id'] ?>" <?= old('enseignant_id') == $e['id'] ? 'selected' : '' ?>>
                  <?= esc($e['prenom'] . ' ' . $e['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Salle -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Salle <span class="text-danger">*</span></label>
            <select name="salle_id" id="salle_id" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php foreach ($salles as $s): ?>
                <option value="<?= $s['id'] ?>" <?= old('salle_id') == $s['id'] ? 'selected' : '' ?>>
                  <?= esc($s['nom']) ?> (cap. <?= $s['capacite'] ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Jour -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Jour <span class="text-danger">*</span></label>
            <select name="jour" id="jour" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php foreach ($jours as $j): ?>
                <option value="<?= $j ?>"
                        <?= old('jour', request()->getGet('jour') ?? '') == $j ? 'selected' : '' ?>>
                  <?= $j ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Heure début -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Heure début <span class="text-danger">*</span></label>
            <select name="heure_debut" id="heure_debut" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php
                $preHD = old('heure_debut', request()->getGet('heure_debut') ?? '');
                foreach ($creneaux as $hd => $hf):
              ?>
                <option value="<?= $hd ?>" <?= $preHD === $hd ? 'selected' : '' ?>>
                  <?= $hd ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Heure fin -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Heure fin <span class="text-danger">*</span></label>
            <select name="heure_fin" id="heure_fin" class="form-select" required>
              <option value="">— Sélectionner —</option>
              <?php
                $preHF = old('heure_fin', request()->getGet('heure_fin') ?? '');
                foreach ($creneaux as $hd => $hf):
              ?>
                <option value="<?= $hf ?>" <?= $preHF === $hf ? 'selected' : '' ?>>
                  <?= $hf ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" id="btnSubmit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i>Enregistrer
          </button>
          <a href="/edt/semaine/<?= esc($semaine) ?>" class="btn btn-outline-secondary">Annuler</a>
          <button type="button" id="btnVerifier" class="btn btn-outline-primary ms-auto">
            <i class="bi bi-shield-check me-1"></i>Vérifier les conflits
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// ── Filtre cours selon filière ────────────────────────────────────────────
document.getElementById('filiere_id').addEventListener('change', function () {
    const fid = this.value;
    const coursSelect = document.getElementById('cours_id');
    Array.from(coursSelect.options).forEach(opt => {
        opt.hidden = opt.value !== '' && opt.dataset.filiere !== fid;
    });
    coursSelect.value = '';
});
// Init au chargement si filière pré-sélectionnée
document.getElementById('filiere_id').dispatchEvent(new Event('change'));

// ── Synchroniser heure_debut → heure_fin ──────────────────────────────────
const creneaux = <?= json_encode($creneaux) ?>;
document.getElementById('heure_debut').addEventListener('change', function () {
    const fin = creneaux[this.value];
    if (fin) {
        const hfSelect = document.getElementById('heure_fin');
        Array.from(hfSelect.options).forEach(opt => {
            if (opt.value === fin) opt.selected = true;
        });
    }
});

// ── Vérification AJAX des conflits ───────────────────────────────────────
function collectData(excludeId = null) {
    return {
        semaine:       document.querySelector('[name=semaine]').value,
        filiere_id:    document.getElementById('filiere_id').value,
        cours_id:      document.getElementById('cours_id').value,
        enseignant_id: document.getElementById('enseignant_id').value,
        salle_id:      document.getElementById('salle_id').value,
        jour:          document.getElementById('jour').value,
        heure_debut:   document.getElementById('heure_debut').value,
        heure_fin:     document.getElementById('heure_fin').value,
        exclude_id:    excludeId || '',
    };
}

async function verifierConflits(excludeId = null) {
    const body = new URLSearchParams(collectData(excludeId));
    const res  = await fetch('/edt/check-conflicts', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded',
                   'X-Requested-With': 'XMLHttpRequest' },
        body
    });
    const json = await res.json();

    const box   = document.getElementById('conflitsAjax');
    const liste = document.getElementById('conflitsListe');
    const btn   = document.getElementById('btnSubmit');

    liste.innerHTML = '';
    if (json.count > 0) {
        json.conflits.forEach(c => {
            const li = document.createElement('li');
            li.textContent = c.message;
            liste.appendChild(li);
        });
        box.classList.remove('d-none');
        btn.disabled = true;
        btn.title = 'Veuillez résoudre les conflits avant d\'enregistrer.';
    } else {
        box.classList.add('d-none');
        btn.disabled = false;
        btn.title = '';
        if (document.getElementById('btnVerifier').dataset.clicked) {
            box.classList.remove('d-none');
            box.className = 'alert alert-success';
            liste.innerHTML = '<li>✅ Aucun conflit détecté.</li>';
        }
    }
    return json.count;
}

document.getElementById('btnVerifier').addEventListener('click', async function () {
    this.dataset.clicked = '1';
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Vérification...';
    await verifierConflits();
    this.innerHTML = '<i class="bi bi-shield-check me-1"></i>Vérifier les conflits';
});

// Vérification automatique à la soumission
document.getElementById('formEdt').addEventListener('submit', async function (e) {
    e.preventDefault();
    const count = await verifierConflits();
    if (count === 0) this.submit();
});
</script>

<?php $this->endSection(); ?>
