<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
?>
<span class="ag_inf_time" id="ag_srv_time">00:00:00</span>

<script>
var hours = <?php echo date("H"); ?>;
var min = <?php echo date("i"); ?>;
var sec = <?php echo date("s"); ?>;

var min2display = "00";
var sec2display = "00";
var hour2display = "00";

function display() {
sec+=1;
if (sec>=60)
{
min+=1;
sec=0;
}
if (min>=60)
{
hours+=1;
min=0;
}
if (hours>=24) {hours=0;}



if (sec<10) {
sec2display = "0"+sec;
} else {
sec2display = sec;
}

if (min<10) {
min2display = "0"+min;
} else {
min2display = min;
}

if (hours<10) {
hour2display = "0"+hours;
} else {
hour2display = hours;
}

document.getElementById("ag_srv_time").innerHTML = hour2display+":"+min2display+":"+sec2display;

setTimeout(function() { display(); }, 990);
}

display();
</script>