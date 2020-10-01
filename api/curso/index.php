<?php
/////////////////
// C U R S O S //
/////////////////

// possibilitar edições de qualquer origem - CORS
header('Acces-Control-Allow-Origin: *');
// altera o tipo de conteúdo para JSON
header('Content-Type: application/json; charset=UTF-8');

require_once "../../config/Database.php";
require_once "../../objects/Curso.php";

$db = new Database();
$conexao = $db->getConnection();

$curso = new Curso($conexao);

///////// R E A D /////////
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //caso seja passado um id, usa o mesmo na consulta;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        $id = null;
    }

    $listaCursos = $curso->read($id); //retorna um array

    if(sizeof($listaCursos)!=0){
        // transforma o array em JSON - seralização
        echo json_encode($listaCursos);
    } else {
        echo json_encode(array('mensagem' => 'Nenhum curso atende a consulta'));
    }
///////// R E A D /////////
/////// I N S E R T ///////
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // pega o JSON que foi enviado na requisição;
     $dadosJSON = file_get_contents('php://input');
     // converte o JSON para um objeto;
     $dados = json_decode($dadosJSON);
     // verifica se os dados estão completos
     if(!empty($dados->nome) && !empty($dados->descricao)){
        // atribui valores aos atributos de $curso
        $curso->setNome($dados->nome);
        $curso->setDescricao($dados->descricao);

        if($curso->insert()){
            http_response_code(201);
            echo json_encode(array('mensagem' => 'Curso inserido com sucesso!'));
        }else{
            http_response_code(503);
            echo json_encode(array('mensagem' => 'Não foi possível inserir o Curso!'));
        }
     } else { //Se os dados estiverem incompletos
        http_response_code(400);
        echo json_encode(array('mensagem' => 'Não foi possível inserir o curso, dados incompletos!'));
     }
/////// I N S E R T ///////
/////// U P D A T E ///////
}elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
       // pega o JSON que foi enviado na requisição;
       $dadosJSON = file_get_contents('php://input');
       // converte o JSON para um objeto;
       $dados = json_decode($dadosJSON);
       // verifica se os dados estão completos
       if(!empty($dados->nome) && !empty($dados->descricao)){
          // atribui valores aos atributos de $curso
          $curso->setId($_GET['id']);
          $curso->setNome($dados->nome);
          $curso->setDescricao($dados->descricao);
  
          if($curso->update()){
              http_response_code(200);
              echo json_encode(array('mensagem' => 'Curso alterado com sucesso!'));
          }else{
              http_response_code(503);
              echo json_encode(array('mensagem' => 'Não foi possível alterar o Curso!'));
          }
       } else { //Se os dados estiverem incompletos
          http_response_code(400);
          echo json_encode(array('mensagem' => 'Não foi possível alterar o curso, dados incompletos!'));
       }
/////// U P D A T E ///////
/////// D E L E T E ///////
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if(isset($_GET['id'])){
        // atribui valores aos atributos de $curso
        $curso->setId($_GET['id']);

        if($curso->delete()){
            http_response_code(200);
            echo json_encode(array('mensagem' => 'Curso excluído com sucesso!'));
        }else{
            http_response_code(503);
            echo json_encode(array('mensagem' => 'Não foi possível excluir o Curso!'));
        }
     } else { //Se os dados estiverem incompletos
        http_response_code(400);
        echo json_encode(array('mensagem' => 'Não foi possível excluir o curso, dados incompletos!'));
     }
/////// D E L E T E ///////
}
