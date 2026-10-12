<?php use App\Helpers\View; ?>
<h1 class="page-title">Établissements</h1>
<form class="toolbar" method="post" action="/admin/etablissements/create">
  <input name="name" required placeholder="Nom établissement">
  <button class="btn btn-primary" type="submit">Ajouter</button>
</form>
<div class="table-wrap">
<table>
  <thead><tr><th>ID</th><th>Nom</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr><td><?= (int)$r['id'] ?></td><td><?= View::e($r['name']) ?></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
