<?php
		//Chamando o arquivo de conexao com o banco
		require_once("conexao.php");	
		
		
		//Esse IF verifica se o formulário foi submitado
		if(isset($_POST['nome']) && !empty($_POST['nome']))
		{	
			$nome = $_POST['nome']; //Pegando o campo nome do formulário
			$mensagem = $_POST['mensagem']; //Pegando o campo mensagem do formulário
			
			$sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, texto = :texto, data_msg = NOW()"); //Inserindo os dados na tabela do banco
			$sql->bindValue(":nome", $nome); //Passando para a query o campo nome do formulário
			$sql->bindValue(":texto", $mensagem);  //Passando para a query o campo mensagem do formulário
			$sql->execute(); //Executando a query
			
			header("Location: index.php"); //Esse header é colocado para evitar o reenvio de script que aparece na página
			
		}
		
?>	

<fieldset>	
	<!-- Formulário que envia os dados para o banco de dados -->
	<form method="POST">
		Nome:<br>
		<input type="text" name="nome" /> <br><br>
		
		Mensagem:<br>
		<textarea name="mensagem"></textarea><br><br>
		
		<input type="submit" value="Enviar Mensagem">
		
	</form>
	
</fieldset>

<br><br>

<?php
	//Consulta que preenche a área da página com as mensagens que estão no banco de dados
	$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
	$sql = $pdo->query($sql);
	
	//Esse IF verifica se foi reternado algum dado da consulta no banco
	if($sql->rowCount() > 0)
	{
		//Foreach que pegar cada registro da consulta e exibe na tela (ou seja, a mensagem e a data)
		foreach($sql->fetchAll() as $mensagem):
		?>
			<strong><?php echo $mensagem['nome']; ?></strong> - <?php echo date('d/m/y H:i:s', strtotime($mensagem['data_msg'])); ?><br>
			<?php echo $mensagem['texto']; ?>
			<hr/>
		<?php
		endforeach;		
	}
	else
	{
		echo "Não há mensagens.";
	}
?>

