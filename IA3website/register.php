<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Style.css">
        <title>register</title>
    </head>
    <body style="background-color: #565755">
    <?php
    include "Chunks/NavBar.html";
    ?>
    <?php
        include "Chunks/connect.php";
      
        $run = isset($_POST['submit']);
        if($run){
            //validate if all form elements are filled
            if($_POST["email"]!=null&&$_POST['password']!=null){
                echo "run";
                $email = $_POST["email"];
                $email = mysqli_real_escape_string($conn,$email);
                
                //run SQL to check if there are any accounts with the same email
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE users.email = '".$email."'");
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                //check if a user already exists and give an error message
                if($user!=null){
                    echo "email already in use";
                }
                else{
                    $email = $_POST["email"];
                    $email = mysqli_real_escape_string($conn,$email);
                    $password = $_POST["password"];
                    $password = mysqli_real_escape_string($conn,$password);
                    $location = $_POST["Location"];
                    $location = mysqli_real_escape_string($conn,$location);
                    $sel = "SELECT ID FROM `location`WHERE location.Location = '".$location."'";
                    $res = mysqli_query($conn,$sel);
                    $rowthing = mysqli_fetch_array($res);
                    $location = $rowthing['ID'];
                    $location = (int) $location;
                    $warning = $_POST["warning"];
                    $warning = mysqli_real_escape_string($conn,$warning);
                    $warning = (int) $warning;

                    echo $email;
                    echo $password;
                    echo $warning;
                    echo $location;
                    $nullVar = null;
                    //insert values into the database, registering a new user
                    $stmt = $conn->prepare("INSERT INTO `users` VALUES (?, ?, ? , ?, ? )");
                    $stmt->bind_param('issii', $nullVar, $email, $password , $warning , $location);
                
                    $stmt->execute();
                    
                    //transmit the posted data to another webpage so that the profile page has the accurate data
                    session_start();
                    $_SESSION['post_data'] = $_POST;
                    $url = "profile.php";
                    $_SESSION['run'] = false;
                    //relocate user to the profile page
                    header('Location: '.$url);
                }// Free result set
                $result -> free_result();
            }
            else{
                echo 'input an email or password';
            }
        }
    ?>
    <div class="centered_box"style = "text-align:center;">
        <p><span class="error">* required field</span></p>
        <form method="post"action="register.php">
            <label style="font-size:30px;" for="email">Email:</label><br>
            <input type="email" id="email" name="email" value=""><span class="error"></span><br>
            <label style="font-size:30px"for="password">Password:</label><br>
            <input type="password" id="password" name="password" value=""><span class="error"></span><br><br>
            <label style="font-size:30px"for="Location">Location:</label><br>
                        <select name="Location" id="Location">
                            <?php
                                $tablename = "location";
                                $columnName = "Location";
                                include 'Chunks/SQLStatements.php';
                                $result = mysqli_query($conn, $SELECTDISTINCT);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row[$columnName]. "'>" . $row[$columnName]. "</option>";
                                    }
                                }
                                
                            ?>
                        </select><br>
                <label style="font-size:30px"for="warning">warning level:</label>
                    <br>
                    <select name="warning" id="warning">
                        <option value="0">all</option>
                        <option value="1">moderate and above</option>
                        <option value="2">severe only</option>
                    </select><br>
           <input name = "submit"class="submit"type="submit" value="Register"> 
        </form>
    </div>

    </body>
    <?php
        $conn -> close();
    ?>

</html>