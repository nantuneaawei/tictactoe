<?php

namespace App\Http\Controllers\Lession;

use App\Http\Controllers\Controller;
use App\Repositories\MyDB\TicTacToe as TicTacToeRepositories;
use App\Services\Lession\Game as GameServices;
use Illuminate\Http\Request;

class Game extends Controller
{
    private $oGameServices;
    private $oTicTacToeRepositories;

    public function __construct(GameServices $_oGameServices,TicTacToeRepositories $_oTicTacToeRepositories)
    {
        $this->oGameServices     = $_oGameServices;
        $this->oTicTacToeRepositories = $_oTicTacToeRepositories;
    }

    /**
     * index 首頁
     *
     * @return void
     */
    public function index()
    {
        return view('lession.game');
    }

    /**
     * insert 新局盤面
     *
     * @return void
     */
    public function insert()
    {
        $aBoard = $this->oGameServices->startRound();
        return response()->json(['event' => true, 'data' => $aBoard]);
    }

    /**
     * update 更新盤面
     *
     * @return void
     */
    public function update(Request $_oRequest)
    {
        $iX = $_oRequest->input('x');
        $iY = $_oRequest->input('y');
        $iRoundID = $_oRequest->input('round_id');
        $aBoard = $this->oGameServices->handleLocation($iX, $iY, $iRoundID);
        $aStatus = $this->oGameServices->checkWhoWinLose($aBoard['board']);
        $this->oTicTacToeRepositories->updateBoard($iRoundID, json_encode($aBoard['board']));
        return response()->json(['event' => true, 'data' => $aBoard, 'status' => $aStatus]);
    }
}
