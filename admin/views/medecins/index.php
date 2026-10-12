<?php use App\Helpers\View; ?>
<h1 class="page-title">Médecins</h1>
<div class="toolbar">
  <form method="get" style="display:flex;gap:8px">
    <input type="search" name="q" value="<?= View::e($q ?? '') ?>" placeholder="Rechercher…">
    <button class="btn" type="submit">OK</button>
  </form>
  <a class="btn btn-primary" href="/admin/medecins/create">Ajouter</a>
</div>
<div class="table-wrap">
<table>
  <thead><tr><th>Nom</th><th>Type</th><th>Région</th><th>Classe</th><th>Actif</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= View::e($r['fullname']) ?></td>
      <td><?= (int)$r['type'] === 2 ? 'Sage-femme' : 'Pédiatre' ?></td>
      <td><?= View::e($r['region']) ?></td>
      <td><?= View::e($r['classe']) ?></td>
      <td><?= (int)$r['active'] ? 'Oui' : 'Non' ?></td>
      <td><a class="btn" href="/admin/medecins/<?= (int)$r['id'] ?>/edit">Éditer</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
