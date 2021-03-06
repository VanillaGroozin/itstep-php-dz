<?php

  // Задание: написать валидацию "формы" добавления книги на сайт
  // В качестве данных формы использоват переменны со СТРОКОВЫМИ значениями
  // Пункты со звездочкой * выполнять не обязательно. Если не получится самостоятельно, мы в любом случае реализуем их вместе на занятии.

  /**
   * Массив ошибок
   * В качестве ключей использовать название переменной 
   */
  $errors = [];
    // @$errors['title']
    // @$errors['author']  
    // @$errors['year']  
    // @$errors['isbn']  
    // @$errors['isAvailable']  

    function strTrim(string $str) {
        $clean = trim($str);
        while (strpos($clean, '  '))
        {
            $clean = str_replace('  ', ' ', $clean);
        }
        $final = '';
        //Делаю это, потому что первый пробел не тримится
        foreach (explode(' ', $clean) as $item) {
            if (strlen($final)){
                $final = $final . ' ' . $item;
            } else {
                $final = $final . $item;
            }
        }
        return $final;
    }
  /**
   * 1. Название книги (string)
   *    а  обрезать лишние пробелы слева и справа
   *    б  проверить что поле не пустое => Добавить ошибку "Обязательное поле"
   *    в* преобразовать все последовательности пробелов в один пробел: Например "Война      и  мир" => "Война и мир"
   */
  $title = "   Война   и  мир"; // "Пользовательский ввод". Меняйте это значение для тестирования вашей реализации. 
  $titleClean = strTrim($title); // В эту переменную нужно записать "очищеное" значение. Без лишних пробелов и т.д.

  $errors['title'] = $titleClean ? '' : 'Обязательное поле';

  // > Ваш код для валидации $title

  /**
   * 2. Автор (string)
   *    а  обрезать лишние пробелы слева и справа
   *    б  проверить что поле не пусое => Добавить ошибку "Обязательное поле"
   *    в* преобразовать все последовательности пробелов в один пробел: Например "Лев   Толстой" => "Лев Толстой"
   *    г* убедиться, что имена написаны с большой буквы: "лев толстой" => "Лев Толстой"
   */
  $author = "  Lev tolstoi  "; // "Пользовательский ввод". Меняйте это значение для тестирования вашей реализации. 
  $authorTemp = strTrim($author); // В эту переменную нужно записать "очищеное" значение. Без лишних пробелов и т.д.
  $authorClean ='';
  foreach (explode(' ', $authorTemp) as $item) {
    if (strlen($authorClean)){
        $authorClean = $authorClean . ' ' . ucfirst($item);
    } else {
        $authorClean = $authorClean . ucfirst($item);
    }
  }
  $errors['author'] = $authorClean ? '' : 'Обязательное поле';
  // > Ваш код для валидации $author
  
  /**
   * 3. Год (int)
   *    а  обрезать лишние пробелы слева и справа
   *    б  поле не обязательное, поэтому следующие проверки делать только если есть значение
   *    в  проверить, что значение - целое число => Добавить ошибку "Год должен быть числом"
   *    г  преобразовать в число integer
   *    д  проверить, что год находится в промежутке от 1500 до 2020 => Добавить ошибку "Недопустимый год" 
   */
  $year = "2010";
  $yearClean = strTrim($year); // "Пользовательский ввод". Меняйте это значение для тестирования вашей реализации. 
  if ($year) { 
    $errors['year'] = '';
    if (!is_numeric($year) || (int)$year != (float)$year) $errors['year'] = "Год должен быть числом";
    else if ((int)$year < 1500 || (int)$year > 2020) $errors['year'] = "Недопустимый год";
  } 
  // В эту переменную нужно записать "очищеное" значение, преобразованное в integer
  // Ваш код для валидации $year

  /**
   * 4. ISBN - муждународный код книги (string)
   * Это десятизначиный код, состоящий из 4 груп переменной длины разделенных дефисом. 
   * Первые три группы состоят только из цифр. Послденяя - один символ: цифра или X
   * Примеры: 0-8044-2957-X или 85-359-0277-5
   *    a  обрезать лишние пробелы слева и справа
   *    б  поле не обязательное, поэтому следующие проверки делать только если есть значение
   *    в  убрать лишние пробелы из середины строки, если имеются
   *    г  проверить, что код состоит ровно из 4 групп разделенных дефисом => Добавить ошибку "Неверный ISBN"
   *    д  проверить, что первые три групп состоят только из цифр => Добавить ошибку "Неверный ISBN"
   *    е  проверить, что последняя группа - это одна цифра или X => Добавить ошибку "Неверный ISBN"
   *    ж* заменить три вышеперечисленные проверки одним регулярным выражением => Добавить ошибку "Неверный ISBN"
   */
  $isbn = "0-8044-2957-X";
  $isbnClean = strTrim($isbn); // "Пользовательский ввод". Меняйте это значение для тестирования вашей реализации. 
  $splitted = explode('-',$isbn);
  if ($isbn) {
    if (!preg_match("/\d{1,10}-\d{1,10}-\d{1,10}-[A-Za-z0-9]$/", $isbn)){
      $errors['isbn'] = "Неверный ISBN";
    }
    else $errors['isbn'] ='';
  }
  // В эту переменную нужно записать "очищеное" значение. Без лишних пробелов и т.д.
  // Ваш код для валидации $isbn

  /**
   * 5. Доступна ли книга (bool)
   *    а  преобразовать в тип bool. Пустая строка - false, любая другая - true
   */
  $isAvailable = ""; // "Пользовательский ввод". Меняйте это значение для тестирования вашей реализации. 
  $isAvailableClean = strlen($isAvailable) > 0 ? true : false; // В эту переменную нужно записать "очищеное" значение, преобразованное в bool
  $errors['isAvailable'] = $isAvailableClean ? '' : "Не доступна";

  // Ваш код для валидации $isAvailable


  // Результат валидации и нормализации ввода.
  // ! Этот код менять не нужно. Он выводит результат в наглядном виде

  $form = [
    [
      "Название",
      $title,
      $titleClean,
      @$errors['title']
    ],
    [
      "Автор",
      $author,
      $authorClean,
      @$errors['author']  
    ],
    [
      "Год издания",
      $year,
      $yearClean,
      @$errors['year']  
    ],
    [
      "ISBN",
      $isbn,
      $isbnClean,
      @$errors['isbn']  
    ],
    [
      "Доступно",
      $isAvailable,
      $isAvailableClean,
      @$errors['isAvailable']  
    ]
  ];
  
?>

<!-- 

<html>
<head>
  <style>

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    table {
      margin: 24px auto;
      border-spacing: 1px 4px;
      font: 16px sans-serif;
      width: 800px;
    }

    td {
      padding: 10px 6px;
    }

    .invalid td {
      background-color: hsl(10, 70%, 90%);
    }

    .valid td {
      background-color: hsl(120, 70%, 90%);
    }

    .name {
      width: 14%;
    }

    .value, .clean {
      width: 23%;
    }

    .error {
      width: 40%;
    }

  </style>
</head>
<body>
  <table>
  
    <tr>
      <td class="name">&nbsp;</td>
      <td class="value">Значение на входе</td>
      <td class="clean">Нормализованное</td>
      <td class="error">Ошибка</td>
    </tr>
    
    <?php foreach ($form as [$name, $value, $clean, $error]) {?>
    <tr class="<?=$error ? "invalid" : "valid"?>">
      <td class="name"><?=$name?></td>
      <td class="value"><pre><?=var_export($value, true)?><pre></td>
      <td class="clean"><pre><?=var_export($clean, true)?><pre></td>
      <td class="error"><?=$error?></td>
    </tr>
    
    <?php }?>
  </table>
</body>
</html> -->


<?php
namespace pd\core;

$routes = [
  new Route("/","Index","index"),
  new Route("/books","Books","list")
];

$uri = $_SERVER['REQUEST_URI'];

$uri = explode("?", $uri, 2)[0];

var_dump($uri);

$current = null;
foreach($routes as $route) {
  if($route->match($uri)){
    $current = $route;
    break;
  }
}

if (!$current){
  echo 404;
  exit;
}

$controller = "pd\\controllers\\{$current->controller}Controller";
$controller = new $controller();
