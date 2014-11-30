<?php
session_start();
session_destroy();
$url = "";

$model = new model();
$model->deliver_response(0, "thoát game", $url);