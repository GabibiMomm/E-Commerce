<?php 
    session_start();

    include_once "conexao.php";

    $sql = "SELECT * FROM produtos where id = {$_GET['id']}";
    $consulta = $conexao->prepare($sql);
    $consulta->execute();

    if(isset($_POST['adicionar'])){
        array_push($_SESSION['sacola'], $_GET['id']);
        //print_r($_SESSION['sacola']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informação</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <?php foreach($consulta as $linha){ ?>
        <div class="container-local">
            <div class="vitrine_produto">
                <div class="container-imagem">
                    <img src="Recursos/<?php echo $linha['imagem']?>">
                </div>

                <div class="informacao_produto">
                    <br>
                    <h1><?php echo $linha['descricao'];?></h1>
                    <br><br>
                    <h2>Valor</h2>
                    <h3>R$ <?php echo $linha['valor'];?></h3>
                    <br><br>
                    <h2>Resumo</h2>
                    <h3><?php echo $linha['resumo'];?></h3>
                    <br><br>
                    <h2>Características</h2>
                    <h4><?php echo $linha['caracteristicas']?></h4>
                    <br><br>
                    <form method="post">
                        <input type="submit" value="Adicionar na Sacola" class="btn btn-primary" name="adicionar">
                    
                    <a href="http://localhost/E-Commerce/"><input type="button" class="btn btn-danger" value="Voltar"></a>
                
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>