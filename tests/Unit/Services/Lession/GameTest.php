<?php

namespace App\Services\Lession;

use App\Repositories\MyDB\TicTacToe as TicTacToeRepositories;
use App\Services\Lession\Game;
use Mockery;
use PHPUnit\Framework\TestCase;


class GameTest extends TestCase
{
    private $oTicTacToeRepositories;

    public function setUp(): void
    {
        $this->oTicTacToeRepositories = Mockery::mock(TicTacToeRepositories::class);
    }

    /**
     * testStartRound 初始盤面
     *
     * @return void
     */
    public function testStartRound()
    {
        $aBoard = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0],
        ];
        $iRoundID = 1;

        $this->oTicTacToeRepositories->shouldReceive('insertBoard')
            ->once()
            ->andReturn($iRoundID);
        $aExpected = ['Board' => $aBoard, 'RoundID' => $iRoundID];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->startRound();
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testRoundOneCase1 第一局O先下(1,1)
     *
     * @return void
     */
    public function testRoundOneCase1()
    {
        $iRoundID = 1;
        $aBoard   = [
            'round_id' => 1,
            'board'    => '[[0,0,0],[0,0,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [0, 0, 0],
                [0, 1, 0],
                [0, 0, 0],
            ],

        ];
        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(1, 1, $iRoundID);
        $this->assertEquals($aExpected, $aActual);

    }

    /**
     * testRoundOneCase2 第一局O先下(2,2)
     *
     * @return void
     */
    public function testRoundOneCase2()
    {
        $iRoundID = 1;
        $aBoard   = [
            'round_id' => 1,
            'board'    => '[[0,0,0],[0,0,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
        ->once()
        ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 1],
            ],

        ];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(2, 2, $iRoundID);
        $this->assertEquals($aExpected, $aActual);

    }

    /**
     * testRoundTwoCase1 第二局X先下
     * 座標0, 0
     *
     * @return void
     */
    public function testRoundTwoCase1()
    {
        $iRoundID = 2;
        $aBoard   = [
            'round_id' => 2,
            'board'    => '[[0,0,0],[0,1,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [2, 0, 0],
                [0, 1, 0],
                [0, 0, 0],
            ],
        ];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(0, 0, $iRoundID);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testRoundTwoCase2 第二局X先下
     * 座標0, 1
     *
     * @return void
     */
    public function testRoundTwoCase2()
    {
        $iRoundID = 2;
        $aBoard   = [
            'round_id' => 2,
            'board'    => '[[0,0,0],[0,1,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [0, 2, 0],
                [0, 1, 0],
                [0, 0, 0],
            ],
        ];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(0, 1, $iRoundID);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testRoundTwoCase3 第二局X先下，該座標已下過
     * 座標1, 1
     *
     * @return void
     */
    public function testRoundTwoCase3()
    {
        $iRoundID = 2;
        $aBoard   = [
            'round_id' => 2,
            'board'    => '[[0,0,0],[0,1,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => false,
            'board' => [
                [0, 0, 0],
                [0, 1, 0],
                [0, 0, 0],
            ],

        ];
        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(1, 1, $iRoundID);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testRoundThreeCase1 第三局O下
     * 座標0, 1
     *
     * @return void
     */
    public function testRoundThreeCase1()
    {
        $iRoundID = 2;
        $aBoard   = [
            'round_id' => 2,
            'board'    => '[[2,0,0],[0,1,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [2, 1, 0],
                [0, 1, 0],
                [0, 0, 0],
            ],
        ];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(0, 1, $iRoundID);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testRoundFourCase1 第四局X下
     * 座標2, 1
     *
     * @return void
     */
    public function testRoundFourCase1()
    {
        $iRoundID = 2;
        $aBoard   = [
            'round_id' => 2,
            'board'    => '[[2,1,0],[0,1,0],[0,0,0]]',
        ];
        $this->oTicTacToeRepositories->shouldReceive('getBoard')
            ->once()
            ->andReturn($aBoard);

        $aExpected = [
            'event' => true,
            'board' => [
                [2, 1, 0],
                [0, 1, 0],
                [0, 2, 0],
            ],
        ];

        $oServices = new Game($this->oTicTacToeRepositories);
        $aActual   = $oServices->handleLocation(2, 1, $iRoundID);
        $this->assertEquals($aExpected, $aActual);
    }

    /**
     * testcheckWinCase1 O贏
     *
     *
     * @return void
     */
    public function testcheckWinCase1()
    {
        $aBoard = [
            [2, 1, 2],
            [0, 1, 0],
            [0, 1, 0],
        ];

        $sExpected = ['Status' => 'Win', 'Player' => 'O'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

    /**
     * testcheckWinCase2 X贏
     *
     *
     * @return void
     */
    public function testcheckWinCase2()
    {
        $aBoard = [
            [2, 2, 2],
            [0, 1, 0],
            [0, 1, 0],
        ];

        $sExpected = ['Status' => 'Win', 'Player' => 'X'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

    /**
     * testcheckWinCase3 X贏
     *
     *
     * @return void
     */
    public function testcheckWinCase3()
    {
        $aBoard = [
            [2, 1, 2],
            [0, 2, 0],
            [2, 1, 1],
        ];

        $sExpected = ['Status' => 'Win', 'Player' => 'X'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

    /**
     * testcheckWinCase4 和局
     *
     *
     * @return void
     */
    public function testcheckWinCase4()
    {
        $aBoard = [
            [2, 1, 2],
            [1, 2, 2],
            [1, 2, 1],
        ];

        $sExpected = ['Status' => 'Tie', 'Player' => 'OX'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

    /**
     * testcheckWinCaseㄓ5 未結束
     *
     *
     * @return void
     */
    public function testcheckWinCase5()
    {
        $aBoard = [
            [2, 1, 1],
            [1, 2, 2],
            [1, 2, 0],
        ];

        $sExpected = ['Status' => '-', 'Player' => '-'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

    /**
     * testcheckWinCase6 O win
     *
     *
     * @return void
     */
    public function testcheckWinCase6()
    {
        $aBoard = [
            [1, 0, 2],
            [0, 1, 2],
            [0, 0, 1],
        ];

        $sExpected = ['Status' => 'Win', 'Player' => 'O'];

        $oServices = new Game($this->oTicTacToeRepositories);
        $sActual   = $oServices->checkWhoWinLose($aBoard);
        $this->assertEquals($sExpected, $sActual);
    }

}

