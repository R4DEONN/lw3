<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <title>Form</title>
  </head>
  <body>
    <div class="user-content">
        <p><?= htmlentities($user['first_name']) ?></p>
        <p><?= htmlentities($user['last_name']) ?></p>
        <?php if ($user['middle_name']): ?>
            <p><?= htmlentities($user['middle_name']) ?></p>
        <?php endif; ?>
        <p><?= htmlentities($user['gender']) ?></p>
        <p><?= htmlentities($user['birth_date']) ?></p>
        <p><?= htmlentities($user['email']) ?></p>
        <p><?= htmlentities($user['phone']) ?></p>
        <?php if ($user['avatar_path']): ?>
            <p><?= htmlentities($user['avatar_path']) ?></p>
        <?php endif; ?>
    </div>
  </body>
</html>