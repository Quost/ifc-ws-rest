<?php
//*****************//
// C L I E N T E   //
//*****************//

//incluindo a biblioteca
require_once 'nusoap-0.9.5/lib/nusoap.php';
$wsdl = 'http://localhost/projetowsREST/soap/servidor.php?wsdl';
$cliente = new nusoap_client($wsdl, 'wsdl');

$funcao = 'getNome';
$params = array('id'=>1);

$result = $cliente->call($funcao, $params);
echo ('<pre>');
print_r($cliente->return);

$result = $cliente->call('getEndereco', $params);
echo ('<pre>');
print_r($cliente->return);

$result = $cliente->call('getCurso', $params);
echo ('<pre>');
print_r($cliente->return);

$result = $cliente->call('getDisciplina', $params);
echo ('<pre>');
print_r($cliente->return);

echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($cliente->request, ENT_QUOTES) . '</pre>';

echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($cliente->response, ENT_QUOTES) . '</pre>';

// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($cliente->debug_str, ENT_QUOTES) . '</pre>';