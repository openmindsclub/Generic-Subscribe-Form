<?php
	session_start();
?>
<?php
include('config.php'); // Here we got include the config file
include('mail/mail.php');
session_start();
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Inscription</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script
src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<link rel="icon"
	 href="logo.png"/>


<script>
var rb;
window.onload=function(){
	rb=document.getElementById("knownyes");
	rb.addEventListener("change",function(e){
		if(rb.checked){
			document.getElementById("kakashi").style.display="initial";}

	});

	rc=document.getElementById("knownno");
	rc.addEventListener("change",function(e){
		if(rc.checked){
			document.getElementById("kakashi").style.display="none";
		}
	});
}
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>














<body>
  <h1 class="register-title">Inscription</h1>
  <form class="register" method="post" action="index.php">
	<?php
		if(isset($_SESSION['error'])){
			echo '<div style="color: #A72020; font-weight: bold; text-align: center; margin-bottom: 10px;">'.$_SESSION['error'].'</div>';
			unset($_SESSION['error']);
		}
	?>
	<input required type="text" class="register-input" placeholder="Nom" name="nom" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">
	<input required type="text" class="register-input" placeholder="Prénom" name="prenom" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">
<br/>

	<p> Etes vous de l'USTHB ?</p>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	<div class="register-switch">
	  <input type="radio" name="usthb" value="1" id="oui"
class="register-switch-input" checked>
<label for="oui" class="register-switch-label">Oui</label>

	<input type="radio" name="usthb" value="0" id="non"
class="register-switch-input">
		<label for="non" class="register-switch-label">Non</label>

	  </div>


	<input required type="text" class="register-input"
placeholder="Année d'étude" name="annee" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">
	<input required type="text" class="register-input"
placeholder="Spécialité" name="specialite" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">
	<input required type="email" class="register-input" placeholder="Email" name="email" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">
	<input required type="text" class="register-input" placeholder="N° de téléphone" name="telephone" oninvalid="this.setCustomValidity('Veuillez entrer une saisie valide')">


	<br/>

	<p> Connaissez-vous l'Open Source ? </p>
	<br/><div class="register-switch">
	<input type="radio" name="known" value=1 id="knownyes"
class="register-switch-input" >
		<label for="knownyes" class="register-switch-label">Oui</label>
	<input type="radio" name="known" value=0 id="knownno"
class="register-switch-input" checked>
		<label for="knownno" class="register-switch-label">Non</label></div>


   <br/>
	<div id="kakashi">
	<p> Votre niveau </p><br/>

	<select class="select-style" name="level" id="level">
	  <option value="0">Aucun</option>
	  <option value="1">Débutant</option>
	  <option value="2">intérmediaire</option>
	  <option value="3">Expert</option>
	</select>

	</div>
	<br/><br/>


	<p> Je viendrai le..</p>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	<div class="register-switch">
	  <input type="radio" name="coming" value="2" id="dec2"
class="register-switch-input" checked>
<label for="dec2" class="register-switch-label2">2 Décembre</label>

	<input type="radio" name="coming" value="3" id="dec3"
class="register-switch-input">
		<label for="dec3" class="register-switch-label2">3 Décembre</label>

<input type="radio" name="coming" value="2-3" id="both"
class="register-switch-input">
		<label for="both" class="register-switch-label2">Les deux</label>

	  </div>
	<br/><br/><br/>


	<p> Avez-vous déja participer à un événement de ce type ? </p><br/>
	<div class="register-switch">
	  <input type="radio" name="participated" value=1 id="partyes"
class="register-switch-input" checked>
	  <label for="partyes" class="register-switch-label">Oui</label>
	  <input type="radio" name="participated" value=0 id="partno"
class="register-switch-input">
	  <label for="partno" class="register-switch-label">Non</label>
  </div>
  <br/><br/>
		<input required name="interested" type="text" id="interested" class="register-input" placeholder="Je suis interessé(e) parce que .."><br/><br/>
  <br/><br/>
	<div class="g-recaptcha" data-sitekey="6LcqeToUAAAAAA82Chdbv0rqv51UDyVfVHEf12Q8"></div>
	<input type="submit" name="submit" value="Inscription" class="register-button" >
  </form>



</body>
</html>





<?php
if(isset($_POST)){
	$response = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => $api_secret,
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);
	if ($captcha_success->success==false) {
		$_SESSION['error'] = 'Captcha invalide.';
		header('Location: http://openmindsclub.net/registration');
	} else if ($captcha_success->success==true) {

		$email = $_POST['email'];
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			// Send an email
			$prenom = $_POST['prenom'];
			sendEmail($email,$prenom);

			// Enter in database
			$bdd=new PDO($dbname, $user, $pass);

			$req=$bdd->prepare('INSERT INTO registration (nom,prenom,annee,specialite,email,telephone,known,level,coming,participated,interested,usthb) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
			$arr['nom'] = htmlspecialchars($_POST['nom']);
			$arr['usthb'] = htmlspecialchars($_POST['usthb']);
			$arr['prenom'] = htmlspecialchars($_POST['prenom']);
			$arr['annee'] = htmlspecialchars($_POST['annee']);
			$arr['specialite'] = htmlspecialchars($_POST['specialite']);
			$arr['email'] = htmlspecialchars($_POST['email']);
			$arr['telephone'] = htmlspecialchars($_POST['telephone']);
			$arr['known'] = htmlspecialchars($_POST['known']);
			$arr['level'] = htmlspecialchars($_POST['level']);
			$arr['coming'] = htmlspecialchars($_POST['coming']);
			$arr['participated'] = htmlspecialchars($_POST['participated']);
			$arr['interested'] = htmlspecialchars($_POST['interested']);
			$res = $req->execute(array($arr['nom'], $arr['prenom'], $arr['annee'],$arr['specialite'],$arr['email'],$arr['telephone'],$arr['known'],$arr['level'],$arr['coming'],$arr['participated'],$arr['interested'],$arr['usthb']));

			//Success popup
			echo
				'<div id="overlay">
				<div class="msg success">'.
				'<div class="msg_inner success_inner">'.
				'<h2>Votre inscription a été réussie !</h2>'.
				'<p> Veuillez vérifier votre e-mail pour plus d\'informations.</p>'.
				'</div>'.
				'   </div>
				</div>';
		}else{
			$_SESSION['error'] = 'Email invalide.';
			header('Location: http://openmindsclub.net/arduino/registration');
		}
	}
}
 ?>




<!-- Script for closing "popup" -->
<script>window.onload = function (){saske=document.getElementById("overlay");
setTimeout(function(){ saske.style.display="none";}, 5000);};
</script>
