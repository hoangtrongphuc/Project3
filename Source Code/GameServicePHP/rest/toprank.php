<?php
$model = new model();
$data = $model->topRank();
$model->deliver_response(0, "thành công", $data);