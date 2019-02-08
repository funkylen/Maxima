<?php

namespace App;

use App\Status;

class TicTacToe
{
    protected $menu = [
        '1' => '1. Новая игра',
        '2' => '2. Сделать ход',
        '3' => '3. Завершить игру',
        '4' => '4. Отрисовать текущее состояние',
        '5' => '5. About'
    ];

    protected $inputs = [ 'X', 'O' ];

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
            case 4: return $this->display();
                break;
            case 5: return $this->about();
                break;
            default: 
                echo "\033[0;31m" . 'Выберите корректный пункт меню!' . "\033[0m" . PHP_EOL;

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

    public function newGame()
    {
        Status::reset();

        echo PHP_EOL . "\033[0;32m" . 'Вы начали новую игру' . "\033[0m" . PHP_EOL;

        return $this->run();
    }

    public function move()
    {
        $status = Status::getStatus();

        if(Status::isEmpty($status)) {
            Status::reset();
        }

        echo PHP_EOL;

        echo 'Строка: ';
        $row = trim(fgets(STDIN, 255));

        echo 'Столбец: ';
        $col = trim(fgets(STDIN, 255));

        if ($row < 1 || $row > 3 || $col < 1 || $col > 3) {
            echo "\033[0;31m" . 'Значения должно быть в интервале от 1 до 3' . "\033[0m" . PHP_EOL;
            return $this->run();
        }

        if ($status[$row][$col] !== ' . ') {
            echo "\033[0;31m" . 'Поле занято!' . "\033[0m" . PHP_EOL;
            return $this->run();
        }

        echo 'Крестик(X) или Нолик(O): ';
        $xo = trim(fgets(STDIN, 255));

        switch ($xo) {
            case in_array($xo, $this->inputs): 
                $status[$row][$col] = " {$xo} ";
                Status::record($status);
                break;

            default: echo "\033[0;31m" . 'Неккоректный ввод' . "\033[0m" . PHP_EOL;
        }

        $this->winCheck();

        return $this->run();
    }

    public function endGame()
    {
        exit();
    }

    public function display()
    {
        $status = Status::getStatus();

        echo PHP_EOL;

        if(Status::isEmpty($status)) {
            Status::reset();
        }

        array_map(function ($string) {
            echo '|' . implode('|', $string) . '|' . PHP_EOL;
        }, $status);

        return $this->run();
    }

    public function about()
    {
        echo file_get_contents('App/image.txt');
        echo PHP_EOL . "Крестики-Нолики V0.1";
        echo PHP_EOL . "Разработчик: Владлен Гилязетдинов";
        echo PHP_EOL . "Email: funkylen@gmail.com" . PHP_EOL;

        return $this->run();
    }

    public function winCheck()
    {
        foreach (Status::getWinList() as $sign => $combinations){
            $msg = $sign === 'O' ? 'Нолики победили!' : 'Крестики победили!';
            foreach ($combinations as $combo)
            {
                if (Status::getStatus() === $combo) {
                    echo PHP_EOL;
                    echo "\033[0;32m" . $msg . "\033[0m";
                    $this->display();
                    echo PHP_EOL;
                }
            }
        }
    }
}
