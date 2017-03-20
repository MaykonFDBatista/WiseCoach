$(document).ready(function(){
    
//    if($('.btn_facebook_login').length) {
//        
//        $(document).on('click','.btn_facebook_login',function(e){
//        
//            e.preventDefault();
//            
//            var url = $(this).attr('data-href');
//            
//            $.ajax({
//                url: url,
//                async: false,
//                type: 'POST',
//                context: '',
//                dataType: 'json',
//                success: function(data){
//                    
//                    if(data.user){
//                        
//                        window.location = $('input[name="url_logado"]').val();
//                        
//                    }
//                    else {
//                        
//                        window.location = data.url_login;
//                    }
//                }
//            });
//        });
//    }
//    
//    if($('.btn_login').length) {
//        
//        $(document).on('click','.btn_login',function(e){
//        
//            e.preventDefault();
//            
//            var url = $(this).attr('data-href');
//            
//            var btn = $(this);
//            
//            $.ajax({
//                url: url,
//                async: true,
//                type: 'POST',
//                context: '',
//                dataType: 'json',
//                data: { email : $('input[name="email"]').val(), senha: $('input[name="senha"]').val() },
//                success: function(data){
//                    
//                    if(data.user){
//                        
//                        window.location = $('input[name="url_logado"]').val();
//                        
//                    }
//                    else {
//                        
//                        $.each(btn.closest('form').find('.msgBox'),function(){
//                            $(this).show();
//                        });
//                    }
//                }
//            });
//        });
//    }
    
//    if($('.btn_cadastro').length){
//       $(document).on('click','.btn_cadastro',function(){
//        
//           $('.campos_cadastro').show();
//           $('.btn_login').hide();
//           $('.btn_facebook_login').hide();
//       });
//        
//    }
    
});