<?php use App\Helpers\View; $v = $visite; ?>
<h1 class="page-title">Visite #<?= (int)$v['id'] ?></h1>
<div class="card" style="margin-bottom:16px">
  <p><strong>Médecin :</strong> <?= View::e($v['medecin_name']) ?></p>
  <p><strong>Délégué :</strong> <?= View::e($v['delegue_name']) ?></p>
  <p><strong>Date :</strong> <?= View::e($v['created_at']) ?></p>
  <p><strong>N° visite :</strong> <?= (int)$v['nvisite'] ?> — <strong>Classe :</strong> <?= View::e($v['classe']) ?></p>
  <p><strong>Région :</strong> <?= View::e($v['region']) ?> / <?= View::e($v['municipalite']) ?></p>
  <p><strong>GPS :</strong> <?= View::e($v['gps']) ?></p>
  <p><strong>Remarque :</strong> <?= nl2br(View::e($v['remarque'])) ?></p>
</div>
<div class="table-wrap" style="margin-bottom:16px">
  <table>
    <thead><tr><th>Cadeau</th><th>Qté</th></tr></thead>
    <tbody>
    <?php foreach ($cadeaux as $c): ?>
      <tr><td><?= View::e($c['name']) ?></td><td><?= (int)$c['qty'] ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="toolbar">
  <?php foreach ($photos as $p): ?>
    <a href="/<?= View::e($p['path']) ?>" target="_blank"><img class="thumb" src="/<?= View::e($p['path']) ?>" alt="photo"></a>
  <?php endforeach; ?>
</div>
<p><a class="btn" href="/admin/visites">Retour</a></p>
