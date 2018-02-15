<?php 
session_start();
	if(isset($_SESSION['login_user'])) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- JQUERY -->
        <script src="JS/jquery.min.js"></script>
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="Bootstrap/css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="Bootstrap/js/moment.js"></script>
        <script src="Bootstrap/js/bootstrap.min.js"></script>
        <script src="Bootstrap/js/datepicker.js"></script>
        <link rel="stylesheet" href="Bootstrap/css/datepicker.min.css" />
        <link rel="stylesheet" href="Bootstrap/css/datepicker3.min.css" />
        
        <!-- CSS -->
        <link rel="stylesheet" href="CSS/datepicker.css"/>
        <link rel="stylesheet" href="CSS/loader.css"/>
        <!-- JS -->
        <script src="JS/admin/scripts.js"></script>
    </head>
    <body>
        <div id="datepicker" class="datepicker"></div>
        <button id="save">SAVE</button>
        <form id="logout" method="POST" action="admin.php" enctype="multipart/form-data">
            <input type="submit" name="logout_user" id="logout_user" value="Odhlásit" />
        </form>
        <div class="loaderWrapper">
            <div class="loader"></div>
        </div>
    </body>
</html>

<?php 
    } else {
        header('Location: admin.php');
    }
?>