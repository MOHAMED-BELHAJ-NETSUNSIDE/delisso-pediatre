<?php use App\Helpers\View; ?>
<h1 class="page-title">Utilisateurs</h1>
<div class="toolbar"><a class="btn btn-primary" href="/admin/users/create">Ajouter</a></div>
<div class="table-wrap">
<table>
  <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Actif</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= View::e($r['name']) ?></td>
      <td><?= View::e($r['email']) ?></td>
      <td><span class="badge"><?= View::e($r['role']) ?></span></td>
      <td><?= (int)$r['active'] ? 'Oui' : 'Non' ?></td>
      <td><a class="btn" href="/admin/users/<?= (int)$r['id'] ?>/edit">Éditer</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
