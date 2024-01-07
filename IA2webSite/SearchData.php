<html lang="en">
    <head>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Style.css">
        <title>search</title>
        <style>
        table, th, td {
  border:2px solid black;
  padding: 5px;
}
        </style>
    </head>
        <body style="background-color: #565755">
        <?php include "Chunks/NavBar.html"; ?>
        <?php include 'Chunks/connect.php'; ?>
        <?php
            $run = isset($_POST['submit']);
            if($run){
                //get data from form
                $Location = $_POST["Location"];
                $crime = $_POST["crime"];
                $date = $_POST["Date"];
                //get all necessary data from SQL queries
                $sql1 = "SELECT * FROM `crime` WHERE crime.crime_types = '".$crime."'";
                $result = mysqli_query($conn,$sql1);
                $result = mysqli_fetch_assoc($result);
                $sql2 = "SELECT * FROM `location` WHERE location.Location = '".$Location."'";
                $result2 = mysqli_query($conn,$sql2);
                $result2 = mysqli_fetch_assoc($result2);
                $sql3 = "SELECT * FROM `records` WHERE records.LocationID = '".$result2['ID']."' AND records.crimeID = '".$result['CrimeID']."' AND records.date = '".$date."'";
                $result3 = mysqli_query($conn,$sql3);
                $severityColors = Array("#ffffff","#cccc00","#e60000");
                while ($row = mysqli_fetch_assoc($result3)){
                    $number = $row['number'];
                    $location = mysqli_query($conn, 'SELECT location FROM Location WHERE location.ID = '.$row['locationID'].'');
                    $crime = mysqli_query($conn, 'SELECT crime_types FROM crime WHERE crime.CrimeID = '.$row['crimeID'].'');
                    $row2 = mysqli_fetch_array($location);
                    $location2 = $row2['location'];
                    $row3 = mysqli_fetch_array($crime);
                    $crime2 = $row3['crime_types'];
                    $index = 0;
                    //algrithm to determine severity
                    if($number>=5){
                        $index = 2;}
                    else if($number>=3){
                        $index = 1;}
                    else{
                        $index = 0;}
                    $time = $row['date'];
                    //create the data box
                    echo "<div class='centered_box'style = 'float:right;'>";
                    echo "<div 'padding: 10px;border:4px solid;'>";
                    echo "<table style = 'background-color: ".$severityColors[$index]."'>";
                    echo "<tr><th>Amount</th><th>".$number."</th></tr>";
                    echo "<tr><th>Crime</th><th>".$crime2."</th></tr>";
                    echo "<tr><th>Time</th><th>".$time."</th></tr>";
                    echo "<tr><th>Location</th><th>".$location2."</th></tr>";
                    echo "</table></div>";    
                    echo "</div>";                    
                }
            }
        ?>
        <div class="centered_box"style = "float:left;width:40%;">
            <h1 style = "text-align:center;">
                Search
            </h1>
            <form action="SearchData.php" method="post" enctype="multipart/form-data">
                <div class="form_dropdown">
                    <label for="crime">Select crime type:</label>
                        <select name="crime" id="crime">
                            <?php
                                $tablename = "crime";
                                $columnName = "crime_types";
                                include 'Chunks/SQLStatements.php';
                                $result = mysqli_query($conn, $SELECTDISTINCT);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                      echo "<option value='" . $row[$columnName]. "'>" . $row[$columnName]. "</option>";
                                    }
                                  }
                            ?>
                        </select>
                </div>
                <div class="form_dropdown">
                    <label for="Location">Location:</label>
                        <select name="Location" id="Location">
                            <?php
                                $tablename = "location";
                                $columnName = "Location";
                                include 'Chunks/SQLStatements.php';
                                $result = mysqli_query($conn, $SELECTDISTINCT);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value= '" . $row[$columnName]. "'>" . $row[$columnName]. "</option>";
                                    }
                                }
                                
                            ?>
                        </select>
                </div>
                <div class="form_dropdown">
                    <label for="Date">Date:</label>
                        <select name="Date" id="Date">
                            <?php
                                $tablename = "records";
                                $columnName = "date";
                                include 'Chunks/SQLStatements.php';
                                $result = mysqli_query($conn, $SELECTDISTINCT);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value=" . $row[$columnName]. ">" . $row[$columnName]. "</option>";
                                    }
                                }
                                
                            ?>
                        </select>
                </div>
                <input style = "width:100%;"type="submit" name="submit" value="Search">
            </form>
        </div>
    </body>
</html>