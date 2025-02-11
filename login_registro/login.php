<?php
session_start();
?>

<style>
			#login{
				background: gray;
				border-radius: 10px;
				width: 40%;
				height: 100%;
				margin: 0px auto;
				padding: 5px;
			}
            .mensagem {
                color:red;
                text-align: center;
                margin-bottom: 10px;
            }
            .mensagem.sucesso {
                color: green;
            }
		</style>

<div id="login">
        
    <!--mensagens de erro -->
    <?php
    if(isset($_SESSION['erro'])) {
        echo "<div class = 'mensagem'> {$_SESSION['erro']} </div>";
        unset($_SESSION['erro']);
    } elseif (isset($_SESSION['sucesso'])) {
        echo "<div class = 'mensagem sucesso'> {$_SESSION['sucesso']} </div>";
        unset($_SESSION['sucesso']);
    }

    ?>



    <form action="login_codigo.php" method="POST"> 
        <center>
            <label for="email">E-mail:</label>
            <input type="text" min="0" max="200" name="email" id="email" required> 
        </center> 

        <center>
            <label for="senha">Senha:</label>
            <input type="text" min="0" max="200" name="senha" id="senha" required> 
        </center>

        <input type="submit" value="Enter">
    </form>
</div>