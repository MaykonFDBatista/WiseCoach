<div class="panel panel-default">
    <div class="panel-body">
        <?php 
        $flag = 0;
        foreach ($competidor_badges as $i => $badge): 
            
            if($flag == 0){
                echo '<div class="row-fluid">';
                $flag = 1;
            }
            ?>
            
            <div class="col-xs-4 img-thumbnail">
                <div class="row-fluid">
                    <div class="col-md-4">
                        <?php 
                        $img = $badge->nome;
                        $descricao = $badge->descricao;
                        if(empty($badge->concedido)){
                            $img = 'error.png';
                            $descricao = '<strike class="text-muted">' . $descricao . '</strike>';
                        }
                        
                        echo img(array('src' => $this->config->item('badge_url') . $img));
                        ?>            
                    </div>
                    <div class="col-md-8">
                        <?php echo $descricao;?>        
                    </div>
                </div>
            </div>
        <?php 
        if($i%3 == 0){
            echo '</div>';
            $flag = 0;
        }
        
        endforeach;
        
        if($flag == 1){
            echo '</div>';
        }
        ?>
    </div>
</div>
