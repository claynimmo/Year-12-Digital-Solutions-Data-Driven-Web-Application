<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="Style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <title>upload</title>
    </head>
    <body style = "background-color: #565755">
        <?php include "Chunks/NavBar.html"; ?>
        <div class = "centered_box"style = "margin-top:0px;border-bottom:none">
            <h1>
                Data uploaded into the database
            </h1>
        </div>
        <div class = "centered_box" style = "overflow:scroll;height:60%;margin-top:0px;border-top:none;">
            <?php
                //determine whether the file inputs the data into the database, or just reads the file for confirmation
                $run = true;
                if (isset($_POST['updateData']))
                {
                    $run = true;
                    echo $run;
                }
                function getSeverity($number){
                    if($number>=5){
                        $index = 2;
                    }
                    else if($number>=3){
                        $index = 1;
                    }
                    else{
                        $index = 0;
                    }
                    return $index;
                }
                if($run){
                    include 'Chunks/connect.php';}
                function emailUser($severity,$date,$number,$crimetype,$location){
                    global $email;
                    global $password;
                    echo".$email";
                    include 'Chunks/connect.php';
                    $sql = "SELECT * FROM `users` WHERE alertTypre = '$severity'AND `location` = $location";
                    $result = mysqli_query($conn, $sql);
                    $str1="";
                    if($severity>=5){
                        $severitystr = "severe";
                    }
                    else if($number>=3){
                        $severitystr = "moderate";
                    }
                    else{
                        $severitystr = "mild";
                    }
                    while($row = mysqli_fetch_assoc($result)) {
                        $email = $row['email'];
                        $str2 = "we are emailing to warn you of a ".$severitystr." case of ".$crimetype." at your location.
                        The crime was recorded on the ".$date;
                        ini_set("SMTP", "sendmail");
                        mail($email,"crime warning", $str);
                        print $str;
                    }
                }
                //only connect to the database if it is necessary
                
                if (isset($_POST['submit']))
                {
                    //acceptable file types
                    $fileMimes = array(
                        'text/x-comma-separated-values',
                        'text/comma-separated-values',
                        'application/octet-stream',
                        'application/vnd.ms-excel',
                        'application/x-csv',
                        'text/x-csv',
                        'text/csv',
                        'application/csv',
                        'application/excel',
                        'application/vnd.msexcel',
                        'text/plain'
                    );
                    // Validate whether selected file is a CSV file
                    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
                    {
                        // Open uploaded CSV file with read-only mode
                        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                        //upload data into database
                        if($run){
                            //Put first row into the crimes database
                            $start = 2; //value for the for loop
                            $data = fgetcsv($csvFile); //read first row of csv in an array
                            $tablename = "crime";
                            $columnName = "crime_types";
                            echo "table: ".$tablename . "<br>data: <br>";
                            for($x=$start;$x<Count($data);$x++){
                                $value = mysqli_real_escape_string($conn,$data[$x]);

                                //include the sql from the other file
                                include 'Chunks/SQLStatements.php';

                                //check if the value is already in the table before inserting
                                $result = mysqli_query($conn,$CHECKIFEXISTS);
                                if (mysqli_num_rows($result)==0) {
                                    //insert into the database
                                    mysqli_query($conn, $INSERT);
                                    echo " ".$data[$x];
                                }
                            }
                            // $tablename = "records";
                            // echo "table: ".$tablename . "<br>data: <br>";
                            // $num = 1;
                            // $start = 2;
                            // while (($data = fgetcsv($csvFile))!== false&&$num <= 5){
                            //     $dateString = $data[1]; // The date value from the CSV file
                            //     echo $dateString;
                            //     $date = DateTime::createFromFormat('MYj', $dateString);
                            //     if($date){
                            //         $date = $date->format('Y-m-d');
                            //     }
                                
                            //     for($x=$start;$x<27;$x++){
                            //         $number = mysqli_real_escape_string($conn,$data[$x]);
                            //         $index = getSeverity($number);
                                    
                            //         $column = 'crime_types';
                            //         $table = 'crime';
                            //         $sql = "SELECT $column FROM $table WHERE crime.CrimeID = ($x-1)";
                            //         $result = mysqli_query($conn,$sql);
                            //         $row = mysqli_fetch_array($result);
                            //         $crimetype = $row[0];
                            //         $location = mysqli_real_escape_string($conn,$data[0]);
                            //         emailUser($index,$date,$number,$crimetype,$location);
                            //         if($number!=0){
                            //         $insert = "INSERT INTO $tablename VALUES(null,$location,$crimetype,$number,$date)";
                            //         mysqli_query($conn,$insert);
                            //         echo "".$crimetype;}
                            //         echo $date;
                            //     }
                            //     echo '<br><br>';
                            //     $num +=1;
                            // }


                            
                            //Put first column into the location database
                            
                            $tablename = "location";
                            $columnName = "Location";
                            echo "table: ".$tablename . "<br>data: <br>";
                            $prevnum="";
                            $data = fgetcsv($csvFile);
                            while($data = fgetcsv($csvFile,1000,",")){
                                $value = mysqli_real_escape_string($conn,$data[0]);
                                include 'Chunks/SQLStatements.php';
                                if($prevnum!=$data[0]){
                                    $result = mysqli_query($conn,$CHECKIFEXISTS);
                                    if (mysqli_num_rows($result)==0) {
                                        //insert into the database
                                        mysqli_query($conn, $INSERT);
                                        echo " ".$value;
                                    }}
                                $prevnum = $data[0];
                            }

                            
                            
                            // Close opened CSV file
                            fclose($csvFile);
                            //header("Location: index.php");
                        }
                        //display csv file's contents
                        else{
                            echo "<html><body><center><div style='border:inset;backround-colour:lightgrey;'><table>\n\n";
                            // Fetching data from csv file row by row
                            while (($data = fgetcsv($csvFile)) !== false) {
                                // HTML tag for placing in row format
                                echo "<tr style = 'border:solid;'>";
                                foreach ($data as $i) {
                                    echo "<td>" . htmlspecialchars($i) . "</td>";
                                }
                                echo "</tr> \n";
                            }
                            // Closing the file
                            fclose($csvFile);
                            echo "\n</table></center></div></body></html>";
                        }
                        
                    }
                    // display error if the file type is not csv
                    else
                    {
                        echo "Please select valid file";
                    }

                }

                // DELETE FROM location; ALTER TABLE location AUTO_INCREMENT = 0;
            ?>
        </div>
        <div class = "centered_box"style = "margin-top:0px;border-bottom:none;border-top:none">
            <br><br><br>
            <h1>Insert Another file</h1>
        </div>
        <?php include "Chunks/InputFile_Form.php";?>
        <div class = "centered_box"style = "margin-top:0px;border-top:none;border:12px solid red">
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="centered_box"style = "margin-top:30px;border:12px solid red">
                        <input class="btn btn-primary"style = "margin:auto; width:50%;height:30%;margin-left:62.5px;"type = "submit">
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br>
    </body>
</html>