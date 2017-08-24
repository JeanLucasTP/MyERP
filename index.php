
<html>
	<head>
	
	    <meta charset="utf-8">
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
        <title>International Search : Gr&aacute;fico</title>
		<link type="image/png" href="img/icon-top.png" rel="icon">
		
		
		<link type="text/css" href="css/style.css" rel="stylesheet" >
		
		<script src="jquery/jquery.js"></script>

		<script src="jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
		
		<link type="text/css" href="font-awesome/css/font-awesome.css" rel="stylesheet">
		
		<script src="javascript/script.js"></script>
		
	</head>
	
	
	<body>
	
	
		<?php
			echo "<div style='height:0px;widht:0px';>";//zerando a altura
			
				include("connector.php");
				include("convertdate.php");
				
				$sqlcompra = "CREATE TABLE IF NOT EXISTS bd_compra (
					id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					data VARCHAR(254) NOT NULL,
					descricao VARCHAR(254) NOT NULL,
					valor VARCHAR(254) NOT NULL,
					tipo VARCHAR(254) NOT NULL
				)";
				
				$sqlvenda = "CREATE TABLE IF NOT EXISTS bd_venda (
					id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					data VARCHAR(254) NOT NULL,
					descricao VARCHAR(254) NOT NULL,
					valor VARCHAR(254) NOT NULL,
					tipo VARCHAR(254) NOT NULL
				)";
				
				if ($connector->query($sqlcompra) === TRUE) {
					//echo "Table bd_compra created successfully";
				} else {
					//echo "Error creating table: " . $connector->error;
				}
				if ($connector->query($sqlvenda) === TRUE) {
					//echo "Table bd_compra created successfully";
				} else {
					//echo "Error creating table: " . $connector->error;
				}
				
				
			echo "</div>";//div end
		?>
		 
		  
		<center>
			<h1 id="title_one"> International Search: Fluxo de Caixa </h1>
		</center>
		
		
		<br><!--quebra de linha-->
		
		
		<div id="area_one">
		
			<form id="form" name="form" method="post" action="index.php">
			
				<div>
					<p class="align_text">Tipo:</p>
					<select name="button_select" id="button_select" value="" required>
						<option value="">Selecione</option>
						<option value="compra">Compra</option>
						<option value="venda">Venda</option>
					</select>
				</div><!--div end-->
				
					
				<div>
					<p class="align_text2">Data Inicial:</p>
					<input name="selecione_data_ini" type="text"id="selecione_data_ini" placeholder="Selecione a data inicial" value="" required>
					<p class="align_text3">Data Final:</p>
					<input name="selecione_data_final" type="text"id="selecione_data_final" placeholder="Selecione a data final" value="" required>
				</div><!--div end-->
				
				
				<div>
					<button id="search" name="search" onclick="geturltoredirect('index.php')" type="submit">Pesquisar 
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
					
					<button id="grafic_generate" name="grafic_generate" onclick="geturltoredirect('grafico.php')" type="submit">Gerar Gr&aacute;fico 
						<i class="fa fa-pie-chart" aria-hidden="true"></i>
					</button>
				</div><!--div end-->
			
			</form><!--form end-->
			
		</div><!--area_one end-->
		
		
		
		
		
		<?php
			
			
			if($_POST){
			
				if($_POST["button_select"]){
				
					//recebendo os valores para pesquisa
					$rectipo=$_POST["button_select"];//o tipo da busca, compra ou venda
					
					$recdatainit=$_POST["selecione_data_ini"];//a data inicial
					$recdatafinal=$_POST["selecione_data_final"];//a data final
					
					if($rectipo == "compra"){
						
					?>
							
						<script>
							selecionar("<?=$rectipo?>");//definindo o valor da tabela para envia-los por post caso seja solicitado novamenteo
							document.form.selecione_data_ini.value= "<?=$recdatainit?>";
							document.form.selecione_data_final.value= "<?=$recdatafinal?>";
						</script>
						
						<?php
							$recdatainit=convertDateToBDFormat($recdatainit);//convertendo a data inicial para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
							$recdatafinal=convertDateToBDFormat($recdatafinal);//convertendo a data final para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
						?>
				
						<table id="table_one" align="center"><!--crando o cabeçalho da tabela para compra-->
						
							<tr>
								<th>Data</th>
								<th>Descri&ccedil;&atilde;o</th>
								<th>Valor</th>
								<th>Tipo</th>
								<th>Quantidade</th>
							</tr>
						
							<?php
							
								
							//selecionando datas da tabela para a pesquisa
							$select_data = "select * from bd_compra where data between date('$recdatainit') and date('$recdatafinal')";
							$result_select_data = mysqli_query($connector, $select_data);
							
							while($row_select_data=mysqli_fetch_array($result_select_data, MYSQLI_ASSOC)){
								
								$query = "select * from bd_compra where data like '%".$row_select_data["data"]."%'";//definindo o query igual ao resultado do mysqli_fetch_array row_select_data
								$result = mysqli_query($connector, $query);

								while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
								
									//convertendo as datas para exibi-las no formato dd/mm/yyyy
									$row["data"]=convertDate($row["data"]);
								
									?>
							
									<tr>
										<td><?=$row["data"]?></td>
										<td><?=$row["descricao"]?></td>
										<td><?=$row["valor"]?></td>
										<td><?=$row["tipo"]?></td>
										<td><?=$row["quantidade"]?></td>
									</tr>
								
									<?php
								
								}//fechando o query $row
							
							}//fechando o query $row_select_data
						
						?>
								
								
						</table><!--table_one end-->
		
		<?php
					
					
					}//end rectipo == "compra"
					else if($rectipo == "venda"){
						
					?>
					
					<script>
						selecionar("<?=$rectipo?>");//definindo o valor da tabela para envia-los por post caso seja solicitado novamente
						document.form.selecione_data_ini.value= "<?=$recdatainit?>";
						document.form.selecione_data_final.value= "<?=$recdatafinal?>";
					</script>
					
					<?php
						$recdatainit=convertDateToBDFormat($recdatainit);//convertendo a data inicial para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
						$recdatafinal=convertDateToBDFormat($recdatafinal);//convertendo a data final para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
					?>
					
						
					<table id="table_one" align="center"><!--crando o cabeçalho da tabela para compra-->
					
						<tr>
							<th>Data</th>
							<th>Descri&ccedil;&atilde;o</th>
							<th>Valor</th>
							<th>Tipo</th>
							<th>Quantidade</th>
						</tr>
					
						<?php
						
						
						//selecionando datas da tabela para a pesquisa
						$select_data = "select * from bd_venda where data between date('$recdatainit') and date('$recdatafinal')";
						$result_select_data = mysqli_query($connector, $select_data);
						
						while($row_select_data=mysqli_fetch_array($result_select_data, MYSQLI_ASSOC)){
							
							$query = "select * from bd_venda where data like '%".$row_select_data["data"]."%'";//definindo o query igual ao resultado do mysqli_fetch_array row_select_data
							$result = mysqli_query($connector, $query);

							while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
							
								//convertendo as datas para exibi-las no formato dd/mm/yyyy
								$row["data"]=convertDate($row["data"]);
							
								?>
						
								<tr>
									<td><?=$row["data"]?></td>
									<td><?=$row["descricao"]?></td>
									<td><?=$row["valor"]?></td>
									<td><?=$row["tipo"]?></td>
									<td><?=$row["quantidade"]?></td>
								</tr>
							
								<?php
							
							}//fechando o query $row
						
						}//fechando o query $row_select_data
					
					?>
							
							
					</table><!--table_one end-->	
						
					
					<?php
					
					}
					
					
				}//if($_POST["button_select"]){
				
				
			}//if($_POST){
				else
			{
				
				?>
				
				<table id="table_one" align="center"><!--crando tabela para compra-->
				
					<tr>
						<th>Data</th>
						<th>Descri&ccedil;&atilde;o</th>
						<th>Valor</th>
						<th>Tipo</th>
						<th>Quantidade</th>
					</tr>
					
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				
				</table><!--table_one end-->
				
				<?php
			
			}//end !$_POST
		
		?>
		
		
	
	</body>
	
	
</html>
	