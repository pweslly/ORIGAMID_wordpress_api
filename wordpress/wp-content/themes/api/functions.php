<?php

$template_diretorio = get_template_directory();

require_once($template_diretorio . '/custom-post-type/produto.php');
require_once($template_diretorio . '/custom-post-type/transacao.php');
require_once($template_diretorio .  '/endpoints/usuario_post.php');
require_once($template_diretorio .  '/endpoints/usuario_get.php');

/*
  Criar tempo de expiração do token
  Ele vai pegar o tempo atual do servidor time() mais tempo que você
  quer que o token se expira.
*/

function experie_token()
{
  return time() + (60 * 60 * 24);
  // 60 segundos + 60 da uma hora * 24 dá um 1 dia
}
add_action('jwt_auth_expire', 'expire_token');
