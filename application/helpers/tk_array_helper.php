<?php

function object_to_array($ob, $numeric = FALSE) {
    if ($numeric === TRUE) { //verifica se $numeric foi passado como true
        $arr = get_object_vars($ob); //coloca todas as propriedades do objeto em uma array associativa
        for ($i = 0; $i < count($arr); $i++) { //loop for simples para trocar os índices da array
            $arr2[$i] = $arr[key($arr)]; //troca o indice associativo por um numerico
            next($arr); //avança o ponteiro do array
        }
        return $arr2; //retorna a array numerica
    } else {
        return get_object_vars($ob); //retorna array associativa
    }
}

function array_to_object($arr) {
    $ob = new stdClass; //cria um novo objeto std, a classe stdClass é padrão no PHP e cria uma classe vazia, ela é usada por funções internas como o mysql_fetch_object
    for ($i = 0; $i < count($arr); $i++) { //loop para criar as variaveis no objeto
        $obVar = key($arr); //pega o índce da array associativa
        $ob->$obVar = $arr[key($arr)]; //cria uma propriedade com o nome do índice do array
        next($arr); //avança o ponteiro do array
    }
    return $ob; //retorna o objeto criado
}



function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

?>