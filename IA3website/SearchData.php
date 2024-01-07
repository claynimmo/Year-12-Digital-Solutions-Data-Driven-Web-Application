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

        <script>
            function searchData(){
                var xmlhttp = new XMLHttpRequest();
                var url = "ia2website.json";

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText); // <-- Add this line
                        var myArr = JSON.parse(this.responseText);
                        myFunction(myArr);
                    }
                };
                xmlhttp.open("GET", url, true);
                xmlhttp.send();

               
                document.getElementById("thing").innerHTML = "thing";
            }
            function search(arr) {
                    document.getElementById("id01").innerHTML = arr;
            }
        </script>
    </head>
        <body style="background-color: #565755">
        <?php include "Chunks/NavBar.html"; ?>
        <?php include 'Chunks/connect.php'; ?>
        
        <div class="centered_box"style = "float:centre;width:40%;">
            <h1 style = "text-align:center;">
                Search
            </h1>
            <form method="post" enctype="multipart/form-data">
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
                
            </form>
            <button style = "width:100%;"onclick="searchData()">Search</button>
        </div>
        <div id="thing">bob</div>
        <table style = "margin:auto ">
            <tr>
                <th style = "padding:20px">Monday</th>
                <th style = "padding:20px">Tuesday</th>
                <th style = "padding:20px">Wednesday</th>
                <th style = "padding:20px">Thursday</th>
                <th style = "padding:20px">Friday</th>
                <th style = "padding:20px">Saturday</th>
                <th style = "padding:20px">Sunday</th>
            </tr>
            <tr>
                <th style = "padding:20px">30%</th>
                <th style = "padding:20px">99%</th>
                <th style = "padding:20px">100%</th>
                <th style = "padding:20px">5%</th>
                <th style = "padding:20px">17%</th>
                <th style = "padding:20px">80%</th>
                <th style = "padding:20px">Sunday</th>
            </tr>
            
        </table>

        <br><br>
    </body>
</html>