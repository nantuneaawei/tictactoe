<?php

namespace App\Services\Lession;

use App\Repositories\MyDB\TicTacToe as TicTacToeRepositories;

class Game
{
    private $oTicTacToeRepositories;

    public function __construct(TicTacToeRepositories $_oTicTacToeRepositories)
    {
        $this->oTicTacToeRepositories = $_oTicTacToeRepositories;
    }

    /**
     * startRound 初始盤面
     * 0 空格
     * 1 O
     * 2 X
     * @return array 初始盤面
     */
    public function startRound()
    {
        $aBoard = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];
        $iRoundID = $this->oTicTacToeRepositories->insertBoard(json_encode($aBoard));
        return ['Board' => $aBoard, 'RoundID' => $iRoundID];
    }

    /**
     * handleLocation 處理位置
     *
     * @param  int $_iX X軸
     * @param  int $_iY Y軸
     * @param  int $_iRoundID 局號
     * @return array    新盤面
     */
    public function handleLocation($_iX, $_iY, $_iRoundID)
    {
        $aBoardData = $this->oTicTacToeRepositories->getBoard($_iRoundID);
        $aBoard = json_decode($aBoardData['board'], true);
        $bStatus = $this->checkBoard($aBoard, $_iX, $_iY);
        if (!$bStatus) {
            return ['event' => $bStatus, 'board' => $aBoard];
        }
        $aBoard[$_iX][$_iY] = $this->isOX($aBoard);
        return ['event' => $bStatus, 'board' => $aBoard];
    }

    /**
     * isOX 判斷是要O還是X
     *
     * @param  array $_aBoard 盤面
     * @return int            1(O)/2(X)
     */
    private function isOX($_aBoard)
    {
        $iO = 0;
        $iX = 0;
        foreach ($_aBoard as $aXValue) {
            foreach ($aXValue as $iOX) {
                if ($iOX === 1) {
                    $iO++;
                }
                if ($iOX === 2) {
                    $iX++;
                }
            }
        }
        if ($iX === 0 && $iO === 0) {
            return 1;
        }

        if (($iO-$iX) == 1) {
            return 2;
        }
        return 1;
    }

    /**
     * checkBoard 檢查盤面是否已下過
     *
     * @param  array $_aBoard  盤面
     * @param  int   $_iX      X軸
     * @param  int   $_iY      Y軸
     * @return bool            true(可下) / false(不可下)
     */
    private function checkBoard($_aBoard, $_iX, $_iY)
    {
        if ($_aBoard[$_iX][$_iY] !== 0) {
            return false;
        }
        return true;
    }

    /**
     * checkWhoWinLose 檢查輸贏
     *
     * @param  array $_aBoard  盤面
     * @return array           輸贏
     */

    public function checkWhoWinLose($_aBoard)
    {
        $iWin   = 0;
        $iCount = 0;
        foreach ($_aBoard as $aXValue){
            foreach ($aXValue as $iStatus){
                if ($iStatus === 0){
                    $iCount++;
                }
            }
        }
        //判斷橫向
        foreach ($_aBoard as $aXValue){
            if($aXValue[0] !== 0 && ($aXValue[1] == $aXValue[0]) && ($aXValue[2] == $aXValue[0]))
            {
                $iWin = $aXValue[0];
                break;
            }
        }

        //判斷直向
        foreach ($_aBoard[0] as $iYAxis => $iStatus){
            if($iStatus !== 0 && ($_aBoard[1][$iYAxis] == $iStatus) && ($_aBoard[2][$iYAxis] == $iStatus))
            {
                $iWin = $iStatus;
                break;
            }
        }

        //判斷斜線
        if($_aBoard[0][0] !== 0 && ($_aBoard[0][0] == $_aBoard[1][1]) && ($_aBoard[0][0] == $_aBoard[2][2]))
        {
            $iWin = $_aBoard[0][0];
        }
        if($_aBoard[0][2] !== 0 && ($_aBoard[0][2] == $_aBoard[1][1]) && ($_aBoard[0][2] == $_aBoard[2][0]))
        {
            $iWin = $_aBoard[0][2];
        }
        if($iWin === 0 && $iCount !== 0){
            $iWin = 3;
        }
        switch ($iWin){
            case 0:
                return ['Status' => 'Tie', 'Player' => 'OX'];
                break;
            case 1:
                return ['Status' => 'Win', 'Player' => 'O'];
                break;
            case 2:
                return ['Status' => 'Win', 'Player' => 'X'];
                break;
            default:
                return ['Status' => '-', 'Player' => '-'];
                break;
        }
    }

}