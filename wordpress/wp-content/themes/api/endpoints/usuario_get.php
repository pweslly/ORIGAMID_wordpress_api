<?php
function api_usuario_get($request)
{
  $user = wp_get_current_user();
  $user_id = $user->ID;

  if ($user_id > 0) {
    $user_meta = get_user_meta($user_id);
    /*
     Esse user_meta é diferente do user
     no user estou pegando o ID pelo GET
     e no $user_id  estou atribuindo o ID peguei pelo
     get na variaǘel $user.  No $user_meta  uso função
     do worpdress para pegar informações no banco de dados
     referente ao usuário do ID capturado pelo GET.
    */


    $response = array(
      "id" => $user->user_login,
      "nome" => $user->display_name,
      "email" => $user->user_email,
      "cep" => $user_meta['cep'][0],
      "numero" => $user_meta['numero'][0],
      "rua" => $user_meta['rua'][0],
      "bairro" => $user_meta['bairro'][0],
      "cidade" => $user_meta['cidade'][0],
      "estado" => $user_meta['estado'][0]
      // Coloquei 0 porque é primeiro item quero da array

    );
  } else {
    $response = new WP_Error('permissao', 'Usuario não tem permisão', array('status' => 401));
  }
  return rest_ensure_response($response);
}

function registrar_api_usuario_get()
{
  register_rest_route('api', '/usuario', array(
    array(
      # Aqui no metodo eu digo, se é post, put, delete entre outros.
      'methods' => WP_REST_Server::READABLE,
      # Aqui retorno, nesse caso vai executar função lá em cima
      'callback' => 'api_usuario_get',
    ),
  ));
}

#tenho que adicionar função no wordpress
add_action('rest_api_init', 'registrar_api_usuario_get');
