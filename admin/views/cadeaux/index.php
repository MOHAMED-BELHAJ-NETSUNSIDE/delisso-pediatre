<?php use App\Helpers\View; ?>
<h1 class="page-title">Cadeaux & stock</h1>
<?php if (!empty($canEdit)): ?>
<div class="toolbar"><a class="btn btn-primary" href="/admin/cadeaux/create">Nouveau cadeau</a></div>
<?php endif; ?>
<div class="table-wrap">
<table>
  <thead><tr><th>Image</th><th>Nom</th><th>Stock</th><th>Seuil</th><th>Actif</th><th>Actions</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?php if ($r['image_path']): ?><img class="thumb" src="/<?= View::e($r['image_path']) ?>" alt=""><?php endif; ?></td>
      <td><?= View::e($r['name']) ?></td>
      <td>
        <?php if ((int)$r['stock'] <= (int)$r['seuil_alerte']): ?>
          <span class="badge badge-warn"><?= (int)$r['stock'] ?></span>
        <?php else: ?>
          <span class="badge badge-ok"><?= (int)$r['stock'] ?></span>
        <?php endif; ?>
      </td>
      <td><?= (int)$r['seuil_alerte'] ?></td>
      <td><?= (int)$r['active'] ? 'Oui' : 'Non' ?></td>
      <td>
        <?php if (!empty($canEdit)): ?>
          <a class="btn" href="/admin/cadeaux/<?= (int)$r['id'] ?>/edit">Éditer</a>
        <?php endif; ?>
        <?php if (!empty($canStock)): ?>
          <form method="post" action="/admin/cadeaux/<?= (int)$r['id'] ?>/stock" style="display:inline-flex;gap:6px;margin-top:6px;align-items:center">
            <select name="type">
              <option value="in">Entrée</option>
              <option value="out">Sortie</option>
              <option value="adjust">Ajuster à</option>
            </select>
            <input type="number" name="qty" min="0" required style="width:80px" placeholder="Qty">
            <button class="btn btn-primary" type="submit">OK</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
