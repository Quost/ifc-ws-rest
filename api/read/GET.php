<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" href="https://trello-attachments.s3.amazonaws.com/5f5aa6890a57b727311dcc05/542x306/27d4ee40c39bde0a47e3ff66b5326607/image.png">

    <title>READ</title>

    <?php
        // possibilitar edições de qualquer origem - CORS
        header('Acces-Control-Allow-Origin: *');

        require_once "../../config/Database.php";
        require_once "../../objects/Disciplina.php"; 

        $db = new Database();
        $conexao = $db->getConnection();

        $disc = new Disciplina($conexao);
    ?>
</head>
<body>
    <div class="row">
        <div class="col" align="center">
            <br>
            <h3>Consulta de Disciplinas- GET</h3>
            <br>   
            <form action="" method="GET">
                <label>Digite o id da Disciplina:</label>
                <input type="number" min="1" max="99999" name="id"/>
                <br /><br />
                <button type="submit" name="submit">Consultar</button>
            </form>
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                } else {
                    $id = null;
                }
                if($id!=null){
                    $url = "http://localhost/projetowsPLUS/api/get/".$id;
        
                    $client = curl_init($url);
                    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                    $response = curl_exec($client);
                
                    $result = json_decode($response);

                    print_r($result);

                    echo "<table>";
                    echo "<tr><td>Id Disciplina:</td><td>$result->id</td></tr>";
                    echo "<tr><td>Nome:</td><td>$result->nome</td></tr>";
                    echo "<tr><td>Código:</td><td>$result->codigo</td></tr>";
                    echo "<tr><td>Ementa:</td><td>$result->ementa</td></tr>";
                    echo "<tr><td>Carga Horária:</td><td>$result->carga</td></tr>";
                    echo "<tr><td>Id Curso:</td><td>$result->id_curso</td></tr>";
                    echo "</table>";
                }
            ?>   
        </div>
    </div>
</body>
<footer class="footer">
    <a href="../insert/POST.php" target="_self">INSERT |</a>
    <a href="../update/PUT.php" target="_self">UPDATE |</a>
    <a href="../delete/DEL.php" target="_self">DELETE |</a>
    <a class="active" href="#" target="_self">READ</a>
</footer>
</html>