<?php

	//funcao para converter a data vinda da tabela no formato yyyy-mm-dd
	function convertDate($date){
		$exploded = explode("-",$date);
		$year = $exploded[0];
		$month = $exploded[1];
		$day = $exploded[2];
		
		$date = $day . "/" . $month . "/" . $year;
		return $date;
	}
	
	//funcao para converter a data para o formato yyyy-mm-dd do banco de dados
	function convertDateToBDFormat($date){
		$exploded = explode("/",$date);
		$day = $exploded[0];
		$month = $exploded[1];
		$year = $exploded[2];
		
		$date = $year . "-" . $month . "-" . $day;
		return $date;
	}
	
	
?>