<?php
$initials=parse_ini_file(".ht.settings.ini");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$json=isset($_POST["kayttaja"]) ? $_POST["kayttaja"] : "";

if (!($kayttaja=tarkistaJson($json))){
    print "Fields cannot be empty";
    exit;
}
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

// Otetaan yhteys tietokantaan
try{
    $yhteys=mysqli_connect($initials["databaseserver"],$initials ["username"],$initials ["password"],$initials ["database"]);

}
// Mikäli yhteys ei onnistu, tulostetaan virheilmoitus
catch(Exception $e){
    print "Yhteysvirhe";
    exit;
}
// Luodaan PHPMailer objekti
$mail = new PHPMailer(true);
// Syötetään annetut tiedot tietokantaan
$sql="insert into kayttajat (etunimi,sukunimi,sahkoposti,salasana) values(?,?,?,SHA2(?, 256))" ;
try{
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($yhteys, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'ssss', $kayttaja->etunimi, $kayttaja->sukunimi, $kayttaja->sahkoposti, $kayttaja->salasana);
    //Execute sql statement
    mysqli_stmt_execute($stmt);
    //Close database connection
    mysqli_close($yhteys);
    // print $json;

    //SMTP-server settings
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $initials["host"];
    $mail->Port = $initials["port"];
    $mail->Username = $initials["username2"];
    $mail->Password = $initials["password2"];
    $mail->SMTPSecure = $initials["sec"];

    //Tarkistetaan, onko sähköpostiosoite kelvollinen
  if (!filter_var($kayttaja->sahkoposti, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email address.';
    exit;
  }

    //Osoitteet
    $mail->setFrom($initials["username2"], 'Paivalehti'); // Lähettäjän osoite
    $mail->addAddress($kayttaja->sahkoposti);  // Vastaanottajan osoite
    
    //Sisältö
    $mail->isHTML(true);  //Asetetaan viestin formaatti HTML:ksi
    $mail->Subject = 'Thank you for your registration!';
    $mail->Body = 'Hei,<br>Kiitos rekisteröitymisestä Päivälehden käyttäjäksi. Olemme iloisia saadessamme toivottaa sinut tervetulleeksi osaksi yhteisöämme! <br> Mikäli et itse rekisteröitynyt käyttäjäksi, ota yhteyttä asiakaspalveluumme sähköpostitse.<br>paivalehti1@gmail.com <br><br>
                            Ystävällisin terveisin, <br> Päivälehti';   

    //Print a message if email sent 
    $mail->send();    
    echo 'Email sent.';

}
//Virheilmoitus mikäli viestin lähetys epäonnistui
catch(Exception $e){
    print "Error sending the message!";
}
?>

<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $kayttaja=json_decode($json, false);
    if (empty($kayttaja->etunimi) || empty($kayttaja->sukunimi) || empty ($kayttaja->sahkoposti) || empty ($kayttaja->salasana)){
        return false;
    }
    return $kayttaja;
}

?>