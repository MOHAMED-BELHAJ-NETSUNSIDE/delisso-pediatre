<?php use App\Helpers\View; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion — Delisso Tournée Pédiatre</title>
  <link rel="icon" href="/assets/logo-delisso.png">
  <link rel="stylesheet" href="/css/admin.css">
</head>
<body class="login-page">
  <div class="login-card">
    <img class="logo" src="/assets/logo-delisso.png" alt="Delisso">
    <h1>Tournée Pédiatre</h1>
    <p>Back-office — connexion sécurisée</p>

    <?php if (!empty($flash)): ?>
      <div class="error"><?= View::e($flash['msg']) ?></div>
    <?php endif; ?>
    <?php if (($error ?? null) === 'role'): ?>
      <div class="error">Ce compte n’a pas accès au back-office.</div>
    <?php endif; ?>

    <form method="post" action="/admin/login" autocomplete="username">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" required placeholder="admin@delisso.local">

      <label for="password">Mot de passe</label>
      <input id="password" type="password" name="password" required placeholder="••••••••">

      <button type="submit">Se connecter</button>
    </form>
  </div>
</body>
</html>
