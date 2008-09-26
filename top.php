<?php
session_start();
include ("config.php");
include ("toolbox.php");

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>
<html>
<head>
<title>Darghos Server</title>
<meta name="keywords" content="OtServ, tibia, server, otserver, ots, open tibia server, open tibia, games, mmorpg" />
<meta name="author" content="UltraxSoft" />
<meta name="description" content="Darghos é um Open Tibia RPG-Online gratuito, venha conhecer este magnifico projeto!">
<meta name="verify-v1" content="uThQU4N3a3z16281fWAYyDbkuf3XhfCdHhpDOulk5gE=">
<link rel="stylesheet" href="indexs.css" type="text/css">
</head>

<body class="backg">
<center>
<table border="0" cellpadding="0" cellspacing="0">

  <tbody>
    <tr>
    <td class="surround"> 
	
      <center>
	</center>

		
      <center>
          </center>
      <table border="0" cellpadding="8" cellspacing="0" width="1000">

        <tbody>
          <tr>
            <td colspan="3" class="top" align="center" background="images/logo.jpg" valign="bottom">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		</td>

        </tr>

	<tr>

          <td colspan="3" class="nav">
            <center>
<?  
echo'        
	  <a href="index.php" class="navlink" title="Index of Darghos">  '.$lang['home'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
	  <a href="about.php?subtopic=about" class="navlink" title="Informations about Darghos"> '.$lang['sobre'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="about.php?subtopic=faq" class="navlink" title="Questions and answers frequently"> '.$lang['faq'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
	  <a href="about.php?subtopic=featurespremium" class="navlink" title="You want contribute with Darghos?"> '.$lang['premium'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="download.php" class="navlink" title="Downloads"> '.$lang['downloads'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="about.php?subtopic=support" class="navlink" title="Need help or support?"> '.$lang['suporte'].'</a>';
?>    
  
            </center>
            </td>

          </tr>	
          <tr>
            <td class="lcont">	
<?
include "menu.php";
?>	
          <td class="ccont"><br>
			<TABLE CELLSPACING=0 CELLPADDING=2 BORDER=0 WIDTH=99% align=center class=surround>
			