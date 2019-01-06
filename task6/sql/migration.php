<?php
// Объявляем нужные константы
///var/run/postgresql
define('DB_HOST', 'localhost');
define('DB_USER', 'www-data');
define('DB_PASSWORD', '5621');
define('DB_NAME', 'battleship');
define('DB_TABLE_VERSIONS', 'versions');


// Подключаемся к базе данных
function connectDB() {
    $conn = new PDO("pgsql:host=".DB_HOST." port=5432 
        dbname=".DB_NAME." user=".DB_USER." password=".DB_PASSWORD);
    return $conn;
}


// Получаем список файлов для миграций
function getMigrationFiles($conn) {
    // Находим папку с миграциями
    $sqlFolder = realpath(dirname(__FILE__)) . '/';
    // Получаем список всех sql-файлов
    $allFiles = glob($sqlFolder . '*.sql');
    // Проверяем, есть ли таблица versions
    // Так как versions создается первой, то это равносильно тому, что база не пустая
    $query=$conn->query('SELECT tablename FROM pg_catalog.pg_tables');
    $resultArray=$query->fetchAll();

    $isFirstMigration=true;
    foreach ($resultArray as $value){
        // Первая миграция, возвращаем все файлы из папки sql
        if(array_search('versions',$value)){
            $isFirstMigration=false;
            break;
        }
    }

    if($isFirstMigration){
        return $allFiles;
    }

    // Ищем уже существующие миграции
    $versionsFiles = array();
    // Выбираем из таблицы versions все названия файлов
    $query = $conn->query('SELECT name FROM '.DB_TABLE_VERSIONS);
    $data = $query->fetchAll();
    // Загоняем названия в массив $versionsFiles
    // Не забываем добавлять полный путь к файлу
    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    // Возвращаем файлы, которых еще нет в таблице versions
    return array_diff($allFiles, $versionsFiles);
}


// Накатываем миграцию файла
function migrate($conn, $file) {
    // Формируем команду выполнения sql-запроса из внешнего файла
    $command = 'psql -d '.DB_NAME.' -f '.$file;
    // Выполняем shell-скрипт
    shell_exec($command);

    // Вытаскиваем имя файла, отбросив путь
    $baseName = basename($file);
    // Выполняем запрос
    $conn->query("INSERT INTO ".DB_TABLE_VERSIONS." (name) VALUES ('".$baseName."')");
}


// Стартуем

// Подключаемся к базе
$conn = connectDB();

// Получаем список файлов для миграций за исключением тех, которые уже есть в таблице versions
$files = getMigrationFiles($conn);

// Проверяем, есть ли новые миграции
if (empty($files)) {
    echo 'Ваша база данных в актуальном состоянии.';
} else {
    echo 'Начинаем миграцию...<br><br>';

    // Накатываем миграцию для каждого файла
    foreach ($files as $file) {
        migrate($conn, $file);
        // Выводим название выполненного файла
        echo basename($file) . '<br>';
    }

    echo '<br>Миграция завершена.';
}