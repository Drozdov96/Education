<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Задание 2.</title>
</head>
<body>
<style>
body p, body input{
    display:inline;
}
</style>
<div style="width:40%;">
    <form action="task2.php" method="POST" />
    <h3>Введите данные о себе:</h3>
    <p>Имя: </p> <input type="text" name="name" placeholder="Введите имя" required />
    <br>
    <p>Фамилия: </p> <input type="text" name="surname" placeholder="Введите фамилию" required />
    <br>
    <p>Возраст: </p> <input type="number" name="age" placeholder="Введите возраст" min="1" max="100" required />
    <br>
    <p>Пол: </p> <input type="radio" name="gender" value="мужчина" checked />Мужчина
    <input type="radio" name="gender" value="женщина" />Женщина
    <br>
    <p>Почтовый индекс: </p> <input type="number" name="postCode" placeholder="Введите почтовый индекс" min="100000" max="999999" required />
    <br>
    <p>Вы беременны? </p> <input type="checkbox" name="isPregnant" value="true" />
    <br>
    <p>Вы являетесь студентом? </p> <input type="checkbox" name="isStudent" value="true" />
    <br>
    <input type="submit" name="submitBtn" value="Отправить" />
</div>
<br>
</body>
</html>