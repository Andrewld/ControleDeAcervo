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

    $id=$_REQUEST['id'];
    $sql = "SELECT * FROM acervo WHERE id = :id";
    $binds = ['id' => $id];
    $resultEditar = $DataBase->select($sql, $binds)->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">
        <title>Editar Título</title>
    </head>
    <body>
        <div class="corpo-da-pagina">
            <form method="post">
                <h3>Editar Título</h3>
                <div class="botao-voltar">
                    <a href="index.php" class="btn btn-cinza btn-pequeno">Voltar</a>
                </div>
                <input class="input-modificado" type="text" name="id" required hidden value="<?php echo $resultEditar->id ?>">
                
                <label>Titulo</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="titulo" required value="<?php echo $resultEditar->titulo ?>">
                </div>

                <div class="grupo-de-select">
                    <label>Editora</label>
                    <select class="form-select" name="editora" id="">
                        <?php 
                            foreach ($editoras as $editora) 
                            {
                                if ($editora->id == $resultEditar->idEditora)
                                {
                                    echo "<option value='{$editora->id}' selected>{$editora->nome}</option>";
                                }
                                else
                                {
                                    echo "<option value='{$editora->id}'>{$editora->nome}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                    
                <label>Autor</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="autor" required value="<?php echo $resultEditar->autor ?>">
                </div>
                
                <label>Ano</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="ano" required value="<?php echo $resultEditar->ano ?>">
                </div>
                
                <label>Preco</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="preco" required value="<?php echo $resultEditar->preco ?>">
                </div>
                
                <label>Quantidade</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="quantidade" required value="<?php echo $resultEditar->quantidade ?>">
                </div>
                
                <label>Tipo</label>
                <div class="grupo-de-input">
                    <input class="input-modificado" type="text" name="tipo" required value="<?php echo $resultEditar->tipo ?>">
                </div>
                <button class="btn btn-azul" type="submit">Salvar</button>
            </form>
            <?php
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
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
                    $binds = ['id' => $id, 'titulo' => $titulo, 'idEditora' => $idEditora, 'autor' => $autor, 'ano' => $ano, 'preco' => $preco, 'quantidade' => $quantidade, 'tipo' => $tipo];
                    $sql = "UPDATE acervo SET titulo = :titulo, idEditora = :idEditora, autor = :autor, ano = :ano, preco = :preco, quantidade = :quantidade, tipo = :tipo WHERE id = :id";

                     $result = $DataBase->update($sql, $binds);
                    if($result)
                    {
                        echo "<div class='alerta alerta-verde'>O registro foi atualizado com sucesso!</div>";
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