<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Style.css">
        <title>profile</title>
    </head>
    <body style="background-color: #565755">
    <?php
    include "Chunks/NavBar.html";
    ?>
    <?php
        include "Chunks/connect.php";
      $bol = false;
      if($bol){
        //get data from session and close it
        session_start();
        $Data = $_SESSION['post_data'];
        $run = $_SESSION['run'];
        session_destroy();
        if($Data!=null){
            
        }
        if($run){
            $email = $Data["email"];
            $stmt = $conn->prepare("SELECT * FROM users WHERE users.email = emailthing");
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $row = $result -> fetch_assoc();
            // Free result set
            $result -> free_result();
            $conn -> close();
            if($row['email']!=null){
                echo "email already in use";
            }
            else{
            
            }
           
        }}
    ?>
    <div class="centered_box"style = "text-align:center;">
        <form method="post"action="register.php">
            <label style="font-size:30px"for="Location">Change Location:</label><br>
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
                <label style="font-size:30px"for="warning">Change warning level:</label>
                    <br>
                    <select name="warning" id="warning">
                        <option value="0">all</option>
                        <option value="1">moderate and above</option>
                        <option value="2">severe only</option>
                    </select><br><br>
            <input name = "submit"style="width:100%;"class="submit"type="submit" value="Submit">
            <input name = "submit"style="width:100%;"class="submit"type="submit" value="Delete Account">
        </form>
    </div>
    </body>

</html>
