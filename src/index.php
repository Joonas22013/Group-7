 <?php include('header.php'); ?>
<div class="row">
              <div class="column">
              <div class="scope">
                     <h4>Email here</h4>
                     <form action="../main/indexAction.php" method="post">
                            <input type="email" name="email" placeholder="Email" required><br>
                            <input type="password" name="pass" placeholder="Password" required><br>
                            <input type="submit" value="Login" name="Login" class="btn btn-primary">
                     </form>
                     <p>Don't have an account? <a href="./main/CreateAccount.php">Sign up here</a></p>
              </div>
              </div>
       </div>


<?php include('footer.php'); ?>
