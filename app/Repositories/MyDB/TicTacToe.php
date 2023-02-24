<?php

namespace App\Repositories\MyDB;

use App\Models\MyDB\TicTacToe as TicTacToeModel;

class TicTacToe
{
    private $oTicTacToeModel;

    public function __construct(TicTacToeModel $_oTicTacToeModel)
    {
        $this->oTicTacToeModel = $_oTicTacToeModel;
    }

    public function insertBoard($_sBoard)
    {
        return $this->oTicTacToeModel->insertGetId(['board' => $_sBoard]);
    }

    /**
     * getBoard 用局號取盤面
     *
     * @param  int    $_iRound 局號
     * @return array           盤面
     */
    public function getBoard($_iRound)
    {
        return $this->oTicTacToeModel->where(['round_id' => $_iRound])
            ->get()
            ->first()
            ->toArray();
    }

    /**
     * updateBoard 用局號取盤面
     *
     * @param  int    $_iRound 局號
     * @return array           盤面
     */
    public function updateBoard($_iRound, $_sBoard)
    {
        return $this->oTicTacToeModel->where(['round_id' => $_iRound])
            ->update(['board' => $_sBoard]);
    }

}