<?php use App\Helpers\View; $r = $row ?? null; ?>
<h1 class="page-title"><?= $r ? 'Éditer médecin' : 'Nouveau médecin' ?></h1>
<form class="form-grid" method="post">
  <div><label>Nom complet</label><input name="fullname" required value="<?= View::e($r['fullname'] ?? '') ?>"></div>
  <div><label>Type</label>
    <select name="type">
      <option value="1" <?= (($r['type'] ?? 1) == 1) ? 'selected' : '' ?>>Pédiatre</option>
      <option value="2" <?= (($r['type'] ?? 1) == 2) ? 'selected' : '' ?>>Sage-femme</option>
    </select>
  </div>
  <div><label>Région</label><input name="region" value="<?= View::e($r['region'] ?? '') ?>"></div>
  <div><label>Municipalité</label><input name="municipalite" value="<?= View::e($r['municipalite'] ?? '') ?>"></div>
  <div><label>Type établissement</label>
    <select name="etab">
      <option value="">—</option>
      <option value="1" <?= (($r['etab'] ?? '') == 1) ? 'selected' : '' ?>>Hôpital</option>
      <option value="2" <?= (($r['etab'] ?? '') == 2) ? 'selected' : '' ?>>Clinique</option>
      <option value="3" <?= (($r['etab'] ?? '') == 3) ? 'selected' : '' ?>>Cabinet</option>
    </select>
  </div>
  <div><label>Nom établissement</label>
    <input name="name_etab" list="etabs" value="<?= View::e($r['name_etab'] ?? '') ?>">
    <datalist id="etabs">
      <?php foreach ($etabs as $e): ?><option value="<?= View::e($e['name']) ?>"></option><?php endforeach; ?>
    </datalist>
  </div>
  <div><label>Adresse</label><input name="adresse" value="<?= View::e($r['adresse'] ?? '') ?>"></div>
  <div><label>Téléphone</label><input name="tel" value="<?= View::e($r['tel'] ?? '') ?>"></div>
  <div><label>Email</label><input type="email" name="email" value="<?= View::e($r['email'] ?? '') ?>"></div>
  <div><label>Classe</label>
    <select name="classe">
      <option value="">—</option>
      <?php foreach (['A','A+','B','C'] as $c): ?>
        <option value="<?= $c ?>" <?= (($r['classe'] ?? '') === $c) ? 'selected' : '' ?>><?= $c ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div><label><input type="checkbox" name="active" <?= (($r['active'] ?? 1) ? 'checked' : '') ?>> Actif</label></div>
  <div><button class="btn btn-primary" type="submit">Enregistrer</button> <a class="btn" href="/admin/medecins">Retour</a></div>
</form>
