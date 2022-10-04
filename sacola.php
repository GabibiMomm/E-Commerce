<?php
        session_start();
    
        include "conexao.php";
        
        if(isset($_POST['esvaziar'])){
            $_SESSION['sacola'] =array();
        }

        if (isset($_POST['finalizarCompra'])) {
            $sql_insere_venda = 'INSERT into vendas (usuario_id,data_venda) values (:id, now())';
            $sql_insere_venda = $conexao->prepare($sql_insere_venda);
            $sql_insere_venda->execute(['id' => 1]);
        
            $venda_id = $conexao->lastInsertId();
        
            foreach ($_SESSION['sacola'] as $item) {
                $sql_insert_item = "
                    INSERT into vendas_produtos
                    (venda_id, produto_id, valor_venda)
                    values(:venda_id, :produto_id, (select valor from produtos where id = :produto_id ))
                ";
                $sql_insert_item = $conexao->prepare($sql_insert_item);
                $sql_insert_item->execute(['venda_id' => $venda_id, 'produto_id' => $item[0]]);
            }
            echo '<div class="alert alert-success" role="alert">
                    Pedido realizado com sucesso!
                </div>';
            $_SESSION['sacola'] =array();
        }

        if(isset($_POST['deletar'])){
            unset($_SESSION['sacola'][$_POST['posicao']]);
        }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: linear-gradient(90deg, #19164b 0%, #4e4e88 35%, #a76586 100%); font-family: Time New Roman;">
    <div class="container-sacola">
        <h1>Sacola</h1>
        <div class="vitrine-sacola">
            
        <?php $chaves = array_keys($_SESSION['sacola']);
        $total = 0;
        
        foreach ($chaves as $item){
            $sql_produto = 'SELECT * from produtos where id = :id';
            $produto = $conexao->prepare($sql_produto);
            $produto->execute(['id' => $_SESSION['sacola'][$item]]);
            $produto = $produto->fetch();

            ?><div class="card" style="width: 16rem;">
                    <img src="Recursos/<?php echo $produto['imagem'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produto['descricao'];?></h5>
                        <p class="card-text"><?php echo $produto['resumo']?></p>
                        <p>Preço: <?php echo $produto['valor']?></p>
                        <?php $total += $produto['valor']?>
                        <form method="post">
                            <input type="hidden" value='<?php echo $item ?>' name='posicao'>
                            <center><input type="submit" name="deletar" value="Remover" class="btn btn-danger"></center>
                        </form>
                    </div>
                </div>
                
        <?php }?>
        
        </div>
        <br>
        <center><h3>Preço Total: R$ <?php echo $total; ?></h3></center>
        <br>
        <form method="post">
            <input type="submit" value="Esvaziar compra(s)" name="esvaziar" class="btn btn-danger">
            <input type="submit" value="Finalizar compra(s)" name="finalizarCompra" class="btn btn-primary">
        </form>
        <br>
        <a href="http://localhost/E-Commerce/"><input type="button" class="btn btn-danger" value="Voltar"></a>
    </div>
</body>
</html>