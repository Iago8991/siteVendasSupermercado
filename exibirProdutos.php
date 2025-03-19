<?PHP
    session_start();
    require("bd_config.php");
    //require('./css/.css');

    $busca = "";
    $categoria = "";
    $whereClause = "";

    // Se houver um termo de busca, utiliza para encontrar/filtrar produtos
    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $busca = mysqli_real_escape_string($con, $_GET['busca']);

        //opcão 1: Divide a palavra da pesquisa em partes individuais para encontrar o resultado mais proximo

        $palavras = explode(" ", $busca);
        $condicoes = [];
        foreach ($palavras as $palavra) {
            $condicoes[] = "(produtos_nome LIKE '%$palavra%' OR produtos_descricao LIKE '%$palavra%')";
        }
        $whereClause = "WHERE " . implode(" OR ", $condicoes);


        //Opcão 2: usando SOUNDEX para encontrar palavaras semelhantes
        $whereClause .= " OR SOUNDEX(produtos_nome) = SOUNDEX('$busca')";
    } 

    // Se houver filtro por categoria, adiciona à condição
    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
        $categoria = mysqli_real_escape_string($con, $_GET['categoria']);
        if ($whereClause == "") {
            $whereClause = "WHERE categoria = '$categoria'";
        } else {
            $whereClause .= " AND categoria = '$categoria'";
        }
    }
    
    // Consulta SQL para buscar os produtos 
    $sql = "SELECT * FROM produtos $whereClause ORDER BY produtos_nome";
    $resultado = mysqli_query($con, $sql);

?>

