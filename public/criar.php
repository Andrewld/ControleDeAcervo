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
        <link href="css/style.css" rel="stylesheet">
        <title>Cadastro de Título</title>
    </head>
    <body>
        <div class="corpo-da-pagina">
            <form method="post">
                <h3>Cadastro de Título</h3>
                <div class="botao-voltar">
                    <a href="index.php" class="btn btn-cinza btn-pequeno">Voltar</a>
                </div>
                <label>Titulo</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="titulo" required>
                </div>
                <div class="grupo-de-select">
                    <label>Editora</label>
                    <select class="form-select" name="editora" id="">
                        <?php 
                            foreach ($editoras as $editora) 
                            {
                                echo "<option value='{$editora->id}'>{$editora->nome}</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <label>Autor</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="autor" required>
                </div>
                
                <label>Ano</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="ano" required>
                </div>
                
                <label>Preco</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="preco" required>
                </div>
                
                <label>Quantidade</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="quantidade" required>
                </div>
                
                <label>Tipo</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="tipo" required>
                </div>
                
                <button class="btn btn-azul" type="submit">Salvar</button>
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
                        echo "<div class='alerta alerta-verde'>Cadastro realizado com sucesso!</div>";
                        
                        header("Location: /controledeacervo/public/index.php");
                        exit();
                    }
                    else
                    {
                        echo "<div class='alerta alerta-vermelho'>Houve um erro interno!</div>";
                    }
                }
            ?>
        </div>
    </body>
</html>