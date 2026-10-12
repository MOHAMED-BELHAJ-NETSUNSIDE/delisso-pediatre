<?php use App\Helpers\View; $r = $row ?? null; ?>
<h1 class="page-title"><?= $r ? 'Éditer cadeau' : 'Nouveau cadeau' ?></h1>
<form class="form-grid" method="post" enctype="multipart/form-data">
  <div><label>Nom</label><input name="name" required value="<?= View::e($r['name'] ?? '') ?>"></div>
  <?php if (!$r): ?>
  <div><label>Stock initial</label><input type="number" name="stock" value="0" min="0"></div>
  <?php endif; ?>
  <div><label>Seuil alerte</label><input type="number" name="seuil_alerte" value="<?= (int)($r['seuil_alerte'] ?? 10) ?>" min="0"></div>
  <div>
    <label>Image (sera compressée avant envoi)</label>
    <input type="file" name="image" id="cadeau-image" accept="image/*" data-compress="true">
    <?php if (!empty($r['image_path'])): ?>
      <p><img class="thumb" src="/<?= View::e($r['image_path']) ?>" alt=""></p>
    <?php endif; ?>
  </div>
  <div><label><input type="checkbox" name="active" <?= (($r['active'] ?? 1) ? 'checked' : '') ?>> Actif</label></div>
  <div><button class="btn btn-primary" type="submit">Enregistrer</button> <a class="btn" href="/admin/cadeaux">Retour</a></div>
</form>
