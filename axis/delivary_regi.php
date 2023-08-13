<?php
require("../core/config.php");
require("login_check.php");
require("function.php");

foreach ($_POST as $key => $val) {
    $$key = $val;
}

$array = ["delivary_name" => $delivary_name, "flag_include" => $flag_include, "delivary_group" => $delivary_group];


if (!$code) {
    db_insert($table, $array, $dbh);

    $sql = "select*from $table order by code DESC limit 1";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $row_code = $row['code'];

    $sql = "alter table area_data add delivary_{$row_code} int(7) not null";
    connect()->query($sql);

    for ($i = 0; $i < sizeof($delivary_fee); $i++) {
        $area_code = zerop($i + 1, 3);
        $fee = ["delivary_$row_code" => $delivary_fee[$i]];
        db_update("area_data", $fee, "code=$area_code");
    }

    header("location:./delivary_list.html");
    exit;
} else {
    db_update($table, $array, "code=$code");

    for ($i = 0; $i < sizeof($delivary_fee); $i++) {
        $area_code = zerop($i + 1, 3);
        $fee = ["delivary_$code" => $delivary_fee[$i]];
        db_update("area_data", $fee, "code=$area_code");
    }

    header("location:./delivary_form.php?code=$code");
    exit;
}
