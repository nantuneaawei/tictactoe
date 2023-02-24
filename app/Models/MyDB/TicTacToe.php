<?php

namespace App\Models\MyDB;

use Illuminate\Database\Eloquent\Model;

class TicTacToe extends Model
{
    //指定連接的DB名稱
    protected $connection = 'MyDB';
    //指定Table名稱
    protected $table = 'tic_tac_toe';
    //主鍵名稱
    protected $primaryKey = 'round_id';
    //對應現有DB設定
    public $timestamps = false;
}
