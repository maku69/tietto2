<?php include('config.php'); ?>

<form method="get" action="">
 Otsing <input type="text" name="otsi">
 <input type="submit" value="otsi...">
</form>
<form action="07_login.php" method="post">
    <input type="submit" value="Admin Leht" name="">
</form>
<?php
//otsi värk
if (!empty($_GET['otsi'])) {
    //kasutaja tekst vormist
    $otsi = $_GET['otsi'];
    $otsi = htmlspecialchars(trim($otsi));
    //päring
    $paring = 'SELECT * FROM info WHERE nimi LIKE "%'.$otsi.'%"';
    $valjund = mysqli_query($yhendus, $paring);
    //päringu vastuste arv
    $tulemusi = mysqli_num_rows($valjund);
    
    echo 'Otsingusõna: '.$otsi.'<br>';
    if ($tulemusi == 0) {
    echo "Leiti 0 vastust!";
    } 
    while($rida = mysqli_fetch_assoc($valjund)){
    echo "Koha nimi:" . $rida['nimi'].' <br> '. "Asukoht:" .$rida['asukoht'].' <br> '. "Hinne:" .$rida['hinne'].'<br>';
    }
    mysqli_free_result($valjund);
}

//näitan asju (10 korraga)

//uudiseid ühel lehel
$asju_lehel = 10;
//lehtede arvutamine
$uudiseid_kokku_paring = "SELECT COUNT('id') FROM info";
$lehtede_vastus = mysqli_query($yhendus, $uudiseid_kokku_paring);
$uudiseid_kokku = mysqli_fetch_array($lehtede_vastus);
$lehti_kokku = $uudiseid_kokku[0];
$lehti_kokku = ceil($lehti_kokku/$asju_lehel);
//kasutaja valik
if (isset($_GET['page'])) {
 $leht = $_GET['page'];
} else {
 $leht = 1;
}
//millest näitamist alustatakse
$start = ($leht-1)*$asju_lehel;
//andmebaasist andmed
$paring = "SELECT * FROM info LIMIT $start, $asju_lehel";
$vastus = mysqli_query($yhendus, $paring);
//väljastamine
while ($rida = mysqli_fetch_assoc($vastus)){
 //var_dump($rida);
 echo '<h3>'."Koha nimi: ".$rida['nimi'].'</h3>';
 echo '<p>'."Asukoht: ".$rida['asukoht'].'</p>';
 echo '<p>'."Hinnang: ".$rida['hinne'].'</p>';
}
//kuvame lingid
$eelmine = $leht - 1;
$jargmine = $leht + 1;
if ($leht>1) {
 echo "<a href=\"?page=$eelmine\">Eelmine</a> ";
}
if ($lehti_kokku >= 1) {
 for ($i=1; $i<=$lehti_kokku ; $i++) { 
 if ($i==$leht) {
 echo "<b><a href=\"?page=$i\">$i</a></b> ";
 } else {
 echo "<a href=\"?page=$i\">$i</a> ";
 }
 
 }
}
if ($leht<$lehti_kokku) {
echo "<a href=\"?page=$jargmine\">Järgmine</a> ";
}



 mysqli_close($yhendus); 
?>