<?php
function api_usuario_post($request)
{
  $email = $request['email'];
  $senha = $request['senha'];
  $nome = $request['nome'];
  $rua = $request['rua'];
  $cep = $request['cep'];
  $numero = $request['numero'];
  $bairro = $request['bairro'];
  $cidade = $request['cidade'];
  $estado = $request['estado'];

  $response = array(
    'nome' => $nome,
    'email' => $email
  );


  /* 
     Essa função vai retorna isso, quer dizer dê uma reposta do
     tipo api do wordpress 
  */
  return rest_ensure_response($response);
}

/*
  Agora preciso só registrar minha API na rest do wordpress
*/
function registrar_api_usuario_post()
{
  /* 
    Esse função vai chamar uma função real 
    do wordpress que registra API
  */
  register_rest_route('api', '/usuario', array(
    array(
      # Aqui no metodo eu digo, se é post, put, delete entre outros.
      'methods' => WP_REST_Server::CREATABLE,
      #'methods' => 'GET',
      # Aqui retorno, nesse caso vai executar função lá em cima
      'callback' => 'api_usuario_post',
    ),
  ));
}

#tenho que adicionar função no wordpress
add_action('rest_api_init', 'registrar_api_usuario_post');
