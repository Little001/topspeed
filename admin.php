<!-- After POST -->
<?php
session_start();

	if (isset ($_POST["login_user"])) {
		if ($_POST['login_name'] !== '' || $_POST['pass'] !== '') {
            if ($_POST['login_name'] == 'olinadmin' && $_POST['pass'] == 'oldovoheslo') {
                $_SESSION['login_user'] = $_POST['login_name'];
                unset($_POST['login_name']);
                unset($_POST['pass']);
                header('Location: adminReservation.php');
            }
		}
    }

    if(isset($_POST["logout_user"])){
		unset($_SESSION['login_user']);
		header('Location: admin.php');
	}
?>		

<?php 
	if (!isset($_SESSION['login_user'])) {
?>
<div class="arrow-div">
	<form id="login_user" method="POST" action="" enctype="multipart/form-data">
		<div class="login_line">
			<div class="login_main">Přihlašte se!</div>
			<div class="login_close"><span class="fa fa-times-circle"></span></div>
		</div>
		<div class="dialog-item">
			<div class="icon-login"><span class="fa fa-user"></span></div>
			<input type="text" name="login_name" id="login_name" placeholder="Uživatelské jméno"/>
		</div>
		<div class="dialog-item">
			<div class="icon-login"><span class="fa fa-lock"></span></div>	
			<input type="password" name="pass" id="login_pass" placeholder="Vaše heslo"/>
		</div>
		<input type="submit" name="login_user" id="login_button" value="Přihlásit" />
	</form>	
</div>
<?php 
	} else {
        header('Location: adminReservation.php');
    }
?>