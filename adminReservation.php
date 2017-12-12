<?php 
session_start();
	if(isset($_SESSION['login_user'])) {
?>
kalendaaař!
<form id="logout" method="POST" action="admin.php" enctype="multipart/form-data">
    <input type="submit" name="logout_user" id="logout_user" value="Odhlásit" />
</form>	    
<?php 
    } else {
        header('Location: admin.php');
    }
?>