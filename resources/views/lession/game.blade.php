<!DOCTYPE html>
<html lang="en">
<head>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>圈圈叉叉</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">圈圈叉叉</a>
  </div>
</nav>
<div class="container">
<div class="alert alert-primary" role="alert">
    <span>局號：<span class="round"></span></span>
    <span>玩家：<span class="player"></span>-<span class="status"></span></span>
    <button type="button" class="btn btn-primary new_round">新局</button>
</div>
<div class="box">
<div class="wrapper">
  <div id="nine_0_0" class="nine"></div>
  <div id="nine_0_1" class="nine"></div>
  <div id="nine_0_2" class="nine"></div>
  <div id="nine_1_0" class="nine"></div>
  <div id="nine_1_1" class="nine"></div>
  <div id="nine_1_2" class="nine"></div>
  <div id="nine_2_0" class="nine"></div>
  <div id="nine_2_1" class="nine"></div>
  <div id="nine_2_2" class="nine"></div>
</div>
</div>
</div>
</body>
</html>
<script src="/js/app.js"></script>
