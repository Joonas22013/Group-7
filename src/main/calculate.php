<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['pass']) ) {
    header('Location: ../index.php');
    exit();
}
?>

<?php
include '../db.php';
include '../header.php';
include '../gauge_chart.php';




    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];

    


    $sql = "SELECT Name, Scope, Semester  FROM Users WHERE Email = '$email'";
    $result = $connection->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["Name"];
            $scope = $row["Scope"]; 
            $semester = $row["Semester"];
        } else {
            echo "The user was not found.";
        }
    } else {
        echo "Error executing query.";
    }
    ?>
    <h1>
        <?php
        echo "Hi " . $name . "<br>";
        echo "your semester is  " . $semester . "<br>";
        echo "your scope is  " . $scope . "<br>";
        ?>
        <hr>
        <h3 style="text-align: center;">
            Journey of Learning: From Comprehension to Real-World Application
        </h3>
        <br>
    </h1>


    <!-- <?php


    // Calculate the averages for each category
    $category1_avg = 0;
    $category2_avg = 0;
    $category3_avg = 0;
    $category4_avg = 0;

    for ($i = 1; $i <= 3; $i++) {
        $category1_avg += $_POST["category1_q$i"];
        $category2_avg += $_POST["category2_q$i"];
        $category3_avg += $_POST["category3_q$i"];
        $category4_avg += $_POST["category4_q$i"];
    }

    $category1_avg /= 3;
    $category2_avg /= 3;
    $category3_avg /= 3;
    $category4_avg /= 3;
    $stmt = $connection->prepare("INSERT INTO Questions (Email, Cat1, Cat2, Cat3, Cat4) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddd", $email, $category1_avg, $category2_avg, $category3_avg, $category4_avg);

    if (!$stmt->execute()) {
        echo "You have already participated in the survey with this email!";
    }
    $stmt->close();


?> -->
<?php
$sql = "
SELECT 
    AVG(Cat1) as Cat1_AVG, STDDEV(Cat1) as Cat1_STDDEV,
    AVG(Cat2) as Cat2_AVG, STDDEV(Cat2) as Cat2_STDDEV,
    AVG(Cat3) as Cat3_AVG, STDDEV(Cat3) as Cat3_STDDEV,
    AVG(Cat4) as Cat4_AVG, STDDEV(Cat4) as Cat4_STDDEV
FROM Questions";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
while ($row = mysqli_fetch_assoc($result)) {
    $Cat1_AVG = $row['Cat1_AVG'];
    $Cat1_STDDEV = $row['Cat1_STDDEV'];
    
    $Cat2_AVG = $row['Cat2_AVG'];
    $Cat2_STDDEV = $row['Cat2_STDDEV'];
    
    $Cat3_AVG = $row['Cat3_AVG'];
    $Cat3_STDDEV = $row['Cat3_STDDEV'];
    
    $Cat4_AVG = $row['Cat4_AVG'];
    $Cat4_STDDEV = $row['Cat4_STDDEV'];
}
} else {
echo "The data are not available";
}


// $Feedback_good = "Keep up the good work, but consider focusing on areas where you lost points to improve your <br>overall performance.";
// $Feedback_bad = "Your performance could benefit from addressing specific weaknesses in your understanding of <br>the material, practicing more, and seeking clarification on challenging topics.";
// $recommendation = "You should consider taking the following courses to improve your performance in this area: ";
?>
<nav>
    <h1 style="color: black;">
        Learning Process and Environment
    </h1>

    <?php
    $recommendation_Cat1 = "We recommend you to be dedicated on understanding the study materials an focus on learning goals. ";
    $Green_Feedback_Cat1 = "Your outstanding performance is truly remarkable. Your dedication to understanding the material and consistently exceeding expectations is highly commendable. Keep up the exceptional work and continue to set a high standard for your peers. ";
    $Red_Feedback_Cat1 = "Your low grade in understanding course material indicates a need for increased engagement and assistance. Seek clarification, connect concepts, and align with learning goals to improve your performance. ";
    $Yellow_Feedback_Cat1 = "Your performance falls within the average range, which is commendable. To excel further, consider enhancing study habits, seeking clarification when needed, and actively engaging in class discussions. Consistent effort can yield even better results. ";
    
    $sql = "SELECT * FROM Questions WHERE Email = '$email';";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Cat1 = $row["Cat1"];

        }
    } else {
        echo "The data is not available";
    }
    ?>
    <table class='table table-bordered table-dark'>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Your point</td>
            <td>
                <?php echo $Cat1; ?>
                <?php
                echo drawGaugeChart($Cat1_AVG, $Cat1_STDDEV, $Cat1, "cat1")
                    ?>
            </td>
        <tr>
            <td><b>Feedback</b> </td>
            <td>
                <?php
                if ($Cat1 > $Cat1_AVG+$Cat1_STDDEV) {
                    echo $Green_Feedback_Cat1;
                } else if ($Cat1 < $Cat1_AVG-$Cat1_STDDEV) {
                    echo $Red_Feedback_Cat1;
                } else {
                    echo $Yellow_Feedback_Cat1;
                }
                ?>
        <tr>
            <td><b>Recommendation</b></td>
            <td>
                <?php echo $recommendation_Cat1; ?>
            </td>
        </tr>

        </td>
        </tr>
    </table>
    <nav>
        <h1 style="color: black;">
            Competence development
        </h1>
        <?php


    
$recommendation_Cat2 = "We recommend you to apply theory efficiently using your analytical skills effectively for better improvement on your studies.  ";
$Green_Feedback_Cat2 = "Your responses reflect above-average competence development. Continue applying theory effectively, refining your analytical skills, and actively contributing to group dynamics. Your progress is impressive, and further growth is well within reach. ";
$Red_Feedback_Cat2 = "Your responses indicate room for improvement. Consider seeking extra support to bridge the gap between theory and practice, enhancing analytical skills, and actively engaging in group activities to develop teamwork abilities. With effort and assistance, you can make progress. ";
$Yellow_Feedback_Cat2 = "Your responses demonstrate a satisfactory level of competence development. To excel, consider further application of theory in practical situations, refining your analytical abilities, and actively participating in group work to enhance your teamwork skills. Keep up the good work! ";

        $sql = "SELECT * FROM Questions WHERE Email = '$email';";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Cat2 = $row["Cat2"];

            }
        } else {
            echo "The data is not available";
        }
        ?>
        <table class='table table-bordered table-dark'>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Your point</td>
                <td>
                    <?php echo $Cat2; ?>
                    <?php
                    echo drawGaugeChart($Cat2_AVG, $Cat2_STDDEV, $Cat2, "cat2")
                        ?>
                </td>
            </tr>
            <tr>
                <td><b>Feedback</b> </td>
                <td>
                    <?php
                    if ($Cat2 > $Cat2_AVG+$Cat2_STDDEV) {
                        echo $Green_Feedback_Cat2;
                    } else if ($Cat2 < $Cat2_AVG-$Cat2_STDDEV) {
                        echo $Red_Feedback_Cat2;
                    } else {
                        echo $Yellow_Feedback_Cat2;
                    }
                    ?>
            <tr>
                <td><b>Recommendation</b></td>
                <td>
                    <?php echo $recommendation_Cat2; ?>
                </td>
            </tr>

            </td>
            </tr>
        </table>

        <nav>
            <h1 style="color: black;">
                Learning Process and Environment
            </h1>
            <?php
            
$recommendation_Cat3 = "We recommend you to have a better relationship and regular communication with the workplace supervisors for maximize your learning and professional development. ";
$Green_Feedback_Cat3 = "You've performed well in receiving support from workplace supervisors, leveraging cooperation between the university and work placement, and interacting with supervising teachers during work placements. Continue to excel in these areas, maximizing your learning and professional development opportunities during placements. ";
$Red_Feedback_Cat3 = "Your feedback suggests challenges in receiving support from workplace supervisors, limited cooperation between the university and work placement, and a lack of support from supervising teachers. It's essential to proactively address these issues for a more successful work placement experience. ";
$Yellow_Feedback_Cat3 = "Your performance in receiving support from workplace supervisors, cooperation between the university and work placement, and interaction with supervising teachers during work placements is at an average level. To improve, consider enhancing communication and collaboration for a more fruitful experience. ";

            $sql = "SELECT * FROM Questions WHERE Email = '$email';";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $Cat3 = $row["Cat3"];

                }
            } else {
                echo "The data is not available";
            }
            ?>
            <table class='table table-bordered table-dark'>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Your point</td>
                    <td>
                        <?php echo $Cat3; ?>
                        <?php
                        echo drawGaugeChart($Cat3_AVG, $Cat3_STDDEV, $Cat3, "cat3")
                            ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Feedback</b> </td>
                    <td>
                    <?php
                    if ($Cat3 > $Cat3_AVG+$Cat3_STDDEV) {
                        echo $Green_Feedback_Cat3;
                    } else if ($Cat3 < $Cat3_AVG-$Cat3_STDDEV) {
                        echo $Red_Feedback_Cat3;
                    } else {
                        echo $Yellow_Feedback_Cat3;
                    }
                    ?>
                <tr>
                    <td><b>Recommendation</b></td>
                    <td>
                        <?php echo $recommendation_Cat3; ?>
                    </td>
                </tr>

                </td>
                </tr>
            </table>
            <nav>
                <h1 style="color: black;">
                    Wellbeing
                </h1>
                <?php
                
$recommendation_Cat4 = "We recommend you to have a better understanding of your learning and have a future goal which motivate yourself for reaching your goals";
$Green_Feedback_Cat4 = "Your above-average grade suggests that you have managed to maintain a good balance between study motivation, finding meaning in your studies, and maintaining healthy relationships despite the pressures of your academic workload. ";
$Red_Feedback_Cat4 = "Your low grade suggests you may benefit from seeking support and strategies to address your lack of study motivation and feelings of giving up. ";
$Yellow_Feedback_Cat4 = "Your average grade indicates that you may want to reflect on your study's meaning and consider finding ways to balance the pressures of your studies with your close relationships. ";

                $sql = "SELECT * FROM Questions WHERE Email = '$email';";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $Cat4 = $row["Cat4"];

                    }
                } else {
                    echo "The data is not available";
                }
                ?>
                <table class='table table-bordered table-dark'>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Your point</td>
                        <td>
                            <?php echo $Cat4; ?>
                            <?php
                            echo drawGaugeChart($Cat4_AVG, $Cat4_STDDEV, $Cat4, "cat4")
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Feedback</b> </td>
                        <td>
                        <?php
                    if ($Cat4 > $Cat4_AVG+$Cat4_STDDEV) {
                        echo $Green_Feedback_Cat4;
                    } else if ($Cat4 < $Cat4_AVG-$Cat4_STDDEV) {
                        echo $Red_Feedback_Cat4;
                    } else {
                        echo $Yellow_Feedback_Cat4;
                    }
                    ?>
                    <tr>
                        <td><b>Recommendation</b></td>
                        <td>
                            <?php echo $recommendation_Cat4; ?>
                        </td>
                    </tr>

                    </td>
                    </tr>
                </table>

                <?php
               session_destroy();
                include '../footer.php';
                ?>