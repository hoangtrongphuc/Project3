<?php
$model = new model();

$data = array();
$data = $model->topRick();

$response['code'] = 0;
$response['status'] = $model::$api_response_code[ $response['code'] ]['HTTP Response'];
$response['data'] = $data;
$model->deliver_response($response);