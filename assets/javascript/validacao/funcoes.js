$(document).ready(function() {
        
    jQuery.validator.addMethod("igual_a_nova_senha", function(value, element) {
        
	if($('#nova_senha').val() !=  value) return false;
        else return true;
        
    }, senhasDiferentes);

    jQuery.validator.addMethod("novo", function(value, element) {
       
       if($("#id").val() == '' && value == '') return false;
       
       else return true; 
       
    },required);
    
    jQuery.validator.addMethod("verifica_checkbox", function(value, element) {  
      
        var boxes = $('.checkbox');
      
        if(((boxes.filter(':checked').length == 0)) ){
            $(verifica_checkbox).show();
            return false;
        } 
        else{
            $(verifica_checkbox).hide();
            return true;        
        }
    }, "");
    
    jQuery.validator.addMethod("verifica_email", function(value, element) {
       
        var url = $("#base_url").val();
        
        url = url.replace("adm","");
        //url = url.replace("app","");
        
        url += 'adm/ajax/email'; 
        
        var resultado = false;

        $.ajax({
            url: url,
            data: 'email=' +$("#usu_email").val() +
             '&id=' + $('input[name=usu_id]').val(),
            async: false,
            type: 'POST',
            context: '',
            success: function(data){
                if(data == '0') {
                    resultado = false;
                }
                else {
                    resultado = true;
                }
            }
        }); 
        return resultado;
    
    },emailIndisponivel);
    

    
    jQuery.validator.addMethod("verifica_upload", function(value, element) {
       
       if($("#arquivo").val() == ''){
           
           $("#verifica_upload").show();
           return false;
       }
       
       else {
           $("#verifica_upload").hide();
           return true; 
       }
       
    },"");
    
    jQuery.validator.addMethod("valida_cpf", function(value, element) {

        value = value.replace('.', '');
        value = value.replace('.', '');
        cpf = value.replace('-', '');
        while (cpf.length < 11)
            cpf = "0" + cpf;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number;
        var c = 11;
        for (i = 0; i < 11; i++) {
            a[i] = cpf.charAt(i);
            if (i < 9)
                b += (a[i] * --c);
        }
        if ((x = b % 11) < 2) {
            a[9] = 0
        } else {
            a[9] = 11 - x
        }
        b = 0;
        c = 11;
        for (y = 0; y < 10; y++)
            b += (a[y] * c--);
        if ((x = b % 11) < 2) {
            a[10] = 0;
        } else {
            a[10] = 11 - x;
        }
        if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg))
            return false;
        return true;
    }, cpfInvalido);

    jQuery.validator.addMethod("valida_data", function(value, element) {

        if (value.length != 10)
            return false;

        var data = value;
        var dia = data.substr(0, 2);
        var barra1 = data.substr(2, 1);
        var mes = data.substr(3, 2);
        var barra2 = data.substr(5, 1);
        var ano = data.substr(6, 4);
        if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12)
            return false;
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31)
            return false;
        if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0)))
            return false;
        if (ano < 1900)
            return false;
        return true;
    }, dataInvalida);


    jQuery.validator.addMethod("verifica_link_banner", function(value, element) {
       
       if($("#categoria").val() == '' && $("#marca").val() == ''){
           return false;
       }
       
       else {
           
           return true; 
       }
       
    },required);
    
    jQuery.validator.addMethod("verifica_email_doador", function(value, element) {
       
        var url = $("#base_url").val();
        
        url = url.replace("adm","");
        //url = url.replace("app","");
        
        url += 'adm/ajax/email_doador'; 
        
        var resultado = false;

        $.ajax({
            url: url,
            data: 'email=' +$("#doa_email").val() +
             '&id=' + $('input[name=doa_id]').val(),
            async: false,
            type: 'POST',
            context: '',
            success: function(data){
                if(data == '0') {
                    resultado = false;
                }
                else {
                    resultado = true;
                }
            }
        }); 
        return resultado;
    
    },emailIndisponivel);
    
    jQuery.validator.addMethod("verifica_email_competidor_ws", function(value, element) {
       
        var url = $("#base_url").val();
        
        url = url.replace("ws","");
        //url = url.replace("app","");
        
        url += 'ws/ajax/email_competidor'; 
        
        
        var resultado = false;

        $.ajax({
            url: url,
            data: 'email=' +$("#email").val(),
            async: false,
            type: 'POST',
            context: '',
            success: function(data){
                if(data == '0') {
                    resultado = false;
                }
                else {
                    resultado = true;
                }
            }
        }); 
        return resultado;
    
    },emailIndisponivel);
    
    $.validator.addMethod('positiveNumber',
        function (value) {
            if(value == ''){
                return true;
            }
            else{
                return Number(value) > 0;
            }
    }, numeroPositivo);

});