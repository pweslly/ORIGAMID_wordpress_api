<?php
function api_usuario_post($request)
{
  /*
    Para tentar evitar que o usuário envie qualquer coisa vamos salientizar, uma função do wordpress
    que vai verificar o que sendo repassado para api
    pelo usuário.
  */

  $email = sanitize_email($request['email']);
  $senha = sanitize_text_field($request['senha']);
  $nome = sanitize_text_field($request['nome']);
  $rua = sanitize_text_field($request['rua']);
  $cep = sanitize_text_field($request['cep']);
  $numero = sanitize_text_field($request['numero']);
  $bairro = sanitize_text_field($request['bairro']);
  $cidade = sanitize_text_field($request['cidade']);
  $estado = sanitize_text_field($request['estado']);

  /*
    Criar uma função para sabe se já existe um usuário
  */
  $user_exists = username_exists($email);
  $email_exists  = email_exists($email);
  if (!$user_exists && !$email_exists && $email && $senha) {
    /*
      Função para criar usuário, é nativo do wordpress
    */
    $user_id =  wp_create_user($email, $senha, $email);

    /*
      Se quiser atualizar com outras informações
    */

    $response = array(
      // Esse número único ID retorna da função wp_create_user
      'ID' => $user_id,
      'display_name' => $nome,
      'first_name' => $nome,
      'role' => 'subscriber',
    );
    // Ai depois que passo para atualizar a resposta. Coloco response la dentro da função wp_update_user
    wp_update_user($response);

    /* 
      Aqui vou criar meta field onde vai acrescentar informações a mais 
      que eu quero colocar
      update_user_meta( o id que quero modificar, tipo, e valor na variavel)

      Aqui vai ficar tudo que for customizado
    */

    update_user_meta($user_id, 'cep', $cep);
    update_user_meta($user_id, 'rua', $rua);
    update_user_meta($user_id, 'numero', $numero);
    update_user_meta($user_id, 'bairro', $bairro);
    update_user_meta($user_id, 'cidade', $cidade);
    update_user_meta($user_id, 'estado', $estado);
  } else {
    $response = new WP_Error('email', 'Email já cadastrado.', array('status' => 403));
  }

  /* 
     Essa função vai retorna isso, quer dizer vai me dá uma reposta do
     tipo api do wordpress. Tipo vai exibir o resultado do cadastro
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
