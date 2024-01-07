<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Style.css">
        <title>home</title>
        <style>
table, th, td {
  border:2px solid black;
  padding: 5px;
}
</style>
    </head>
    <body style="background-color: #565755">
    <?php
    include "Chunks/NavBar.html";
    ?>
        <div class="centered_box"style = "float:right;margin-right:150px;">
            <h1>Neighbourhood Watch</h1>
            <p>register your email with the site to recieve emails depending on your location when any new data is inputed</p>
            <p>Disclaimer:</p>
            <p>The materials available on or through this website are distributed by the Queensland Government as an information source only.

To the maximum extent permitted by law, the State of Queensland makes no statement, representation, or warranty about the quality, accuracy, context, completeness, availability or suitability for any purpose of, and you should not rely on, any materials available on or through this website.

Despite our best efforts, the State of Queensland makes no warranties that the materials available on or through this website are free of infection by computer viruses or other contamination, to the maximum extent permitted by law.

The Queensland Government disclaims, to the maximum extent permitted by law, all responsibility and all liability (including without limitation, liability in negligence) for all expenses, losses, damages and costs you or any other person might incur for any reason including as a result of the materials available on or through this website being in any way inaccurate, out of context, incomplete, unavailable, not up to date or unsuitable for any purpose.

A user of this website who uses the links provided to another Queensland Government agency’s website and material available on or through that other website acknowledges that the disclaimer and any terms of use, including licence terms, set out on the other agency’s website govern the use which may be made of that material.
            </p>
        </div>
        <div class = "sideBox"style = "width: 20%; float:left;overflow: scroll;">
        
            <?php
                include 'Chunks/connect.php';
                $num = 5;
               
                $colors = Array("#247675","#2FA09E","#33B2B0","#24C1BF","#1AD0CE");
                $severityColors = Array("#ffffff","#cccc00","#e60000");

                    $sql = "SELECT * FROM records ORDER BY 'date'  LIMIT 5";
                    $result = mysqli_query($conn,$sql);
                    $x = 0;
                    // loop through the queried data
                    while ($row = mysqli_fetch_assoc($result)){
                        //get the values from the query
                        $number = $row['number'];
                        $location = mysqli_query($conn, 'SELECT location FROM Location WHERE location.ID = '.$row['locationID'].'');
                        $crime = mysqli_query($conn, 'SELECT crime_types FROM crime WHERE crime.CrimeID = '.$row['crimeID'].'');
                        $row2 = mysqli_fetch_array($location);
                        $location2 = $row2['location'];
                        $row3 = mysqli_fetch_array($crime);
                        $crime2 = $row3['crime_types'];
                        $index = 0;
                        if($number>=5){
                            $index = 2;}
                        else if($number>=3){
                            $index = 1;}
                        else{
                            $index = 0;}
                        $time = $row['date'];
                        //create a box to display the information
                        echo "<div style = 'background-color: ".$colors[$x]."; padding: 10px;border:4px solid;'>";
                        echo "<table style = 'background-color: ".$severityColors[$index]."'>";
                        echo "<tr><th>Amount</th><th>".$number."</th></tr>";
                        echo "<tr><th>Crime</th><th>".$crime2."</th></tr>";
                        echo "<tr><th>Time</th><th>".$time."</th></tr>";
                        echo "<tr><th>Location</th><th>".$location2."</th></tr>";
                        echo "</table></div>";                        
                        $x += 1;
                    }
            ?>
        </div>
        

            
    </body>

</html>