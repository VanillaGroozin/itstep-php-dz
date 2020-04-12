<?php
// !!! Вынести следующий код в отдельный файл и подключить его в этот
// validation.php



/**
 * Функция проверяет и нормализует входные данные формы
 * в соотвествии с указанной схемой валидации
 * 
 * !! Функция должна принимать аргументы и возвращать значения в том формате что указа здесь
 * 
 * Если будете реализовывать возможность последовательных валидаторов, не забудьте, 
 * во-первых, что возникновение ошибки в одном из валидаторов должно останавливать проверку текущего поля
 * во-вторых, очищенные значения должны передаваться по цепочке
 * 
 * @param mixed[] $scheme схема валидации 
 * @param string[] $form данные формы 
 * @return array[] Возврвщвет массив нормальизованных данных и массив ошибок
 */
function sTrim(string $str) {
    return function($value) use ($str) {
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
    };
}
function isYear(int $year){
    return function ($value) use ($year)
    {
        $error = '';
        if (!is_numeric($year) || (int)$year != (float)$year) $error = "Год должен быть числом";
        return $error;
    };
}

function upperFirst($str) {
    return function ($value) use ($str)
    {
      $clean ='';
      foreach (explode(' ', $value) as $item) {          
          if (strlen($clean)) {
              $clean = $clean . ' ' . ucfirst($item);
          } else {
              $clean = $clean . ucfirst($item);
          }
          var_dump($clean);
      }
      return $clean;
    };
}

function validateForm($scheme, $form) {
  //var_dump($scheme);
  // foreach($scheme as $schemePart) {
  //   foreach($schemePart as $schemeElement){
  //     var_dump($schemeElement($form[$schemePart]));
  //   }
  // }
  //title
  $clean["title"] = $scheme["title"]["clear-extra-spaces"]($form["title"]);
  $errors["title"] = $scheme["title"]["require"];

  //author
  $clean["author"] = $scheme["author"]["upperfirst"]($scheme["author"]["clear-extra-spaces"]($form["author"]));
  $errors["author"] = $scheme["author"]["require"];
  
  //year
  // "year" => [
  //   "clear-extra-spaces"  => sTrim($form['year']),
  //   "integer" => isYear($form['year']),
  //   "year-in-range" => generateRangeValidator(1500, 2020) // ! Один из вариантов решения
  // ],
  $clean["year"] = $scheme["year"]["clear-extra-spaces"]($form["year"]);
  $errors["year"] = $scheme["year"]["integer"]($form["year"]) . $scheme["year"]["year-in-range"]($form["year"]);
  
  return [$clean, $errors];
}


// Функции валидации и вспомогательные функции 
// !! Можно менять в соответсвии с вашей идеей архитектуры

// require
// clearExtraSpaces
// integer
// bool


/**
 * Генерирует функцию, котрая проверяет, что число находится в промежутке
 * @param int $min нижняя граница
 * @param int $max верхняя граница
 * @return callable функция-валидатор 
 */
function generateRangeValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
    $error;
    if ($min > $value || $max < $value){
        $error = 'Недопустимый год';
    return $error;
    }
  };
}


/**
 * Генерирует функцию, котрая проверяет, что длина строки находится в промежутке
 * @param int $min нижняя граница
 * @param int $max верхняя граница
 * @return callable функция-валидатор 
 */
function generateLengthValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
    $error;
    var_dump($value);
    if ($min < strlen($value) || $max > strlen($value)){
        $error = 'Недопустимая длинна';
    } else {
        $error = $value;
    }
    return $error;
  };
}

/**
 * Генерирует функцию, котрая проверяет, что значение соответсвует регулярному выражению
 * @param int $regexp регулярное выражение для проверки
 * @return callable функция-валидатор 
 */
function generateRegExpValidator($regexp) {
  return function($value) use ($regexp) {
    return [$clean, $error];
  };
}


// Конец validation.php




