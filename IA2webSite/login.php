<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Style.css">
        <title>login</title>
    </head>
    <body style="background-color: #565755">
    <?php
        include "Chunks/NavBar.html";
    ?>
    <?php
        include "Chunks/connect.php";
        //only run the function if data is posted from a form
        $run = isset($_POST['submit']);
        if($run){
            //get values from the fomr
            $email = $_POST["email"];
            $password = $_POST["password"];

            //run SQL to check if there are any accounts using both the email and password
            $stmt = $conn->prepare("SELECT * FROM users WHERE users.email = '".$email."' AND users.password = ' ".$password."'");
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $row = $result -> fetch_assoc();
            // Free result set
            $result -> free_result();
            $conn -> close();
            //check if there are any accounts with the same ewmail and password
            if($row!=null){
                //since the form posts to itself, php sessions are used to transfer the posted results to the profile page
                session_start();
                $_SESSION['post_data'] = $_POST;
                $url = "profile.php";
                $_SESSION['run'] = true;
                //relocate user to the profile page
                header('Location: '.$url);
            }
            else{
                echo "email or password is incorrect";
            }
        }
    ?>
    <div class="centered_box"style = "text-align:center;">
        <p><span class="error">* required field</span></p>
        <form method="post"action="login.php">
            <label style="font-size:30px;" for="email">Email:</label><br>
            <input type="email" id="fname" name="email" value=""><span class="error"></span><br>
            <label style="font-size:30px"for="password">Password:</label><br>
            <input type="password" id="lname" name="password" value=""><span class="error"></span><br><br>
            <input name = "signIn"class="submit"type="submit" value="Submit">
        </form>
    </div>

    </body>

</html>