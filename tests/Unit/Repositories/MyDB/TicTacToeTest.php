<?php

namespace Tests\Unit\Repositories\MyDB;

use App\Models\MyDB\TicTacToe as TicTacToeModel;
use App\Repositories\MyDB\TicTacToe as TicTacToeRepositories;
use Mockery;
use PHPUnit\Framework\TestCase;

class TicTacToeTest extends TestCase
{
    /**
     * testInsertInitBoard 寫入初始盤面，回傳局號
     *
     * @return int 局號
     */
    public function testInsertInitBoard()
    {
        $sBoard          = '[[0,0,0],[0,0,0],[0,0,0]]';
        $iRoundId        = 1;
        $oTicTacToeModel = Mockery::mock(TicTacToeModel::class);
        $oTicTacToeModel->shouldReceive('insertGetId')
            ->andReturn($iRoundId);

        $aExpected  = 1;
        $oTicTacToe = new TicTacToeRepositories($oTicTacToeModel);
        $aActual    = $oTicTacToe->insertBoard($sBoard);
        $this->assertEquals($aExpected, $aActual);
    }


    /**
     * testGetBoard 取得該局盤面
     *
     * @return void
     */
    public function testGetBoard()
    {
        $iRoundId = 1;
        $aBoard   = [
            'round_id' => 1,
            'board'    => '[[0,0,1],[0,0,0],[0,0,0]]'
        ];
        $oTicTacToeModel = Mockery::mock(TicTacToeModel::class);
        $oTicTacToeModel->shouldReceive('where')
            ->andReturn(Mockery::self())
            ->shouldReceive('get')
            ->andReturn(Mockery::self())
            ->shouldReceive('first')
            ->andReturn(Mockery::self())
            ->shouldReceive('toArray')
            ->andReturn($aBoard);

        $aExpected = [
            'round_id' => 1,
            'board'    => '[[0,0,1],[0,0,0],[0,0,0]]',
        ];
        $oTicTacToe = new TicTacToeRepositories($oTicTacToeModel);
        $aActual    = $oTicTacToe->getBoard($iRoundId);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testUpdateBoard 更新該局盤面
     *
     * @return void
     */
    public function testUpdateBoard()
    {
        $iRoundId        = 1;
        $sBoard          = '[[0,0,0],[0,0,0],[0,0,0]]';
        $bResult         = true;
        $oTicTacToeModel = Mockery::mock(TicTacToeModel::class);
        $oTicTacToeModel->shouldReceive('where')
            ->andReturn(Mockery::self())
            ->shouldReceive('update')
            ->andReturn($bResult);

        $aExpected  = true;
        $oTicTacToe = new TicTacToeRepositories($oTicTacToeModel);
        $aActual    = $oTicTacToe->updateBoard($iRoundId, $sBoard);
        $this->assertEquals($aExpected, $aActual);
    }


}
