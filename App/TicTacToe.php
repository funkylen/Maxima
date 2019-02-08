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
            case 5: return $this->run();
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
        exit();
    }

    public function newGame()
    {
        Status::reset();

        echo PHP_EOL . 'Вы начали новую игру' . PHP_EOL;

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
                Status::record($status);
                break;

            case 'O': 
                $status[$row][$col] = ' O ';
                Status::record($status);
                break;

            default: echo 'Некорректный ввод';
        }

        $this->winCheck();

        return $this->run();
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
