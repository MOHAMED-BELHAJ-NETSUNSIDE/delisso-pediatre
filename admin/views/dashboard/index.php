<?php use App\Helpers\View; $s = $stats; ?>
<h1 class="page-title">Dashboard</h1>
<form class="toolbar" method="get">
  <label>Du <input type="date" name="from" value="<?= View::e($s['from']) ?>"></label>
  <label>Au <input type="date" name="to" value="<?= View::e($s['to']) ?>"></label>
  <button class="btn btn-primary" type="submit">Filtrer</button>
</form>
<div class="cards">
  <div class="card"><div class="label">Visites du jour</div><div class="value"><?= (int) $s['visites_jour'] ?></div></div>
  <div class="card"><div class="label">Visites période</div><div class="value"><?= (int) $s['visites_periode'] ?></div></div>
  <div class="card"><div class="label">Alertes stock</div><div class="value"><?= count($s['stock_bas']) ?></div></div>
</div>

<div class="table-wrap" style="margin-bottom:18px">
  <table>
    <thead><tr><th>Stock bas</th><th>Stock</th><th>Seuil</th></tr></thead>
    <tbody>
    <?php if (!$s['stock_bas']): ?>
      <tr><td colspan="3">Aucune alerte</td></tr>
    <?php else: foreach ($s['stock_bas'] as $row): ?>
      <tr>
        <td><?= View::e($row['name']) ?></td>
        <td><span class="badge badge-warn"><?= (int) $row['stock'] ?></span></td>
        <td><?= (int) $row['seuil_alerte'] ?></td>
      </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Top cadeaux (période)</th><th>Quantité</th></tr></thead>
    <tbody>
    <?php if (!$s['top_cadeaux']): ?>
      <tr><td colspan="2">Pas encore de données</td></tr>
    <?php else: foreach ($s['top_cadeaux'] as $row): ?>
      <tr>
        <td><?= View::e($row['name']) ?></td>
        <td><?= (int) $row['total'] ?></td>
      </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
