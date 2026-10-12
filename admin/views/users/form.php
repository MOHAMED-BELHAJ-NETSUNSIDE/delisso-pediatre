<?php use App\Helpers\View; $r = $row ?? null; ?>
<h1 class="page-title"><?= $r ? 'Éditer utilisateur' : 'Nouvel utilisateur' ?></h1>
<form class="form-grid" method="post">
  <div><label>Nom</label><input name="name" required value="<?= View::e($r['name'] ?? '') ?>"></div>
  <div><label>Email</label><input type="email" name="email" required value="<?= View::e($r['email'] ?? '') ?>"></div>
  <div><label>Rôle</label>
    <select name="role" required>
      <?php foreach (['admin','gestionnaire','statistiques','delegue'] as $role): ?>
        <option value="<?= $role ?>" <?= (($r['role'] ?? '') === $role) ? 'selected' : '' ?>><?= $role ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div><label>Mot de passe <?= $r ? '(laisser vide pour ne pas changer)' : '' ?></label>
    <input type="password" name="password" <?= $r ? '' : 'required' ?>>
  </div>
  <div><label><input type="checkbox" name="active" <?= (($r['active'] ?? 1) ? 'checked' : '') ?>> Actif</label></div>
  <div><button class="btn btn-primary" type="submit">Enregistrer</button> <a class="btn" href="/admin/users">Retour</a></div>
</form>
