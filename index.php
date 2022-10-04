<?php
    session_start();

    if(!isset($_SESSION['sacola'])){
        $_SESSION['sacola'] = array();
    }

    include_once "conexao.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body class="site">
    <header><div class="header"> E LÁ VAMOS NÓIX </div></header>

        <nav class="navbar navbar-expand navbar-dark" style="border: 6px solid rgb(59, 59, 88);; padding: 0px; font-size: 20px;">
            <div class="container-fluid">

                <a class="navbar-brand" href="#" style="font-size: 24px;">Lojinha</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/E-Commerce/">Home</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="sacola.php">Sacola</a>
                    </li>
                </ul>

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Digite algo aqui..." aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Pesquisar</button>
                </form>

                </div>
            </div>
        </nav>

        <div class="background">
            <div class="menu">
                <?php 
                    $sql = "SELECT * FROM meu_commerce.categorias WHERE categoria_pai is null";
                    $consulta = $conexao->prepare($sql);
                    $consulta->execute();

                    foreach($consulta as $linha){?>
                    <a href="?categoria=<?php echo $linha['id'];?>"><div class="item-menu"><?php echo $linha['descricao'];?></div></a>
                    <?php
                    }
                ?>
            </div>

            <div class="vitrine">
                <?php
                    if(isset($_GET['categoria'])){
                        $sql = "SELECT p.id as id_produto, p.categoria_id, p.imagem, p.descricao, p.resumo, c.categoria_pai, c.id as  id_categoria
                        FROM produtos p
                        INNER JOIN categorias c
                        ON p.categoria_id = c.categoria_pai OR p.categoria_id = c.id
                        WHERE p.categoria_id = {$_GET['categoria']} OR c.categoria_pai = {$_GET['categoria']}
                        ORDER BY RAND()";
                    }
                    else {
                        $sql = "SELECT p.id as id_produto, p.categoria_id, p.imagem, p.descricao, p.resumo FROM produtos p ORDER BY RAND()";
                    }
                    $consulta = $conexao->prepare($sql);
                    $consulta->execute();
                    
                    foreach($consulta as $linha){?>
                    
                        <div class="card" style="width: 18rem;">
                            <img src="Recursos/<?php echo $linha['imagem'];?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $linha['descricao'];?></h5>
                                    <p class="card-text"><?php echo $linha['resumo']?></p>
                                    <a href="http://localhost/E-Commerce/informacao_produto.php?id=<?php echo $linha['id_produto'];?>" class="btn btn-primary">Saber mais</a>
                                </div>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>
        

</body>
</html>