<?php
    const EMAIL = "email";
    const SECOND_NAME = "secondName";
    const FIRST_NAME = "firstName";
    const MIDDLE_NAME = "middleName";
    const BIRTHDAY = "birthday";
    const NUMBER = "number";
    const GENDER = "gender";
    const AVATAR = "avatar";    
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <title>Form</title>
    <link rel="stylesheet" href="/../../public/styles/style.css" />
  </head>
  <body>
    <?php require_once(__DIR__ . '/../../public/add_user.php');?>
    <h1>Форма</h1>
    <form class='form paragraph' method="post" enctype="multipart/form-data">
      <p><input name="secondName" type="text" placeholder="Фамилия" required/><br/>
        <?= htmlentities($errors['secondNameError'] ?? "") ?>
      </p>
      <p><input name="firstName" type="text" placeholder="Имя" required/><br/><?= htmlentities($errors['firstNameError'] ?? "") ?></p>
      <p><input name="middleName" type="text" placeholder="Отчество"/><br/><?= htmlentities($errors['middleNameError'] ?? "") ?></p>
      <p>
        Пол:
        <input name="gender" type="radio" value="male" checked/>
        Мужчина
        <input name="gender" type="radio" value="female" />
        Женщина
      </p>  
      <p><input name="birthday" type="date" required/></p>
      <p><input name="email" type="email" placeholder="Email" required/><br/><?= htmlentities($errors['emailError'] ?? "") ?></p>
      <p><input name="number" type="tel" placeholder="Номер телефона"/><br/><?= htmlentities($errors['numberError'] ?? "") ?></p>
      <p>
        Выберите аватар:
        <input name="avatar" type="file" value="Аватар" accept="image/png,image/jpeg,image/gif"/><br/>
        <?= htmlentities($errors['avatarError'] ?? "") ?>
      </p>
      <input name="submit" type="submit" value="Отправить" />
    </form>
  </body>
</html>