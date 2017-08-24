
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
			
		  	echo "</div>";//div end
		?>
		  
		  
		  
		<center>
			<h1 id="title_one"> International Search: Gr&aacute;fico </h1>
		</center>
		
		
		<br><!--quebra de linha-->
		
		
		<div id="area_one">
		
			<form id="form" name="form" method="post" action="grafico.php">
			
				<div>
					<p class="align_text">Tipo:</p>
					<select name="button_select" id="button_select" required>
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
					
					
					
						
					?>
					
					<script>
						selecionar("<?=$rectipo?>");//definindo o valor da tabela para envia-los por post caso seja solicitado novamente
						document.form.selecione_data_ini.value= "<?=$recdatainit?>";
						document.form.selecione_data_final.value= "<?=$recdatafinal?>";
					</script>
					
					<?php
						$recdatainit=convertDateToBDFormat($recdatainit);//convertendo a data inicial para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
						$recdatafinal=convertDateToBDFormat($recdatafinal);//convertendo a data final para o formato yyyy-mm-dd para poder ser comparada com datas do banco de dados
					
					
						//selecionando datas da tabela compra para a pesquisa
						$select_data_compra = "select * from bd_compra where data between date('$recdatainit') and date('$recdatafinal')";
						$result_select_data_compra = mysqli_query($connector, $select_data_compra);
						
						while($row_select_data_compra=mysqli_fetch_array($result_select_data_compra, MYSQLI_ASSOC)){
							//selecionando dados da tabela compra
							$querycompra = "select * from bd_compra where data like '%".$row_select_data_compra["data"]."%'";//definindo o query igual ao resultado do mysqli_fetch_array row_select_data
							$resultcompra = mysqli_query($connector, $querycompra);
							
							while($rowcompra=mysqli_fetch_array($resultcompra, MYSQLI_ASSOC)){
								//convertendo as datas para exibi-las no formato dd/mm/yyyy
								$rowcompra["data"]=convertDate($rowcompra["data"]);
							}
						}
						
						//somando a quantidade total de compras na data entre a data inicial e final
						$query_qtde_compras = "select sum(quantidade) as somaqtde from bd_compra where data between date('$recdatainit') and date('$recdatafinal')";
						$result_qtde_compras = mysqli_query($connector, $query_qtde_compras);
						$cont_qtde_compras=mysqli_fetch_array($result_qtde_compras, MYSQLI_ASSOC);
						
						
						
						
						//selecionando datas da tabela venda para a pesquisa
						$select_data_venda = "select * from bd_venda where data between date('$recdatainit') and date('$recdatafinal')";
						$result_select_data_venda = mysqli_query($connector, $select_data_venda);
						
						while($row_select_data_venda=mysqli_fetch_array($result_select_data_venda, MYSQLI_ASSOC)){
							//selecionando dados da tabela venda
							$queryvenda = "select * from bd_venda where data like '%".$row_select_data_venda["data"]."%'";//definindo o query igual ao resultado do mysqli_fetch_array row_select_data
							$resultvenda = mysqli_query($connector, $queryvenda);

							while($rowvenda=mysqli_fetch_array($resultvenda, MYSQLI_ASSOC)){
								//convertendo as datas para exibi-las no formato dd/mm/yyyy
								$rowvenda["data"]=convertDate($rowvenda["data"]);
							}
						}
					
						//somando a quantidade total de vendas na data entre a data inicial e final
						$query_qtde_vendas = "select sum(quantidade) as somaqtde from bd_venda where data between date('$recdatainit') and date('$recdatafinal')";
						$result_qtde_vendas = mysqli_query($connector, $query_qtde_vendas);
						$cont_qtde_vendas=mysqli_fetch_array($result_qtde_vendas, MYSQLI_ASSOC);
						
						
						
						/*calculo de porcentagem
						valor total vt
						valor quantidade vq
						valor porcent vp ? valor procurado
						vq=vt * vp
						vp=vq / vt
						*/
						
						?>
						
						<script>
							var qtda_compras=0;
							var qtda_vendas=0;
							var qtdaall=0;
							
							var porcentcompras=0;
							var porcentvendas=0;
							
							qtda_compras=<?=$cont_qtde_compras["somaqtde"]?>;
							qtda_vendas=<?=$cont_qtde_vendas["somaqtde"]?>;
							qtdaall= (qtda_compras+qtda_vendas);
							
							porcentcompras=Math.floor((qtda_compras/qtdaall) * 100);//calculando a porcentagem de compras
							porcentvendas=Math.floor((qtda_vendas/qtdaall) * 100);//calculando a porcentagem de vendas
						</script>
						
						<?php
						if($rectipo == "compra"){
							?>
							<script>
								setbgcolordotspercentglobal('0');
								setpercentualpizza(porcentcompras);//passando o valor da porcentagem ao javascript para setar o valor no canvas do grafico em pizza
							</script>
							<?php
						}else if($rectipo == "venda"){
							?>
							<script>
								setbgcolordotspercentglobal('1');
								setpercentualpizza(porcentvendas);//passando o valor da porcentagem ao javascript para setar o valor no canvas do grafico em pizza
							</script>
							<?php
						}
						?>

						
						<div id="align">
						
							<img id="img_bg_pie" src="img/pie_bg.png">
							
							<canvas id="pizza" width="400" height="400">
								Seu browser n&atilde;o suporta canvas, abra em outro browser para visualizar o conte&uacute;do.
							</canvas>
							
							
							<div id="icon_id_compra">
								<span>Porcentagem Compra</span>
								<center><i class="fa fa-percent" id="percent_icon" aria-hidden="true"></i></center>
							</div>
							
							
							<div id="icon_id_venda">
								<span>Porcentagem Venda</span>
								<center><i class="fa fa-percent" id="percent_icon" aria-hidden="true"></i></center>
							</div>
							
							
						</div><!--align end-->
						
						
						
						<!--<div id="mascara_percentual">
							<span id="slider" class="ui-draggable" style="left: 38px; top: 0px;">drag<br>me</span>
						</div>-->
					
					<?php
					
					
					
				}//end !$_POST["button_select"]
				
			}//end !$_POST
			
		?>
				
				
	</body><!--body end-->
	
	
</html>

