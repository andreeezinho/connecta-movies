<h1>filmes</h1>

<form action="/filmes/cadastro" method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" id="nome">
    <textarea name="descricao" id="descricao"></textarea>
    <input type="file" name="imagem" id="imagem">
    <input type="file" name="banner" id="banner">
    <input type="file" name="filme" id="filme">

    <button type="submit">Enviar</button>
</form>

<h1>OLHA O VIDEO DO FILME AQUI</h1>

<?php
    foreach($filmes as $filme){
?>
    <video controls width="250">
        <source src="/public/conteudos/filmes/<?= $filme->path ?>" type="video/webm" />
    </video>
<?php
    }
?>