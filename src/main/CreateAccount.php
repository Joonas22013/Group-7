
<!DOCTYPE html>
<html>

<head>
    <title>Create Account Form</title>
</head>

<body>

  
    <form action="actionCreateAccount.php" method="POST">
        <h3>User Information:</h3>
        <p><label for="email">Email:</label><input type="email" name="email" required></p>
        <p><label for="name">Name:</label><input type="text" name="name" required></p>

        <p>
            <label for="scope">Scope:</label>
            <select name="scope" required>
                <option value="Peer group1">Peer group1</option>
                <option value="Peer group2">Peer group2</option>
                <option value="Peer group3">Peer group3</option>
                <option value="Peer group4">Peer group4</option>
            </select>
        </p>

        <p>
            <label for="semester">Semester:</label>
            <select name="semester" required>
                <option value="Autumn2022">Autumn2022</option>
                <option value="Autumn2023">Autumn2023</option>
            </select>
        </p>

        <input type="submit" name="submit" value="Create Account">
    </form>

</body>

</html>