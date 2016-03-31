<?php
require 'vendor/autoload.php';


$csv_reader = new \helpers\CSVReader("logins.csv");
$app = new \core\ApplicationRoot();
$db = $app->getDatabase();

$streets= array(
    "Kaiserstr.",
    "Wilhelm-Heinrich-Str.",
    "Dr-Koch-Str.",
    "Am Hang",
    "Saarbrücker-Str.",
    "Ulanenstr.",
    "Finkenweg",
    "Göthestr.",
    "Schillerstr."
);

$locations = array(
    array("66121", "Saarbrücken"),
    array("50679", "Köln"),
    array("50670", "Köln"),
    array("40229", "Düsseldorf"),
    array("67661", "Kaiserslautern")
);


$hashedPassword = \database\UserDAO::hashPassword("password");

foreach ($csv_reader as $value) {
    //Spaltennamen überspringen
    if($csv_reader->key() == 0) continue;



    $street = $streets[array_rand($streets)];
    $hausnr = rand(1,100);
    $location = $locations[array_rand($locations)];




    $id = $db->insert("users", array(
        "username" => $value[2],
        "password_hash" => $hashedPassword,//PW: test
        "vorname" => $value[0],
        "nachname" => $value[1],
        "strasse" => $street,
        "hausnr" => $hausnr,
        "plz" => $location[0],
        "ort" => $location[1],
        "telefonDurchwahl" => rand(1112, 9999),
        "telefonPrivat" => "+49".rand(100000000,999999999),
        "telefonMobil" => "+49157".rand(1000000,9999999)
    ));

    $db->insert("email", array("user_id" => $id, "mail_address" => $value[2]."@evilcorp.com"));
}
