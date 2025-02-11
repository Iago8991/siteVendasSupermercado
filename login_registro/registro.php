<?php
session_start();
?>

<style>
			#registro{
				background: gray;
				border-radius: 10px;
				width: 40%;
				height: 100%;
				margin: 0px auto;
				padding: 5px;
			}
            .mensagem{
                color: red;
                text-align: center;
                margin-bottom: 10px;
            }
            .mensagem.sucesso{
                color:green;
            }
		</style>

<div id="registro">
    <?php
        if(isset($_SESSION['error'])) {
            echo "<div class = 'mensagem'> {$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['sucesso'])) {
            echo "<div class = 'mensagem sucesso'> {$_SESSION['sucesso']} </div>";
            unset($_SESSION['sucesso']);
        }
            
    ?>
    <form action="registro_codigo.php" method="POST"> 

        <center>
            <label for="nome">NOME:</label>
            <input type="text" min="0" max="200" name="nome" id="nome"> 
        </center>
        
        <center>
            <label for="email">E-mail:</label>
            <input type="text" min="0" max="200" name="email" id="email"> 
        </center>

        <center>
            <label for="senha">Senha:</label>
            <input type="text" min="0" max="200" name="senha" id="senha"> 
        </center>
        <input type="submit" value="Enter">
    </form>
</div>