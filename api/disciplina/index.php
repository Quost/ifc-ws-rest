<?php
/////////////////////////
// D I S C I P L I N A //
/////////////////////////

// possibilitar edições de qualquer origem - CORS
header('Acces-Control-Allow-Origin: *');
// altera o tipo de conteúdo para JSON
header('Content-Type: application/json; charset=UTF-8');

require_once "../../config/Database.php";
require_once "../../objects/Disciplina.php";

$db = new Database();
$conexao = $db->getConnection();

$disc = new Disciplina($conexao);

///////// R E A D /////////
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //caso seja passado um id, usa o mesmo na consulta;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        $id = null;
    }

    $listaDisciplinas = $disc->read($id); //retorna um array

    if(sizeof($listaDisciplinas)!=0){
        // transforma o array em JSON - seralização
        echo json_encode($listaDisciplinas);
    } else {
        echo json_encode(array('mensagem' => 'Nenhuma Disciplina atende a consulta'));
    }
///////// R E A D /////////
/////// I N S E R T ///////
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // pega o JSON que foi enviado na requisição;
     $dadosJSON = file_get_contents('php://input');
     // converte o JSON para um objeto;
     $dados = json_decode($dadosJSON);
     // verifica se os dados estão completos
     if(!empty($dados->codigo) && !empty($dados->nome) && !empty($dados->carga) && !empty($dados->ementa) && !empty($dados->semestre) && !empty($dados->id_curso)){
        // atribui valores aos atributos de $disc
        $disc->setNome($dados->nome);
        $disc->setCodigo($dados->codigo);
        $disc->setEmenta($dados->ementa);
        $disc->setSemestre($dados->semestre);
        $disc->setCarga($dados->carga);
        $disc->setIdCurso($dados->id_curso);

        if($disc->insert()){
            http_response_code(201);
            echo json_encode(array('mensagem' => 'Disciplina inserido com sucesso!'));
        }else{
            http_response_code(503);
            echo json_encode(array('mensagem' => 'Não foi possível inserir a disciplina!'));
        }
     } else { //Se os dados estiverem incompletos
        http_response_code(400);
        echo json_encode(array('mensagem' => 'Não foi possível inserir a disciplina, dados incompletos!'));
     }
/////// I N S E R T ///////
/////// U P D A T E ///////
}elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
       // pega o JSON que foi enviado na requisição;
       $dadosJSON = file_get_contents('php://input');
       // converte o JSON para um objeto;
       $dados = json_decode($dadosJSON);
       // verifica se os dados estão completos
       if(!empty($dados->codigo) && !empty($dados->nome) && !empty($dados->carga) && !empty($dados->ementa) && !empty($dados->semestre) && !empty($dados->id_curso)){
          // atribui valores aos atributos de $disc
            $disc->setId($_GET['id']);
            $disc->setNome($dados->nome);
            $disc->setCodigo($dados->codigo);
            $disc->setEmenta($dados->ementa);
            $disc->setSemestre($dados->semestre);
            $disc->setCarga($dados->carga);
            $disc->setIdCurso($dados->id_curso);
  
          if($disc->update()){
              http_response_code(200);
              echo json_encode(array('mensagem' => 'Disciplina alterado com sucesso!'));
          }else{
              http_response_code(503);
              echo json_encode(array('mensagem' => 'Não foi possível alterar a disciplina!'));
          }
       } else { //Se os dados estiverem incompletos
          http_response_code(400);
          echo json_encode(array('mensagem' => 'Não foi possível alterar o disciplina, dados incompletos!'));
       }
/////// U P D A T E ///////
/////// D E L E T E ///////
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if(isset($_GET['id'])){
        // atribui valores aos atributos de $disc
        $disc->setId($_GET['id']);

        if($disc->delete()){
            http_response_code(200);
            echo json_encode(array('mensagem' => 'Disciplina excluído com sucesso!'));
        }else{
            http_response_code(503);
            echo json_encode(array('mensagem' => 'Não foi possível excluir a disciplina!'));
        }
     } else { //Se os dados estiverem incompletos
        http_response_code(400);
        echo json_encode(array('mensagem' => 'Não foi possível excluir a disciplina, dados incompletos!'));
     }
/////// D E L E T E ///////
}
