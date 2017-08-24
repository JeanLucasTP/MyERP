

var scrolling
var percent
var inttype


function debug(item){
	console.log(item)
}


function alignooncenterwidth(divdefundoparapegarlargura, divparacentralizar){
	var divimgcapacontlivrowidth = $(divdefundoparapegarlargura).width();
    var imgwidth =  $(divparacentralizar).width();
    var destwidth = divimgcapacontlivrowidth;
	var posx = (destwidth/2 - imgwidth/2);
	$(divparacentralizar).css({
		'left': posx + 'px'
	});
}


function alignooncenterheight(divdefundoparapegaraltura, divparacentralizar){
	var divimgcapacontlivroheight = $(divdefundoparapegaraltura).height();
    var imgheight =  $(divparacentralizar).height();
    var destheight = divimgcapacontlivroheight;
	var posy = (destheight/2 - imgheight/2);
	$(divparacentralizar).css({
		'top': posy + 'px'
	});
}


function geturltoredirect(url){
	document.getElementById("form").action=url;
}


function gotourltoredirect(url){//redireciona para a url passada
	window.open(url, "_self")
}


function selecionar(selectedoption)
{
	var button_select = document.getElementById("button_select");
	
	for (var i = 0; i < button_select.options.length; i++)
	{
		if (button_select.options[i].value == selectedoption)
		{
			button_select.options[i].selected = "true";
			break;
		}
	}
}


function setpercentualpizza(percentlocal){
	percent=percentlocal;
}


function isNumber(n) {//verificar se um valor se comporta como numero
  return !isNaN(parseFloat(n)) && isFinite(n);
}


function isNumeric(str) {//verificar se um valor é numero que pode aceitar numeros quebrados 
  var er = /^\d+(?:\.\d+)?$/;
  return (er.test(str));
}


function setbgcolordotspercentglobal(inttypelocal){
	inttype=inttypelocal;
}


function setbgcolordotspercent(inttype){
	var icon_id_compra=document.getElementById('icon_id_compra');
	var icon_id_venda=document.getElementById('icon_id_venda');
	
	if(inttype==0){
		if(icon_id_compra!=null && icon_id_compra!=""){
			document.querySelector('#icon_id_compra span').innerHTML = 'Porcentagem Venda';
		}
		if(icon_id_venda!=null && icon_id_venda!=""){
			document.querySelector('#icon_id_venda span').innerHTML = 'Porcentagem Compra';
		}
	}else if(inttype==1){
		if(icon_id_compra!=null && icon_id_compra!=""){
			document.querySelector('#icon_id_compra span').innerHTML = 'Porcentagem Compra';
		}
		if(icon_id_venda!=null && icon_id_venda!=""){
			document.querySelector('#icon_id_venda span').innerHTML = 'Porcentagem Venda';
		}
	}
}


function recalculatingwidthsandheights(){
	alignooncenterwidth("#align", "#img_bg_pie");
	alignooncenterwidth("#align", "#pizza");
	
	alignooncenterheight("#align", "#icon_id_compra");
	alignooncenterheight("#align", "#icon_id_venda");
	
	
	var pizza=document.getElementById('pizza');
	
	if(pizza!=null && pizza!=""){
		//alinhando os dados ao lado do canvas
		var leftfromcanvaspizza=document.getElementById('pizza').style.left;
		var rightfromcanvaspizza=document.getElementById('pizza').style.left;
		
		leftfromcanvaspizza = leftfromcanvaspizza.replace("px", "");
		rightfromcanvaspizza = rightfromcanvaspizza.replace("px", "");

		leftfromcanvaspizza = Number(leftfromcanvaspizza) - Number(60);
		rightfromcanvaspizza = Number(rightfromcanvaspizza) + Number(428);

		document.getElementById('icon_id_compra').style.left = leftfromcanvaspizza;
		document.getElementById('icon_id_venda').style.left = rightfromcanvaspizza;
	}
}


function checkscroll(){
	recalculatingwidthsandheights();
}


function widthwindow() {
	checkscroll();
	setTimeout('checkscroll()',150);
	setTimeout('checkscroll()',300);
}


$(window).resize(function(){
	widthwindow()
})




//open on ready function
$(document).ready(function(e) {
	//starting calls
	scrolling = $(this).scrollTop();
	
	recalculatingwidthsandheights();
	
	setbgcolordotspercent(inttype);
	
	
	
	//$("#button").on("click", function(){
	//	window.open('index.php', '_self');
	//})
	
	
	//datepicker BR
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	$( "#selecione_data_ini" ).datepicker({
	});
	$( "#selecione_data_final" ).datepicker({
	});

	/*$('#selecione_data_ini').on('focusout', function () {//funcao focusout > ao clicar fora do campo
		var day_init = $("#selecione_data_ini").datepicker('getDate').getDate();                 
		var month_init = $("#selecione_data_ini").datepicker('getDate').getMonth() + 1;//janeiro é o mes zero, por isso é acrescentado 1 ao valor do mes     
		var year_init = $("#selecione_data_ini").datepicker('getDate').getFullYear();
		var fullDate_init = day_init + "/" + month_init + "/" + year_init;
		//debug(fullDate_init);
	});
	
	$('#selecione_data_final').on('focusout', function () {//funcao focusout > ao clicar fora do campo
		var day_final = $("#selecione_data_final").datepicker('getDate').getDate();                 
		var month_final = $("#selecione_data_final").datepicker('getDate').getMonth() + 1;//janeiro é o mes zero, por isso é acrescentado 1 ao valor do mes     
		var year_final = $("#selecione_data_final").datepicker('getDate').getFullYear();
		var fullDate_final = day_final + "/" + month_final + "/" + year_final;
		//debug(fullDate_final);
	});*/
	//datepicker end
	
	
	//pizzacanvas
	var pizzacanvas=document.getElementById('pizza');
	
	if(pizzacanvas != null){
		
		var Pizza = {
		
		// Configuração
		canvas:pizzacanvas,
		height:400,
		width:400,
		cor:'#293F8A',

		// Calculando variaveis pra desenhar
		_init:function(){
			Pizza.ctx = Pizza.canvas.getContext("2d");  
			Pizza.radius = Math.min(Pizza.width, Pizza.height) / 2;
			Pizza.center_x = Pizza.width/2;
			Pizza.center_y = Pizza.height/2;    
		},
	 
		// Desenhando -  é só colocar Pizza._draw(60) pra desenhar 
		// o gráfico com 60% de ocupação
		_draw:function(percentual){
			Pizza.ctx.clearRect(0,0,Pizza.width,Pizza.height);          
			Pizza.ctx.beginPath();
			Pizza.ctx.moveTo(Pizza.center_x, Pizza.center_y);
			Pizza.ctx.arc( 
				Pizza.center_x, 
				Pizza.center_y, 
				Pizza.radius, 
				Math.PI * (- 0.5), // inicio da fatia
				Math.PI * (- 0.5 + 2 * percentual/100), // fim da fatia
				false
			);
			Pizza.ctx.closePath();
			Pizza.ctx.fillStyle = Pizza.cor;
			Pizza.ctx.fill();               
			}   
		}

		Pizza._init();
		
		Pizza._draw(percent);
		
		
		//slider draggable de teste
		/*$('#slider').draggable({
			containment:'#mascara_percentual',
			drag:function() {
				var left = parseInt($(this).css('left').replace('px',''));
				var percentual = parseInt(left / 350 * 100); 
				// (350 = 400 do width da mascara - 50 do width do slider)
				Pizza._draw(percentual);
			}
		});
		 
		// Iniciando em 70%
		$('#slider').css('left','70%'); // drag
		Pizza._draw(70); // canvas
		*/
		
	}
	//pizzacanvas end
	
	
	
	
	$(window).scroll(function(){
		scrolling = $(this).scrollTop()
		
		checkscroll();
		
	})
	
	
	
	
});//end of on ready

	