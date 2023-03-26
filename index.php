<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <title>Form</title>
    <link rel="stylesheet" href="styles/style.css" />
  </head>
  <body>
    <?php require_once("formmanager.php");?>
    <h1>Форма</h1>
    <form class='form paragraph' method="post" enctype="multipart/form-data">
      <p><input name="secondName" type="text" placeholder="Фамилия" required/><br/>
        <?php echo $secondNameError?>
      </p>
      <p><input name="firstName" type="text" placeholder="Имя" required/><br/><?php echo $firstNameError?></p>
      <p><input name="patronymic" type="text" placeholder="Отчество"/><br/><?php echo $patronymicError?></p>
      <p>
        <input name="gender" type="radio" value="male" checked/>
        Мужчина
      </p>
      <p>
        <input name="gender" type="radio" value="female" />
        Женщина
      </p>  
      <p><input name="birthday" type="date" required/></p>
      <p><input name="email" type="email" placeholder="Email" required/><br/><?php echo $emailError?></p>
      <p><input name="number" type="tel" placeholder="Номер телефона"/><br/><?php echo $numberError?></p>
      <p>
        Выберите аватар:
        <input name="avatar" type="file" value="Аватар" accept="image/png, image/jpeg"/>
      </p>
      <input name="submit" type="submit" value="Отправить" />
      <p><?php
          if ($exist === 1)
          {
              echo "Пользователь уже существует";
          }
          elseif ($exist === 2)
          {
              echo 'Пользователь успешно добавлен';
          }
        ?>
      </p>
    </form>
  </body>
</html>