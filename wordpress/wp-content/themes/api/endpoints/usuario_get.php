<?php
function api_usuario_get($request)
{

  # Vamos pegar dados atual do usuário logado

  $user = wp_get_current_user();
  return rest_ensure_response($user);
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
