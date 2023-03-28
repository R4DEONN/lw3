<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <title>Form</title>
  </head>
  <body>
    <div class="user-content">
        <p><?= htmlentities($user->getUserId())?></p>
        <p><?= htmlentities($user->getFirstName()) ?></p>
        <p><?= htmlentities($user->getLastName()) ?></p>
        <?php if ($user->getMiddleName()): ?>
            <p><?= htmlentities($user->getMiddleName()) ?></p>
        <?php endif; ?>
        <p><?= htmlentities($user->getGender()) ?></p>
        <p><?= htmlentities($user->getBirthDate()) ?></p>
        <p><?= htmlentities($user->getEmail()) ?></p>
        <p><?= htmlentities($user->getPhone()) ?></p>
        <?php if ($user->getAvatarPath()): ?>
            <p><?= htmlentities($user->getAvatarPath()) ?></p>
        <?php endif; ?>
    </div>
  </body>
</html>