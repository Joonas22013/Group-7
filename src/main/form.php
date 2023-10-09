<?php
session_start();

if (isset($_POST['email1']) && isset($_POST['pass1'])) {
    $email1 = $_POST['email1'];
    $_SESSION['email1'] = $email1;

    $pass1 = $_POST['pass1'];
    $_SESSION['pass1'] = $pass1;
}
?>



<?php include('../header.php');
include '../db.php'; ?>
<?php

if ($_SESSION['email1'] === $_SESSION['email']) {

    // Retrieve user information
    $email = mysqli_real_escape_string($connection, $_SESSION['email']);
    $password = $_SESSION['pass1']; // Since you're not inserting the password into SQL, you might not need to escape it.

    $sql = "SELECT Name, Password FROM Users WHERE Email = '$email'";
    $result = $connection->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["Name"];
            $stored_password = $row["Password"]; // assuming you have plain-text passwords in your DB (which is not recommended)

            // Verify the password
            if ($password == $stored_password) {
                echo "Hi " . $name . "<br>";

                ?>



                <form action="formAction.php" method="post">
                    <h1>Questions:</h1>

                    <h2>Learning Process and Environment</h2>
                    <?php
                    $questions_Cat1 = array(
                        1 => "I often have trouble making sense of the things I have to learn.",
                        2 => "Much of what I’ve learned seems no more than unrelated bits and pieces.",
                        3 => "Assessment in the modules seem to focus on competences which are based on the learning goals."
                    );

                    foreach ($questions_Cat1 as $i => $questionText1) {
                        echo "<p><strong>Question $i:</strong> $questionText1</p>";
                        echo "<p>";
                        for ($j = 1; $j <= 5; $j++) {
                            echo "<input type='radio' name='category1_q$i' value='$j' required>$j";
                        }
                        echo "</p>";
                    }
                    ?>

                    <h2>Competence development </h2>
                    <?php
                    $questions_Cat2 = array(
                        1 => "I have learned to apply theoretical knowledge to practice. ",
                        2 => "I have learned to analyze and categorize information.",
                        3 => "Studying at the university of applied sciences has developed my skills in acting as a group member. "
                    );

                    foreach ($questions_Cat2 as $i => $questionText2) {
                        echo "<p><strong>Question $i:</strong> $questionText2</p>";
                        echo "<p>";
                        for ($j = 1; $j <= 5; $j++) {
                            echo "<input type='radio' name='category2_q$i' value='$j' required>$j";
                        }
                        echo "</p>";
                    }
                    ?>

                    <!-- Repeat the above code for Category 3 and Category 4 -->
                    <h2>Practicums/work placements </h2>
                    <?php
                    $questions_Cat3 = array(
                        1 => "I have received support from my workplace supervisor in my work placements. ",
                        2 => "The cooperation between the university of applied sciences and the place of the work placement has supported my learning during the work placement period. ",
                        3 => "I have received support from my supervising teacher in my work placements.  "
                    );

                    foreach ($questions_Cat3 as $i => $questionText3) {
                        echo "<p><strong>Question $i:</strong> $questionText3</p>";
                        echo "<p>";
                        for ($j = 1; $j <= 5; $j++) {
                            echo "<input type='radio' name='category3_q$i' value='$j' required>$j";
                        }
                        echo "</p>";
                    }
                    ?>

                    <h2>Wellbeing </h2>
                    <?php
                    $questions_Cat4 = array(
                        1 => "I feel a lack of study motivation and often think of giving up. ",
                        2 => "I'm continually wondering whether my studies have any meaning. ",
                        3 => "The pressure of my studies causes me problems in my close relationships with others."
                    );

                    foreach ($questions_Cat4 as $i => $questionText4) {
                        echo "<p><strong>Question $i:</strong> $questionText4</p>";
                        echo "<p>";
                        for ($j = 1; $j <= 5; $j++) {
                            echo "<input type='radio' name='category4_q$i' value='$j' required>$j";
                        }
                        echo "</p>";
                    }
                    ?>


                    <input type="submit" name="submit" value="Calculate">
                </form>








                <?php
            } else {
                echo "Wrong password";
            }
        } else {
            echo "The user was not found.";
        }
    } else {
        echo "Error executing query.";
    }
} else {
    echo "The email is incorrect.";
}
?>
<?php include('../footer.php'); ?>