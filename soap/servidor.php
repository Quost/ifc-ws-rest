<?php
//*****************//
// S E R V I D O R //
//*****************//

//incluindo a biblioteca
require_once 'nusoap-0.9.5/lib/nusoap.php';
//incluindo a conexão e a classe Curso
require_once '../config/Database.php';
require_once '../objects/Curso.php';
require_once '../objects/Disciplina.php';

//instancia, configura o WSDL e o NameSpace
$server = new soap_server();
$server->configureWSDL('WebService do Matheus', 'urn:ifc.matheus');
$server->wsdl->schemaTargetNamespace = 'urn:ifc.matheus';

$server->register(
    'getNome',
    array('id' => 'xsd:int'),
    array('Dados' => 'xsd:string')
);

$server->register(
    'getEndereco',
    array('id' => 'xsd:int'),
    array('Endereco' => 'xsd:string')
);

// Criando no WSDL o tipo complexo curso
$server->wsdl->addComplexType(
    'Curso',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:int'),
        'nome' => array('name' => 'nome', 'type' => 'xsd:string'),
        'descricao' => array('name' => 'descricao', 'type' => 'xsd:string')
    )
);

$server->register(
    'getCurso',
    array('id' => 'xsd:int'),
    array('Curso' => 'tns:Curso')
);

// Criando no WSDL o tipo complexo disciplina
$server->wsdl->addComplexType(
    'Disciplina',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:int'),
        'codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
        'nome' => array('name' => 'nome', 'type' => 'xsd:string'),
        'carga' => array('name' => 'carga', 'type' => 'xsd:string'),
        'ementa' => array('name' => 'ementa', 'type' => 'xsd:string'),
        'semestre' => array('name' => 'semestre', 'type' => 'xsd:string'),
        'id_curso' => array('name' => 'id_curso', 'type' => 'xsd:int')
    )
);

$server->register(
    'getDisciplina',
    array('id' => 'xsd:int'),
    array('Disciplina' => 'tns:Disciplina')
);

function getNome($id){
    if ($id == 1){
        $dados = 'Matheus Quost';
    }else{
        $dados = 'Homer Simpson';
    }
    return $dados;
}

function getEndereco($id){
    if ($id == 1){
        $dados = 'Rua das bananeiras, 21';
    }else{
        $dados = 'Springfield, 34';
    }
    return $dados;
}

function getCurso($id){
    $db = new Database();
    $conexao = $db->getconnection();

    $c = new Curso($conexao);
    $cursos = $c->read($id);

    foreach($cursos as $curso){
        $dados = $curso;
    }
    return $curso;
}

function getDisciplina($id){
    $db = new Database();
    $conexao = $db->getconnection();

    $c = new Disciplina($conexao);
    $disciplinas = $c->read($id);

    foreach($disciplinas as $disciplina){
        $dados = $disciplina;
    }
    return $disciplina;
}

//os dados brutos da requisição
$dados = file_get_contents('php://input');
//inicia o serviço
$server->service($dados);