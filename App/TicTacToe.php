<?php

namespace App;


class TicTacToe
{
    protected $menu = [
        '1' => '1. Начать игру',
        '2' => '2. Сделать ход',
        '3' => '3. Завершить игру',
        '4' => '4. Отрисовать текущее состояние',
        '5' => '5. About'
    ];

    protected $nullStatus = [
        '1' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
        '2' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
        '3' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
    ];

    public function run()
    {
        $this->getMenu();

        echo 'Выберите пункт меню: ';

        $input = fgets(STDIN, 255);

        switch ($input) {
            case 1: return $this->newGame();
                break;
            case 2: return $this->move();
                break;
            case 3: return $this->endGame();
                break;
            case 4: return $this->getStatus();
                break;
            case 5: echo 'В разработке';
                break;
            default: echo 'Выберите корректный пункт меню: ';

            return $this->run();
        }
    }

    public function getMenu()
    {
        echo PHP_EOL;
        foreach ($this->menu as $item) {
            echo $item . PHP_EOL;
        }
    }

    public function endGame()
    {
        file_put_contents('status.json', '');
        exit();
    }

    public function newGame()
    {
        file_put_contents('status.json', json_encode($this->nullStatus));

        echo 'Вы начали новую игру' . PHP_EOL;

        return $this->run();
    }

    public function move()
    {
        $status = json_decode(file_get_contents('status.json'), true);

        $this->statusValidate($status);

        echo 'Строка: ';
        $row = trim(fgets(STDIN, 255));

        echo 'Столбец: ';
        $col = trim(fgets(STDIN, 255));

        if ($row < 1 || $row > 4 || $col < 1 || $col > 4) {
            echo 'Значения должно быть в интервале от 1 до 3' . PHP_EOL;
            return $this->run();
        }

        if ($status[$row][$col] !== ' . ') {
            echo 'Поле занято!' . PHP_EOL;
            return $this->run();
        }

        echo 'X или O: ';
        $xo = trim(fgets(STDIN, 255));
        
        switch ($xo) {
            case 'X': 
                $status[$row][$col] = ' X ';
                $this->statusRecord($status);
                break;

            case 'O': 
                $status[$row][$col] = ' O ';
                $this->statusRecord($status);
                break;

            default: echo 'Некорректный ввод';
        }

        return $this->run();
    }

    public function getStatus()
    {
        $status = json_decode(file_get_contents('status.json'), true);

        $this->statusValidate($status);

        array_map(function ($string) {
            echo '|' . implode('|', $string) . '|' . PHP_EOL;
        }, $status);

        return $this->run();
    }

    public function statusValidate($status)
    {
            if(empty($status)) {
            echo 'Начните игру!' . PHP_EOL;
            return $this->run();
        }
    }

    public function statusRecord($status)
    {
        file_put_contents('status.json', json_encode($status, JSON_PRETTY_PRINT));
    }
}