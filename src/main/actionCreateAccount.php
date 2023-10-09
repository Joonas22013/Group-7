<?php
session_start();

if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['scope']) && isset($_POST['semester']) ) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;

    $name = $_POST['name'];
    $_SESSION['name'] = $name;

    $scope = $_POST['scope'];
    $_SESSION['scope'] = $scope;

    $semester = $_POST['semester'];
    $_SESSION['semester'] = $semester;


}
?>


<?php include('../header.php'); include '../db.php'; ?>
<?php

function generateRandomPassword($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomPassword;
}



    $name = $_SESSION['name'];
    $password = generateRandomPassword();
    $email = $_SESSION['email'];
    $scope = $_SESSION['scope'];
    $semester = $_SESSION['semester'];
    $subject = "Your New Password";
    $message = "Hello " . $name . ",\n\nYour generated password is: " . $password . "\n\nRegards,\nGroup7 - Design Factory";
    $headers = "From: group7designfactory@gmail.com"; 

    $stmt = $connection->prepare("INSERT INTO Users (Email, Password, Name, Scope, Semester) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $password, $name, $scope, $semester);


    if (!$stmt->execute()) {
        if (strpos($stmt->error, 'Duplicate entry') !== false && strpos($stmt->error, 'for key \'Users.PRIMARY\'') !== false) {
            echo "You have an account with this email.";
        } else {
            echo "Error inserting into Users: " . $stmt->error;
        }
    }
    
    ?>
    <div class="row">
        <div class="column">
            <div class="scope">
                <h4>Email here</h4>
                <form action="../main/form.php" method="post">
                    <input type="email" name="email1" placeholder="Email" required><br>
                    <input type="password" name="pass1" placeholder="Password" required><br>
                    <input type="submit" value="Login" name="Login" class="btn btn-primary">
                </form>
                <?php
                // Send the email
                if (mail($email, $subject, $message, $headers)) {
                    echo "<p> Password sent to email: $email </p>";
                } else {
                    echo "<p> Failed to send email: $email </p>";
                }
                ?>
                <p>
            </div>
        </div>
    </div>
    <?php


?>

<?php include('../footer.php'); ?>
