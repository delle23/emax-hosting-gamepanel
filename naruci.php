<?php

		
session_start();
include("includes.php");

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}


/*$_SESSION['msg'] = "Open ticket for new server!";
		header("Location: gp-podrska.php");
		die();*/
		
$naslov = $jezik['text461'];
$fajl = "naruci";
$return = "naruci.php";
$ucp = "naruci";


include("./assets/header.php");


        
		

if(isset($_GET['igra']))
{	
	$igra = mysql_real_escape_string($_GET['igra']);
	$lokacija = mysql_real_escape_string($_GET['lokacija']);
	
	if(!is_numeric($igra) OR !is_numeric($lokacija))
	{
		$_SESSION['msg'] = $jezik['text462'];
		header("Location: naruci.php");
		die();
	}
	
	if($igra == "0" OR $igra > "3")
	{
		$_SESSION['msg'] = $jezik['text463'];
		header("Location: naruci.php");
		die();
	}
	
	if($lokacija != "2")
	{
		$_SESSION['msg'] = $jezik['text464'];
		header("Location: naruci.php");
		die();
	}

	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '{$_SESSION['klijentid']}'");

	$cenaslota = query_fetch_assoc("SELECT `cena` FROM `modovi` WHERE `igra` = '{$igra}'");
	$cenaslota = explode("|", $cenaslota['cena']);

	if($klijent['zemlja'] == "srb") $cena = $cenaslota[0];
	else if($klijent['zemlja'] == "hr") $cena = $cenaslota[3];
	else if($klijent['zemlja'] == "bih") $cena = $cenaslota[4];
	else if($klijent['zemlja'] == "mk") $cena = $cenaslota[2];
	else if($klijent['zemlja'] == "cg") $cena = $cenaslota[1];
	else if($klijent['zemlja'] == "other") $cena = $cenaslota[1];

}
else
{
	$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '{$_SESSION['klijentid']}'");
}


?>
<div id="sep" style="margin-bottom: 5px;"></div> <!-- #sep end -->


<table id="serverinfo">
	<tr>
		<th width="73%"></th>
		<th width="27%"></th>
	</tr>
	<tr>
		<td>	
			<div id="infox">
				<i style="font-size: 3em;" class="icon-gamepad"></i>
				<p id="h5"><?php echo $jezik['text465']; ?></p><br />
				<p><?php echo $jezik['text466']; ?></p><br />
			</div>
		</td>
		<td>	
			<div id="infox">
				<i style="font-size: 3em;" class="icon-user"></i>
				<p id="h5"><?php echo $jezik['text467']; ?></p><br />
				<p><?php echo $jezik['text468']; ?></p><br />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="td" style="overflow: inherit;">
<?php			
			if(!isset($_GET['igra']))
			{
				if(query_numrows("SELECT `id` FROM `serveri_naruceni` WHERE `klijentid` = '{$_SESSION['klijentid']}'") == 0)
				{
?>
				<div id="infox">
					<i class="icon-" style="font-size: 35px;">1</i>
					<p id="h5"><?php echo $jezik['text469']; ?></p><br />
					<p><?php echo $jezik['text470']; ?></p><br />
				</div>
				<form action="naruci.php" method="GET">
					<input type="hidden" name="nacin" value="1" />
					<input type="hidden" name="lokacija" value="2" />
					<select name="igra" rel="zemx">
						<option value="1">Counter-Strike 1.6</option>
						<option value="2">GTA San Andreas Multiplayer</option>
						<option value="3">Minecraft</option>
						<option value="4" disabled>Call of Duty 4 MW3 - <?php echo $jezik['text35']; ?></option>
					</select><br />
					<button class="btn btn-small btn-warning" type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text471']; ?></button>
				</form>
<?php	
				}	
				else
				{
?>			
				<div id="infox" style="margin-bottom: 4px;">
					<i class="icon-tasks" style="font-size: 55px;"></i>
					<p id="h5"><?php echo $jezik['text469']; ?></p><br />
					<p><?php echo $jezik['text472']; ?> <z><?php echo $jezik['text474']; ?></z>.</p><br />
					<p><?php echo $jezik['text473']; ?> <z><?php echo $jezik['text475']; ?></z>.</p><br />
				</div>
				<button onclick="location.href='naruci.php?nacin=1&lokacija=2&igra=1';" class="btn btn-warning btn-large btn-block" style="width: 48%; display:inline;"><i class="icon-gamepad"></i> <?php echo $jezik['text475']; ?></button>
				<button onclick="location.href='naruci-zahtev.php';" class="btn btn-large btn-block" style="width: 48%; margin-left: 8px; margin-top: 0px; display:inline;"><i class="icon-credit-card"></i> <?php echo $jezik['text474']; ?></button>			
<?php
				}
			}
			else if(isset($_GET['igra'])) {	?>
				<div id="infox">
					<i class="icon-" style="font-size: 35px;">2</i>
					<p id="h5"><?php echo $jezik['text476']; ?></p><br />
					<p><?php echo $jezik['text477']; ?></p><br />
				</div>
					<table width="100%">
						<tr>
							<th width="50%"></th>
							<th width="50%"></th>
						</tr>
						<tr>
						<form action="" method="get">
							<input type="hidden" name="nacin" value="1" />
							<input type="hidden" name="lokacija" value="2" />
							<td>
								<select name="igra" rel="csx" onchange="this.form.submit()">
									<option value="1" <?php if($_GET['igra'] == "1") echo'disabled selected="selected"'; ?>>Counter-Strike 1.6</option>
									<option value="2" <?php if($_GET['igra'] == "2") echo'disabled selected="selected"'; ?>>GTA San Andreas Multiplayer</option>
									<option value="3" <?php if($_GET['igra'] == "3") echo'disabled selected="selected"'; ?>>Minecraft</option>
									<option value="4" disabled <?php if($_GET['igra'] == "4") echo'disabled selected="selected"'; ?>>Call of Duty 4 MW3 - <?php echo $jezik['text35']; ?></option>
								</select>
								<label id="titlex">
								*<?php echo $jezik['text478']; ?>
								</label><br />
							</td>	
						</form>
						<form action="process.php" method="post" id="naruci-server">
							<input type="hidden" name="igra" value="<?php echo $igra; ?>" />
							<input type="hidden" name="task" value="naruciserver" />
							<input id="drzava" name="drzava" value="<?php echo $cena.'|'.drzava_valuta($klijent['zemlja']); ?>" type="hidden" />
							<input id="flag" name="zemlj" value="<?php echo drzava($klijent['zemlja']); ?>" title="<?php echo drzava_valuta($klijent['zemlja']); ?>" type="hidden" />				
							
							<td>
								<select name="slotovi" id="slotovi" rel="slotovix" onchange="izracunajCenu()">
									<option value="0">- <?php echo $jezik['text479']; ?> -</option>
							<?php	if($igra == "1") {	?>
									<option value="12">12 <?php echo $jezik['text480']; ?></option>
									<option value="14">14 <?php echo $jezik['text480']; ?></option>
									<option value="16">16 <?php echo $jezik['text480']; ?></option>
									<option value="18">18 <?php echo $jezik['text480']; ?></option>
									<option value="20">20 <?php echo $jezik['text480']; ?></option>
									<option value="22">22 <?php echo $jezik['text480']; ?></option>
									<option value="24">24 <?php echo $jezik['text480']; ?></option>
									<option value="26">26 <?php echo $jezik['text480']; ?></option>
									<option value="28">28 <?php echo $jezik['text480']; ?></option>
									<option value="30">30 <?php echo $jezik['text480']; ?></option>
									<option value="32">32 <?php echo $jezik['text480']; ?></option>                                                                      
							<?php	}
									if($igra == "2") {	?>
									<option value="20">20 <?php echo $jezik['text480']; ?></option>
									<option value="30">30 <?php echo $jezik['text480']; ?></option>
									<option value="40">40 <?php echo $jezik['text480']; ?></option>
									<option value="50">50 <?php echo $jezik['text480']; ?></option>
									<option value="100">100 <?php echo $jezik['text480']; ?></option>
									<option value="150">150 <?php echo $jezik['text480']; ?></option>
									<option value="200">200 <?php echo $jezik['text480']; ?></option>
									<option value="250">250 <?php echo $jezik['text480']; ?></option>
									<option value="300">300 <?php echo $jezik['text480']; ?></option>
									<option value="350">350 <?php echo $jezik['text480']; ?></option>
									<option value="400">400 <?php echo $jezik['text480']; ?></option>
									<option value="450">450 <?php echo $jezik['text480']; ?></option>
									<option value="500">500 <?php echo $jezik['text480']; ?></option>
							<?php	}
									if($igra == "3") {	?>	
									<option value="30">30 <?php echo $jezik['text480']; ?></option>
									<option value="35">35 <?php echo $jezik['text480']; ?></option>
									<option value="40">40 <?php echo $jezik['text480']; ?></option>
									<option value="50">50 <?php echo $jezik['text480']; ?></option>
									<option value="60">60 <?php echo $jezik['text480']; ?></option>
									<option value="70">70 <?php echo $jezik['text480']; ?></option>
									<option value="75">80 <?php echo $jezik['text480']; ?></option>
									<option value="80">90 <?php echo $jezik['text480']; ?></option>
									<option value="85">100 <?php echo $jezik['text480']; ?></option>
                                                                        <option value="120">150 <?php echo $jezik['text480']; ?></option>
                                                                        <option value="160">200 <?php echo $jezik['text480']; ?></option>
							<?php	}
									if($igra == "4") {	?>		
									<option value="12">12</option>
									<option value="14">14</option>
									<option value="16">16</option>
									<option value="18">18</option>
									<option value="20">20</option>
									<option value="22">22</option>
									<option value="24">24</option>
									<option value="26">26</option>
									<option value="28">28</option>
									<option value="30">30</option>
									<option value="32">32</option>
									<option value="34">34</option>
									<option value="36">36</option>
									<option value="38">38</option>
									<option value="40">40</option>
									<option value="42">42</option>
									<option value="44">44</option>
									<option value="46">46</option>
									<option value="48">48</option>
									<option value="50">50</option>
									<option value="52">52</option>
									<option value="54">54</option>
									<option value="56">56</option>
									<option value="58">58</option>
									<option value="60">60</option>
									<option value="62">62</option>
									<option value="64">64</option>																
							<?php	}	?>									
								</select>					
								<label id="titlex">
								*<?php echo $jezik['text481']; ?>
								</label><br />
							</td>
						</tr>						
						<tr>
							<td>
								<select name="nacin" rel="zemx">
									<option value="1"><?php echo $jezik['text482']; ?></option>
									<option value="1"><?php echo "PayPal"; ?></option>
									<option value="1"><?php echo "SMS"; ?></option>
									<option value="1"><?php echo "PaySafeCard"; ?></option>
								</select>
								<label id="titlex">
								*<?php echo $jezik['text483']; ?>
								</label><br />
							</td>					
							<td>
								<select name="mesec" id="meseci" rel="mesecx" onchange="izracunajCenu()">
									<option value="1">1 <?php echo $jezik['text484']; ?></option>
								</select>	
								<label id="titlex">
								*<?php echo $jezik['text489']; ?>
								</label><br />
							</td>
						</tr>
						<tr>
							<td>
								<select name="lokacija" rel="zemx">
									<option disabled value="1" <?php if($_GET['lokacija'] == "1") echo'disabled selected="selected"'; ?>>Premium - <?php echo $jezik['text490']; ?></option>
									<option selected="selected" value="2" <?php if($_GET['lokacija'] == "2") echo'selected="selected"'; ?>>Lite - <?php echo $jezik['text491']; ?></option>
								</select>
								<label id="titlex">
								*<?php echo $jezik['text492']; ?>
								</label><br />
							</td>					
							<td>
								<div name="cena" type="text" class="cenau" readonly="readonly" id="cena"><?php echo $jezik['text493']; ?>...</div>
								<input type="hidden" id="cenab" name="cenab" />
								<label id="titlex">
								*<?php echo $jezik['text494']; ?>
								</label><br />
							</td>
						</tr>
						<tr>
							<td>
								<input type="hidden" name="klijentid" value="<?php echo $_SESSION['klijentid']; ?>" />
								<button class="btn btn-small btn-warning" type="submit"><i class="icon-arrow-right"></i> <?php echo $jezik['text495']; ?></button>
							</td>
						</tr>
					</table>
				</form>
		<?php	}	?>
			</div>
		</td>
		<?php include "gp-accountinfo.php"; ?>
	</tr>
</table>
<?php
include("./assets/footer.php");
?>