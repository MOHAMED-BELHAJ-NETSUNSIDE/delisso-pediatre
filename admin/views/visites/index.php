<?php use App\Helpers\View; ?>
<h1 class="page-title">Visites</h1>
<form class="toolbar" method="get">
  <label>Du <input type="date" name="from" value="<?= View::e($filters['from'] ?? '') ?>"></label>
  <label>Au <input type="date" name="to" value="<?= View::e($filters['to'] ?? '') ?>"></label>
  <button class="btn btn-primary" type="submit">Filtrer</button>
</form>
<div class="table-wrap">
<table>
  <thead><tr><th>Date</th><th>Médecin</th><th>Délégué</th><th>N° visite</th><th>Région</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= View::e($r['created_at']) ?></td>
      <td><?= View::e($r['medecin_name']) ?></td>
      <td><?= View::e($r['delegue_name']) ?></td>
      <td><?= (int)$r['nvisite'] ?></td>
      <td><?= View::e($r['region']) ?></td>
      <td><a class="btn" href="/admin/visites/<?= (int)$r['id'] ?>">Détail</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
