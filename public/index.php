
<?php
    require('../app/DataBase.php');
    $busca="";
    if (isset($_REQUEST['busca']))
    {
        $busca= $_REQUEST['busca'];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">
        <title>Acervo</title>
    </head>
    <body>
        <div class="corpo-da-pagina">
                <h3>Livros do Acervo</h3>
            <div class="botao-voltar">
                <a href="criar.php" class="btn btn-verde btn-pequeno">Adicionar Título</a>
            </div>

            <form method="GET" action="index.php">
                <div class="grupo-de-input">
                    <input type="text" class="input-modificado" placeholder="Buscar por Título" name="busca" value="<?php echo $busca; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-cinza" type="submit">Buscar</button>
                    </div>
                </div>
            </form>

            <?php
                $DataBase = new DataBase();
                $sql = "SELECT a.id as id, e.nome as editora, a.titulo as titulo, a.autor as autor, a.ano as ano, a.preco as preco, a.quantidade as quantidade, a.tipo as tipo FROM acervo a, editora e where a.idEditora = e.id and a.id > :id and (a.titulo like '{$busca}%' or a.titulo like '%{$busca}' or a.titulo like '%{$busca}%')";
                $binds = ['id' => 0];
                $result = $DataBase->select($sql, $binds);
                if ($result->rowCount() > 0)
                {
                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Titulo</th>";
                    echo "<th scope='col'>Autor</th>";
                    echo "<th scope='col'>Ano</th>";
                    echo "<th scope='col'>Preço</th>";
                    echo "<th scope='col'>Quantidade</th>";
                    echo "<th scope='col'>Editora</th>";
                    echo "<th scope='col'>Tipo</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    $dados = $result->fetchAll(PDO::FETCH_OBJ);
                    
                    foreach ($dados as $item) {
                        echo "<tr>";
                        echo "<th scope='row'>{$item->titulo}</td>";
                        echo "<td>{$item->autor}</td>";
                        echo "<td>{$item->ano}</td>";
                        echo "<td>R$ {$item->preco}</td>";
                        echo "<td>{$item->quantidade}</td>";
                        echo "<td>{$item->editora}</td>";
                        echo "<td>{$item->tipo}</td>";
                        echo "<td><a class='btn btn-azul btn-pequeno' href='editar.php?id={$item->id}'>Editar</a></td>";
                        echo "<td><form method='post'><input type='text' name='id' value='{$item->id}' hidden><button class='btn btn-vermelho btn-pequeno' type='submit'>Deletar</button></form></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                else
                {
                    echo "<div class='alerta alerta-cinza'>Nenhum título encontrado!</div>";
                }
            ?>

            <?php
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                if (!empty($id))
                {
                    $DataBase = new DataBase();
                    $sql = "DELETE FROM acervo WHERE id = :id";
                    $binds = ['id' => $id];
                    $result = $DataBase->delete($sql, $binds);

                    if ($result > 0)
                    {
                        echo "<div class='alerta alerta-cinza'>Registro deletado com sucesso!</div>";
                        header("Refresh:2");
                    }
                }
            ?>
        </div>
    </body>
</html>