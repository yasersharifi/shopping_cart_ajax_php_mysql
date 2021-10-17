<?php
include_once "./../../config.php";
include_once "./../../classes/Province.php";
include_once "./../../classes/City.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $provinceObject = new Province();
    $cityObject = new City();

    $response = [];

    if (isset($_POST["action"]) && $_POST["action"] == "findCity") {
        $provinceId = $_POST["province"];
        $hasProvince = $provinceObject->find(["id" => $provinceId]);

        if (! empty($hasProvince)) {
            $cities = $cityObject->getByProvince("*", $provinceId);
            $option = "";
            foreach ($cities as $item) {
                $option .= "<option value='" . $item->id . "'>";
                $option .= $item->name;
                $option .= "</option>";
            }

            $response = array(
                "status" => "ok",
                "cities" => $option
            );
        } else {
            $response = array(
                "status" => "error",
            );

        }

    }
    echo json_encode(array($response));
}
