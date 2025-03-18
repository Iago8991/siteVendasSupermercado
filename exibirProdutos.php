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
        $whereClause = "WHERE produtos_nome LIKE '%$busca%' OR produtos_descricao LIKE '%$busca%'";
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
    
    // Consulta SQL para buscar os produtos (pode ordenar por nome ou aleatoriamente)
    $sql = "SELECT * FROM produtos $whereClause ORDER BY produtos_nome";
    $resultado = mysqli_query($con, $sql);

?>

