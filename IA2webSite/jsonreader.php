<div id="id01"></div>
<script>
//unused code taken from somewhere on the internet in case i decided to convert the dat into json
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

function myFunction(arr) {
    document.getElementById("id01").innerHTML = arr.CrimeID;
}
</script>
