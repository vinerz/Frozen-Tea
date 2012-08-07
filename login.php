<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Site - Acesso</title>
        <link rel="stylesheet" type="text/css" href="./media/css/form.css" media="screen" title="bbxcss" />
        <link rel="stylesheet" type="text/css" href="./media/css/global.css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
        <style type="text/css">
        </style>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="./media/js/modernizr.js"></script>
        <script type="text/javascript">
        $(function() {
	        $(".submit").click(function() {
	            $("#login").submit();
	            return false;
	        });
	        
	        $("#login").keypress(function(e) {
	            if(e.keyCode == 13) $(this).submit();
	        });
	        
	                    
            if($("#userName").val() != "") $("#userPass").focus();
            else $("#userName").focus();
        });
        </script>
    </head>
    <body>
        <div style="text-align:center;margin-top:15px">
            <h1>Login Test V2</h1>
        </div>
        <div class='beautyPane'>
            <form id="login" action="./doLogin.php" method="POST">
	            <h1>Acesso</h1>
	            <?php
	            if(isset($_GET["erro"])) {
		            if($_GET["erro"] == "1") {
			            echo "<div class='errorMsg'>Usuário e/ou senha incorretos.</div>";
		            } else if($_GET["erro"] == "2") {
			            echo "<div class='errorMsg'>A conta ainda não foi verificada.</div>";
		            } else if($_GET["erro"] == "3") {
			            echo "<div class='errorMsg'>Erro ao validar sua conta.</div>";
		            } else if($_GET["erro"] == "notauthorized") {
			            echo "<div class='errorMsg'>Você precisa estar logado para acessar esta página.</div>";
		            } else {
			            echo "<div class='errorMsg'>Erro desconhecido!</div>";
		            }
	            }

	            if(isset($_GET["msg"])) {
		            if($_GET["msg"] == "desconectado") {
			            echo "<div class='successMsg'>Logout efetuado com sucesso. Tchau!</div>";
		            } else if($_GET["msg"] == "signupsuccess") {
			            echo "<div class='successMsg'>Sua conta foi criada. Para utilizá-la, por favor verifique sua caixa de e-mails e siga com as informações contidas no e-mail que enviamos à você.</div>";
		            } else if($_GET["msg"] == "validatesuccess") {
			            echo "<div class='successMsg'>Sua conta foi verificada. Agora você já pode efetuar o acesso.</div>";
		            } else {
			            echo "<div class='errorMsg'>Comando desconhecido!</div>";
		            }
	            }
	            ?>
	            <p>
		            <label for="userName">E-mail</label>
		            <input type="text" name="userName" id="userName" placeholder="Ex: nome@site.com" />
	            </p>
	            
	            <p>
		            <label for="userPass">Senha</label>
		            <input type="password" name="userPass" id="userPass" placeholder="Sua senha" />
	            </p>
	            
	            <p>
		            <a class="submit" href="#acessar">Acessar</a> ou <a href="./cadastro.php">registrar-se</a>.<br /><br />
		            <a href="./forgot.php">Esqueceu sua senha?</a>
	            </p>
            </form>
        </div>
        <br />
        <p id="footer">&copy;2012 Site</p>
    </body>
</html>
