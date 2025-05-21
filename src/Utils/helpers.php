<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}  

//var_dunmp
function dd($data){
    var_dump($data);
    die;
}

//verificar permissao de usuario
function userPermission($permissao_nome){
    $permissoes = $_SESSION['permissoes'];

    foreach($permissoes as $permissao){
        if($permissao->nome == $permissao_nome){
            return true;
        }
    }

    return false;
}

//enviar imagem para o servidor
function createFile($arquivo, $dir, $type){
    if(empty($arquivo['name']) || empty($arquivo['tmp_name'])){
        return null;
    }

    $allowedImages = ['image/jpeg', 'image/png', 'image/svg*xml', 'image/webp'];
    $allowedVideos = ['video/mp4', 'video/ogg', 'video/webm', 'video/x-matroska'];

    if($type == 'image' && !in_array($arquivo['type'], $allowedImages)){
        return null;
    }

    if($type == 'video' && !in_array($arquivo['type'], $allowedVideos)){
        return null;
    }

    $root_dir = rtrim($_SERVER['DOCUMENT_ROOT'] . '/public' . $dir, "/") . '/';

    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

    $nome_original = pathinfo($arquivo['name'], PATHINFO_FILENAME);
    

    $arquivo_nome = uniqid() . "_" . time() . "." . $extensao;
    
    if(!is_dir($root_dir)){
        if(!mkdir($root_dir, 0755, true)){
            return null;
        }
    }

    $destino = $root_dir . $arquivo_nome;

    if(move_uploaded_file($arquivo['tmp_name'], $destino)){
        return [
            'nome_original' => $nome_original,
            'arquivo_nome' =>$arquivo_nome,
            'diretorio' => $destino,
        ];
    }

    return null;
}

function removeFile($arquivo, $dir){
    $path = rtrim($_SERVER['DOCUMENT_ROOT'] . '/public' . $dir, "/") . '/' . $arquivo;

    if(file_exists($path)){
        unlink($path);

        return true;
    }

    return false;
}

