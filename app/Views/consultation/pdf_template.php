<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, sans-serif; font-size: 8px; background: #fff; }

/* ─── EN-TÊTE ─────────────────────────────────────────────── */
.entete { width:100%; border-collapse:collapse; margin-bottom:6px;text-align: center; }
.entete td { vertical-align:top; padding:1px 3px; font-size:6.5px; line-height:1.8; }
.centre { text-align:center; vertical-align:middle; }
.droite { text-align:right; text-align: center;}

/* ─── TITRE ───────────────────────────────────────────────── */
.titre-box {
    border: 2px solid #7B2D8B;
    border-radius: 10px;
    text-align: center;
    padding: 5px 10px;
    margin-bottom: 6px;
    margin-left:200px;
    margin-right: 200px;
}
.titre-box h2 {
    font-size: 13px;
    text-decoration: underline;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 3px;
}
.titre-box .ligne1 { font-size: 8.5px; margin-bottom: 2px; }
.titre-box .ligne2 { font-size: 8.5px; }
.rouge   { color: #cc0000; font-weight: bold; }
.souligne { text-decoration: underline; }

/* ─── TABLEAU EDT ─────────────────────────────────────────── */
.edt { width:95%; border-collapse:collapse; margin-bottom:5px; border: 2px solid #000;margin-left: 18px; }

/* EN-TÊTES : BLANC fond, NOIR texte — conforme au PDF officiel ENSPM */
.edt thead tr th {
    background-color: #ffffff !important;
    color: #000000 !important;
    border: 1px solid #000;
    padding: 6px 4px;
    text-align: center;
    font-size: 9px;
    font-weight: bold;
    letter-spacing: 0.3px;
}

/* CELLULES CORPS */
.edt tbody td {
    /*border: 1px solid #000;*/
    border: 2px solid #00af50;
    padding: 5px 3px;
    text-align: center;
    vertical-align: middle;
    background-color: #ffffff;
}

/* Cellule horaire */
.td-horaire {
    width: 9%;
    font-weight: bold;
    font-size: 8px;
    text-align: center;
    vertical-align: middle;
    background-color: #ffffff;
}

/* ─── CONTENU COURS ───────────────────────────────────────── */
.c-nom  { font-weight: bold; font-size: 7.5px; line-height: 1.3; }
.c-code { font-size: 7.5px; font-weight: normal; color: #000; }
.c-vol  { font-size: 7px; color: #000000; margin-top: 1px; }
.c-ens  { font-size: 7.5px; color: #cc0000; font-weight: bold; margin-top: 2px; }

/* ─── LIGNE PAUSE ─────────────────────────────────────────── */
.pause-horaire {
    background-color: #b8cfe8 !important;
    border: 1px solid #000;
    font-weight: bold;
    font-size: 8px;
    text-align: center;
    padding: 4px;
    vertical-align: middle;
}
.pause-texte {
    background-color: #b8cfe8 !important;
    border: 1px solid #000;
    font-weight: bold;
    font-size: 15px;
    text-align: center;
    letter-spacing: 4px;
    padding: 6px 4px;
    vertical-align: middle;
}

/* ─── PIED DE PAGE ────────────────────────────────────────── */
.footer { width:100%; border-collapse:collapse; margin-top: 4px; }
.footer td { vertical-align:top; padding:0 2px; }
.note { font-size: 6.5px; line-height: 1.6; }
.note a { color: #000; }
.directeur { text-align:right; font-weight:bold; font-size:8.5px; }

/* ─── LOGO central ────────────────────────────────────────── */
.logo-centre img { max-height: 60px; }
</style>
</head>
<body>

<!-- ══════════════════════════════════════════════════════════
     EN-TÊTE OFFICIEL ENSPM
     ══════════════════════════════════════════════════════════ -->
<table class="entete">
<tr>
    <td style="width:35%">
        <strong>République du Cameroun</strong><br>
        <strong> <em>Paix-Travail-Patrie <strong></em><br>
        -------------<br>
        <strong>Ministère de l'Enseignement Supérieur<br> <strong>
        --------------<br>
        <strong>UNIVERSITÉ DE MAROUA</strong><br>
        --------------<br>
        <strong>ECOLE NATIONALE SUPERIEURE POLYTECHNIQUE</strong><br>
        ---------------<br>
        <strong> Département d'Informatique et des Télécommunications <strong>
    </td>
    <td style="width:30%" class="centre logo-centre">
        <!-- Logo ENSPM : remplacez le chemin si nécessaire -->
        <?php if (file_exists(FCPATH . 'assets/img/logo_uma.png')): ?>
          <img src="<?= base_url('assets/img/logo_uma.png') ?>" alt="Logo UMA"><br>
        <?php endif; ?>
        B.P./P.O. Box : 46 Maroua<br>
        Tel : (+237) 22 62 03 76 / (+237) 22 62 08 90<br>
        Fax : (+237) 22 29 31 12 / (+237) 22 29 15 41<br>
        Site web : http://www.enspm-univ-maroua.cm<br>
        Email : polytech@univ-maroua.cm
    </td>
    <td style="width:35%" class="droite">
        <strong>Republic of Cameroon</strong><br>
        <strong><em>Peace-Work-Fatherland</em><br> <strong>
        -------------<br>
        <strong> Ministry of Higher Education<br> <strong>
        -------------<br>
        <strong>THE UNIVERSITY OF MAROUA</strong><br>
        -------------<br>
        <strong>NATIONAL ADVANCED SCHOOL OF ENGINEERING</strong><br>
        ---------------<br>
        <strong>Department of Computer Science and Telecommunications <strong>
    </td>
</tr>
</table>

<!-- ══════════════════════════════════════════════════════════
     TITRE
     ══════════════════════════════════════════════════════════ -->
<div class="titre-box">
    <h2>EMPLOI DE TEMPS</h2>
    <p class="ligne1">
        Année académique 2025 - 2026 - Semestre I -
        <span class="rouge souligne">période du <?= esc($periode) ?></span>
    </p>
    <p class="ligne2">
        Site : Campus de Sékandé &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="rouge">Salle : <?= esc($salle_nom) ?></span>
    </p>
</div>

<!-- ══════════════════════════════════════════════════════════
     GRILLE EDT
     ══════════════════════════════════════════════════════════ -->
<table class="edt">
    <thead>
        <tr>
            <th style="width:9%">HORAIRES</th>
            <?php foreach($jours as $jour): ?>
                <th><?= strtoupper($jour) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($creneaux_horaires as $hd => $hf):
        $hd_fmt = ltrim(str_replace(':', 'H', substr($hd, 0, 5)), '0');
        $hf_fmt = ltrim(str_replace(':', 'H', substr($hf, 0, 5)), '0');
    ?>
        <!-- Ligne de PAUSE insérée avant 14H00 -->
        <?php if ($hd === '14:00'): ?>
        <tr>
            <td class="pause-horaire">13H30 - 14H00</td>
            <td class="pause-texte" colspan="<?= count($jours) ?>">PAUSE</td>
        </tr>
        <?php endif; ?>

        <tr>
            <td class="td-horaire"><?= $hd_fmt ?> - <?= $hf_fmt ?></td>
            <?php foreach($jours as $jour): ?>
            <td>
                <?php if (isset($grille[$hd][$jour])):
                    $c = $grille[$hd][$jour]; ?>
                    <div class="c-nom"><?= esc($c['cours_nom']) ?></div>
                    <?php if (!empty($c['cours_code'])): ?>
                    <div class="c-code"><?= esc($c['cours_code']) ?></div>
                    <?php endif; ?>
                    <div class="c-vol">(CM:<?= $c['volume_cm'] ?? 30 ?>h, TD:<?= $c['volume_td'] ?? 20 ?>h, TP:<?= $c['volume_tp'] ?? 30 ?>h, TPE:<?= $c['volume_tpe'] ?? 10 ?>h)</div>
                    <div class="c-ens"><?= esc(trim($c['ens_nom'] . ' ' . $c['ens_prenom'])) ?></div>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- ══════════════════════════════════════════════════════════
     PIED DE PAGE
     ══════════════════════════════════════════════════════════ -->
<table class="footer">
<tr>
    <td class="note" style="width:78%">
        NB : Ce calendrier est dynamique et susceptible d'être modifié,
        les étudiants sont invités à bien vouloir régulièrement consulter
        le babillard et le Site Web de l'ECOLE NATIONALE SUPERIEURE POLYTECHNIQUE
        pour s'enquérir des dernières modifications.
        <a href="http://enspm.univ-maroua.cm">http://enspm.univ-maroua.cm</a>
        &nbsp;
        <a href="mailto:enspm@univ-maroua.cm">enspm@univ-maroua.cm</a>
    </td>
    <td class="directeur" style="width:22%">Le Directeur,</td>
</tr>
</table>

</body>
</html>