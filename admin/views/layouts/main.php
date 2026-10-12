<?php
use App\Auth\Auth;
use App\Helpers\View;
$user = Auth::user();
$role = $user['role'] ?? '';
$page = $page ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Danino Tournée Pédiatre</title>
  <link rel="icon" href="/assets/logo-danino.png">
  <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<div class="app-shell">
  <aside class="sidebar">
    <div class="brand">
      <img src="/assets/logo-danino.png" alt="Danino">
      <span>Tournée Pédiatre</span>
    </div>
    <nav>
      <?php if (in_array($role, ['admin', 'statistiques', 'gestionnaire'], true)): ?>
        <a href="/admin/dashboard" class="<?= $page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
      <?php endif; ?>
      <?php if ($role === 'admin'): ?>
        <a href="/admin/medecins" class="<?= $page === 'medecins' ? 'active' : '' ?>">Médecins</a>
      <?php endif; ?>
      <?php if (in_array($role, ['admin', 'gestionnaire'], true)): ?>
        <a href="/admin/cadeaux" class="<?= $page === 'cadeaux' ? 'active' : '' ?>">Cadeaux & stock</a>
      <?php endif; ?>
      <?php if (in_array($role, ['admin', 'statistiques'], true)): ?>
        <a href="/admin/visites" class="<?= $page === 'visites' ? 'active' : '' ?>">Visites</a>
      <?php endif; ?>
      <?php if ($role === 'admin'): ?>
        <a href="/admin/users" class="<?= $page === 'users' ? 'active' : '' ?>">Utilisateurs</a>
        <a href="/admin/etablissements" class="<?= $page === 'etablissements' ? 'active' : '' ?>">Établissements</a>
      <?php endif; ?>
      <a href="/admin/logout">Déconnexion</a>
    </nav>
    <div class="user-box">
      <?= View::e($user['name'] ?? '') ?><br>
      <strong><?= View::e($role) ?></strong>
    </div>
  </aside>
  <main class="main">
    <?php if (!empty($flash)): ?>
      <div class="flash flash-<?= $flash['type'] === 'ok' ? 'ok' : 'err' ?>"><?= View::e($flash['msg']) ?></div>
    <?php endif; ?>
    <?= $content ?>
  </main>
</div>
<script src="/js/image-compress.js"></script>
</body>
</html>
