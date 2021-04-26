<?php 
header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
$ag_protocol = 'http://';
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { $ag_protocol = 'https://'; }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>404</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow"/>
<style>
body {color: #232325; font-family: Arial, Tahoma; background:#f3f3f5; font-size:16px; width:100%; min-height:600px; margin:0; padding:0; display:block;}
a, a:visited { color:#474A59; text-decoration:underline; outline:none; }
a:hover { color:#000; text-decoration:underline; }

h1 {
font-size:30px; 
color:#737375;
margin:0;
padding:0;}

#main{
display:block;
margin:0;
padding:30px;
}

.top {
background:#fff;
display:block;
padding:0;
margin:0 auto;
width:600px;
height:600px;
border-radius: 600px;
-webkit-border-radius: 600px;
-moz-border-radius: 600px;
-khtml-border-radius: 600px;
text-align:center;
border: #f7f7f9 30px solid;
box-shadow: 0 0 60px rgba(0,0,0,0.05);
}

.top h1 {
display:block;
margin:30px auto 30px auto;
padding:230px 0 0 0;
}

.top span {
display:block;
margin:30px auto 30px auto;
}

.top small {
display:block;
margin:30px auto 30px auto;
}

.copy {text-align:center; color:#737375; margin:30px auto 30px auto; font-size:12px; width:800px;}
</style>

</head>

<body>
<div id="main">
<script type="text/javascript">
function timer(){
 var obj=document.getElementById('timer_inp');
 obj.innerHTML--;
 if(obj.innerHTML==0){
 location = "<?php echo $ag_protocol.$_SERVER['HTTP_HOST']; ?>"
 setTimeout(function(){},1000);}
 else{setTimeout(timer,1000);}
}
setTimeout(timer,1000);
</script>
<noscript><meta http-equiv="refresh" content="10; url=<?php echo $ag_protocol.$_SERVER['HTTP_HOST']; ?>"></noscript>


<div class="top">
<h1>Ошибка 404. Страница не найдена.</h1>

<p>Перенапраление на на главную через <b id="timer_inp">10</b> сек.</p>
<span>Перейти на <a href="<?php echo $ag_protocol.$_SERVER['HTTP_HOST']; ?>"><?php echo $_SERVER['HTTP_HOST']; ?></a></span>
</div>

</div>

<div class="copy">
&copy; <?php echo date('Y'); ?> <a href="<?php echo $ag_protocol.$_SERVER['HTTP_HOST']; ?>"><?php echo $_SERVER['HTTP_HOST']; ?></a>
</div>

</body>
</html>