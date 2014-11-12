<?php
$model = new model();
$data = $model->topRick();
$model->deliver_response(0, "thành công", $data);