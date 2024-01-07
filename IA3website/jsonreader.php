<div id="id01"></div>

<script>
function loadXMLDoc(){
var xmlhttp = new XMLHttpRequest();
var url = "xmlfiles/IDQ11290.xml";

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var xml = simplexml_load_string($xml_string);
        var json = json_encode(xml);
        processCode(json);
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();}

function processCode(arr) {
    const obj = JSON.parse(arr);
    var output = "";
    //loop through the entire JSON file
    for( let x in obj){
        //loop through the entire area object
        for (let z in obj[x].area){
            var location = obj[x].area[z].aac;
            //check if the location matches the user's input
            if(location == userLocation){
                const forecast = obj[x].area[z].forecast-period;
                var icon = forcast.element[0];
                //the icons array is self determined and contains image links
                var iconLink = icons[icon];
                var airTemp = forecast.element[1];
                var warningLong = forecast.text[0];
                var warningPrecic = forecast.text[1];
                var fireWarning = forecast.text[2];
                var uv_alert = forecast.text[3];
            }
            //logic to process code simplically or tabularly
            if(simple){
                //the output is created as a string containing the values and the html tags to create an element
                output = "<table class = 'simpleStyle'><tr><a href = '"+iconLink+"alt = 'forecastImage'></tr><tr><p>"+
                warningPrecic"</p></tr><tr><p>max temperature: " + airTemp+"</tr></table";}
            else{
                output = "<table class = 'complexStyle'><tr><td>temperature</td><td><p>" + airTemp
                +"</p>... repeated for every other variable
            }
        }  
    }
    //output the data to the user dynamically
    document.getElementById("id01").innerHTML = output;
}

//generate map using google maps API
function initMap() {
    var options = {     
        zoom: 10,
        center: { lat: 33.933241, lng: -84.340288 }
    }
    var map = new google.maps.Map(document.getElementById('map'), options);
    var marker = new google.maps.Marker({
        position: { lat: 33.933241, lng: -84.340288 },
        map: map
    });
    //get coordinates of the position the user clicks with a mouse
    map.addListener("click", (mapsMouseEvent) => {
        var position = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        const pos = JSON.parse(position);
        var latitude = pos.lat;
        var longitude = pos.lng;
        //change values of a html form so that these values will be posted into the database
        Document.getElementById("lat").value = latitude;
        Document.getElementById("lng").value = longitude;
    });
}
<?php
    include "Chunks/connect.php";
    $sql = "SELECT GeoPhotos.*, Users.username FROM GeoPhotos,Users WHERE GeoPhotos.userID = Users.userID";
    $result = $conn->prepare($sql);
    $result-> execute();
    // loop through the queried data
    $x = 0;
    while ($row = mysqli_fetch_assoc($result)){
        $lat[$x] = $row['Lat'];
        $long[$x] = $row['Long'];
        $image_path[$x] = $row['image_path'];
        $username[$x] = $row['username'];
        $x+=1;
    }
?>
//generate map using google maps API
function initMap() {
    var options = {     
        zoom: 10,
        center: { lat: 33.933241, lng: -84.340288 }
    }
    var map = new google.maps.Map(document.getElementById('map'), options);
    for(int i = 0)
    var marker = new google.maps.Marker({
        position: { lat: 33.933241, lng: -84.340288 },
        map: map
    });
    //get array from php variable
    const latarr = <?php $lat ?>
    const lngarr = <?php $lat ?>
    //create a marker for every image in the database, put on the location selected by the user
    for (var x=0; x>latarr.Length; x++){
        var marker = new google.maps.Marker({
            position: { lat: latarr[x], lng: lngarr[x] },
            map: map
            title: <?php echo"<a href = "+$image_path[x]+">"?>
        });
    }
}


<?php
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            //upload the photo into the database using the file path
            $file_path = htmlspecialchars(pathinfo($_FILES["fileToUpload"]["name"]));
            include "Chunks/connect.php";
            $sql = "INSERT INTO GeoPhotos VALUES (null, $lat, $long, $file_path, $userID";
            $result = $conn->prepare($sql);
            $result ->execute();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>
</script>
<body>
    <button type="button" onclick="loadXMLDoc()">Change Content</button>
    <p id = "id01"></p>

    <?php
        $ftp_server = "ftp.bom.gov.au";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $local_file = "xmlfiles";
        $server_file = "IDQ11290.xml";
        $login = ftp_login($ftp_conn, "anonymous", "guest");

        // download server file
        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII))
        {
        echo "Successfully written to $local_file.";
        }
        else
        {
        echo "Error downloading $server_file.";
        }

        // close connection
        ftp_close($ftp_conn);
    ?>
</body>