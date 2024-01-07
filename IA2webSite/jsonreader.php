<div id="id01"></div>

<script>
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