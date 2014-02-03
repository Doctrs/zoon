Zoon.ru
======

Наткнулся в сети на очень интересный квест (тестовое задание)

Дано - http://zoon.ru/job.php
И все ;)

Всеголишь одна ссылка, при переходе на которую мы видим коротенький код ошибки.

Квест начался ;)
======

Если вам лениво его проходить то текст можно получить с помощью кода

```php
$quest_url = "http://zoon.ru/job.php?name=rijen&contact=false&cv=false";
$response = json_decode(file_get_contents($quest_url));
print '<pre>'.$response->description.'</pre>';
```

А для самых ленивых - вот текст задания

>Вам предстоит реализовать ИНТЕРПРЕТАТОР несложной стек-машины (это не очень сложно, и вряд ли займёт больше часа). Стек-машина по очереди исполняет переданный ей набор задач. У каждой задачи есть основной стек (на котором лежат входные данные) и выход (выходной поток).
>Выход от каждой предыдущей задачи поступает на стек следующей задаче (причём каждый выходящий элемент кладётся на низ стека; т.е. так, что в каком порядке предыдущая задача выдала данные, в том же порядке они и будут обработаны следующей задачей). Первая задача запускается с пустым стеком. Узнать выход последней задачи на предлагаемом наборе задач - и есть цель этого таска :)
>Задачи выполняются последовательно. Выполнение переходит к следующей задаче, если случится хотя бы одно из двух: а) $IP не указывает на команду, б) на момент начала исполнения команды, которая читает со стека, стек окажется пуст.
>
>В машине всего 1 регистр: $IP: указатель на текущую команду. Изначально указывает на самую первую по порядку команду.
>
>Доступны следующие команды:
>[число] добавляет число на вершину стека; $IP++
>DUP     снимает элемент с вершины стека и дважды добавляет его на вершину стека (т.е. дублирует элемент на вершине); $IP++
>DEC     снимает с вершины стека $p кладёт на вершину стека $p-1; $IP++
>IF      снимает с вершины стека $q и затем снимает с вершины $p. если $p==0, то $IP = $IP+$q+3; иначе $IP++
>DROP    снимает элемент с вершины стека; $IP++
>G       снимает элемент $p с вершины стека и перемещает указатель команд: $IP+=$p-2
>MOVE    снимает с вершины стека $q и затем $p. далее добавляет элемент $p на $q-ю позицию относительно вершины в стек; $IP++
>CHR     снимает число $p с вершины стека и добавляет символ, равный chr($p+2), на вершину стека; $IP++
>OUT     снимает элемент с вершины стека и отправляет его в выход; $IP++
>*       снимает с вершины стека $p и $q и кладет на вершину стека $p*$q; $IP++
>+       снимает с вершины стека $p и $q и кладет на вершину стека $p+$q; $IP++
>
>Примеры:
>[2, 3] -> добавляет число 2 и 3 на стек. Итог она стеке будет [2, 3]
>[123, 23, '+'] -> кладет на стек 123 и 23, и выполняет суммирование. итого на стеке будет [146]
>[1, 'G'] -> бесконечный цикл
>[77, 23, 78, (...много чисел...), 55, 'DROP', 0, 'G'] -> числа кладутся на стек, потом удаляются со стека, и задача останавливается.
>[7, 8, 1, 'MOVE'] -> кладет 2 числа на стек и меняет их местами. на стеке будет [8, 7].
>Пример с последовательным выполнением: [[3, 2, 1, 'OUT', 'OUT', 'OUT'],['OUT','+','OUT'],['OUT','OUT']]. Первая задача выдаст 1, 2, 3, вторая задача выдаст 1, 5, третяь задача выдаст 1, 5. Итоговый выход: [1, 5]
>
>В параметре task json-ответа указан набор задач. Его нужно выполнить.

Ну чтож, вот реализованное задание которое выдает ссылку (ссылку не выкладываю - кому интересно, можно скачать и запустить).
