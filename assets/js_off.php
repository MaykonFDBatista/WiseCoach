<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="../templates/tellknologia/css/main.css" rel="stylesheet" type="text/css">

<title>Tellks Condomínio</title>

<?php 
$anterior = '../';

if (isset($_SERVER['HTTP_REFERER'])){
$anterior = $_SERVER['HTTP_REFERER'];
}

?>

</head>

<body class="no-background">
    
        <!-- Fixed top -->
	<div id="top">
		<div class="fixed">
			<a href="../index.html" title="" class="logo"><img src="../templates/tellknologia/img/logo.png" alt="" /></a>
		</div>
	</div>
	<!-- /fixed top -->
        
	<!-- Error wrapper -->
	<div class="error-page">
	    <span class="reason">Javascript</span>
            <h1 class="">desabilitado em seu navegador</h1>
		<div class="error-content">
	        <span class="reason-title muted"> 
                    <p> Esta página utiliza códigos javascript para funcionar corretamente. </p>
                    <p> Habilite o uso de javascript e recarregue a página para continuar.</p><br>
                    <p><a href="<?php echo $anterior;?>">Tentar novamente</a></p>
                </span>
	    </div>
	</div>  
	<!-- /error wrapper -->


	<!-- Footer -->
	<div id="footer">
	</div>
	<!-- /footer -->

</body>
</html>
