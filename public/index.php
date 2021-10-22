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
                <h3 class="mb-3">Usuários do Sistema</h3>
            <div class="mb-2 mt-3">
                <a href="criar.php" class="btn btn-success btn-sm">Adicionar Título</a>
            </div>
            <?php
                require('../app/DataBase.php');
                $busca="";
                if (isset($_REQUEST['busca']))
                {
                    $busca= $_REQUEST['busca'];
                }

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
                        echo "<td><a class='btn btn-primary btn-sm' href='editar.php?id={$item->id}'>Editar</a></td>";
                        echo "<td><form method='post'><input type='text' name='id' value='{$item->id}' hidden><button class='btn btn-danger btn-sm' type='submit'>Deletar</button></form></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                else
                {
                    echo "<div class='alert alert-secondary mt-2'>O acervo ainda não possui nenhum título</div>";
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
                        echo "<div class='alert alert-secondary mt-2'>Registro deletado com sucesso!</div>";
                        header("Refresh:2");
                    }
                }
            ?>
        </div>
    </body>
    <script>
    </script>
</html>