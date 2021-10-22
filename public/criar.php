<?php
    require('../app/DataBase.php');

    $DataBase = new DataBase();
    $sql = "SELECT * FROM editora where id > :id";
    $binds = ['id' => 0];
    $resultEditoras = $DataBase->select($sql, $binds);
    if ($resultEditoras->rowCount() > 0)
    {
        $editoras = $resultEditoras->fetchAll(PDO::FETCH_OBJ);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title></title>
    </head>
    <body>
        <div class="container mt-4">
            <form method="post">
                <h3 class="mb-3">Cadastro de Título</h3>
                <div class="mb-2 mt-3">
                    <a href="index.php" class="btn btn-secondary btn-sm">Voltar</a>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Titulo</label>
                    <input class="form-control" type="text" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Editora</label>
                    <select class="form-select" name="editora" id="">
                        <?php 
                            foreach ($editoras as $editora) 
                            {
                                echo "<option value='{$editora->id}'>{$editora->nome}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Autor</label>
                    <input class="form-control" type="text" name="autor" required>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Ano</label>
                    <input class="form-control" type="text" name="ano" required>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Preco</label>
                    <input class="form-control" type="text" name="preco" required>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Quantidade</label>
                    <input class="form-control" type="text" name="quantidade" required>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-0">Tipo</label>
                    <input class="form-control" type="text" name="tipo" required>
                </div>
                
                <button class="btn btn-primary" type="submit">Salvar</button>
            </form>
            <?php
                $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
                $idEditora = filter_input(INPUT_POST, 'editora', FILTER_SANITIZE_STRING);
                $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_STRING);
                $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);
                $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_STRING);
                $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_STRING);
                $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
                
                if (!empty($titulo) && !empty($editora) && !empty($autor) && !empty($ano) && !empty($preco) && !empty($quantidade) && !empty($tipo))
                {
                    $DataBase = new DataBase();
                    $binds = ['titulo' => $titulo, 'idEditora' => $idEditora, 'autor' => $autor, 'ano' => $ano, 'preco' => $preco, 'quantidade' => $quantidade, 'tipo' => $tipo];
                    $sql = "INSERT INTO acervo SET titulo = :titulo, idEditora = :idEditora, autor = :autor, ano = :ano, preco = :preco, quantidade = :quantidade, tipo = :tipo";

                     $result = $DataBase->insert($sql, $binds);
                    if($result)
                    {
                        echo "<div class='alert alert-success mt-2'>Cadastro realizado com sucesso!</div>";
                        header("Location: http://localhost/controledeacervo/public/index.php");
                        exit();
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'>Houve um erro interno!</div>";
                    }
                }
            ?>
        </div>
    </body>
</html>