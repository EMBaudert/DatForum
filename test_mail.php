<?PHP

$rcv = "abi2015-merlin@gmx.de";
$subject = "Kontaktanfrage!";
$from = "it16145@lehre.dhbw-stuttgart.de";
$name = "M.";
$surname = "Baudert";
$msg = "Hallo!";
$content = "
Eine automatisch generierte Email von $name $surname ($from).
Message war:
$msg
";
mail($rcv, $subject, $content, "from: info@domain.de");

?>