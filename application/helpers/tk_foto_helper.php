<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Helpers para trabalhar com a foto do usuario
 * 
 * @package   helpers
 * @name      tk_foto_helper 
 * @author    Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     21/05/2013
 */

/**
 * Busca o nome da foto do usuario no banco
 * 
 * @name   _foto
 * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @since  21/05/2013
 * @params array $dados array com os dados a serem inseridos
 * @return string Nome da foto do usuario
 * 
 */
if ( ! function_exists('_foto'))
{
	function _foto()
	{

            $CI = & get_instance();
            $CI->load->model($CI->config->item('admin') . 'usuario_model');
            $usuario_atualizado = $CI->usuario_model->get_by_id($CI->session->userdata('usuario_id'),FALSE);
            
            if($usuario_atualizado) $data['foto'] = $usuario_atualizado->foto;
            else $data['foto'] = '';
            
            if($data['foto'] == $CI->config->item('foto_default')) {
                
                $data['foto'] = $CI->config->item('url_arquivos_default') . $data['foto'];
            }
            else {
                
                if($CI->session->userdata('login_admin') == TRUE) {
                    
                    $data['foto'] = $CI->config->item('url_arquivos_admin_usuarios') . $data['foto'];
                }
                else {
                    
                    $data['foto'] = $CI->config->item('url_arquivos_app') . _app_id() . '/' . $CI->config->item('url_usuarios_app') . $data['foto'];
                }
            }
            
            return $data['foto'];
            
	}
}

/**
 * Busca o nome da foto do usuario no banco
 * 
 * @name   _foto_competidor
 * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @since  04/08/2015
 * @params void
 * @return string Nome da foto do competidor
 * 
 */
if ( ! function_exists('_foto_competidor'))
{
    function _foto_competidor()
    {

        $CI = & get_instance();

        $CI->load->config('arquivo');

        $CI->load->model($CI->config->item('ws') . 'competidor_model');

        $competidor = $CI->competidor_model->get_by_id($CI->session->userdata('id'));

        $foto = $CI->config->item('competidor_url') . $competidor->foto;

        if(!file_exists($foto) || $competidor->foto == NULL) {

            $CI->load->helper('gravatar_helper');

            $foto = gravatar($competidor->email, array('s' => 150, 'd' => 'identicon'));
        }
        else {
            $foto = base_url($foto);
        }

        return $foto;
    }
}

if ( ! function_exists('_imagem_existe'))
{
	function _imagem_existe($uri)
	{

            return (@fclose(@fopen($uri, 'r'))) ? true : false;
            
	}
}

/**
 * Retorna a url do logotipo do condominio
 * Se o condominio nao possuir um logotipo mostra o logotipo default
 * 
 * @name   _logo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  26/08/2013
 * @return string url do logotipo do condominio
 * 
 */
if ( ! function_exists('_logo')) {
    
    function _logo() {

        $CI = & get_instance();

        $imagens = $CI->config->item('url_arquivos_app') . _app_id() . '/' . $CI->config->item('url_imagens_app');
        
        if (is_dir($imagens)) {

            $diretorio = dir($imagens);
            $logotipo = '';

            while ($arquivo = $diretorio->read()) {

                if (substr($arquivo, 0, 5) == 'logo.') {

                    $logotipo = $arquivo;
                    break;
                }
            }
            $diretorio->close();

            if ($logotipo != '') {

                $logotipo = $imagens . '/' . $logotipo;
            } else {

                $logotipo = $CI->config->item('url_arquivos_default') . 'logo_default.jpg';
            }
        } else {

            $logotipo = $CI->config->item('url_arquivos_default') . 'logo_default.jpg';
        }
        return base_url($logotipo);
    }
}

/**
 * Redimensiona imagem
 * 
 * @name   _redimensionar
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  06/08/2013
 * @params imagem $imagem
 * @param  int $largura
 * @param  int $altura
 * @param  bool $miniatura
 * @return imagem redimensionada
 * 
 */
if ( ! function_exists('_redimensionar'))
{
	function _redimensionar($imagem, $largura, $altura, $miniatura = TRUE)
	{

            $CI = & get_instance();
            
            $CI->load->library('image_lib');
            
            $CI->image_lib->clear();
            
            $config['image_library'] = 'gd2';
            $config['source_image']  = $imagem;
            $config['create_thumb']  = $miniatura;
            $config['maintain_ratio']= TRUE;
            $config['width']         = $largura;
            $config['height']        = $altura;
            
            $CI->image_lib->initialize($config);
            
            return $CI->image_lib->resize();
            
	}
}

/**
 * Verifica se existe uma imagem com o nome informado e qual o formato da imagem (gif,jpg,png)
 * 
 * @name   _verifica_extensao
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  06/08/2013
 * @params string $image_path Caminho da imagem
 * @return string Caminho da imagem com a extensao do arquivo
 *         bool Retorna FALSE se nao encontrar a imagem
 */
if ( ! function_exists('_verifica_extensao'))
{
	function _verifica_extensao($image_path)
	{

            $CI = & get_instance();
            
            $CI->load->config('imagem');
            
            $config_imagem = $CI->config->item('imagem');
            
            $formatos_permitidos = explode('|',$config_imagem['allowed_types']);
            
            // Itera sobre os formatos de imagem permitidos procurando o formato da imagem informada
            foreach ($formatos_permitidos as $f){
                
                $nome = $image_path . '.' . $f;
                
                if(file_exists($nome)){
                    
                    return $nome;
                }
            }
            
            return FALSE;
	}
}

?>