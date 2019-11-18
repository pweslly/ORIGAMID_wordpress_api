# Instruções

## Na parte instalar plugin no wordpress
<p> As vezes pede acesso ftp para resolver esse problema </p>

<p>Com uma pesquisa rápida no Google você encontra a solução de mudar o dono da pasta do site (no momento deve estar “root” ou “seu-usuario”):</p>

```
$ sudo chown -R www-data pasta-do-site
```
```
$ sudo chmod -R g+w pasta-do-site
```

<p>A primeira linha altera recursivamente o dono da pasta para “www-data” (geralmente esse é o usuário atribuído ao seu localhost, se não for, troque o nome) e a segunda linha torna isso verdade para as novas subpastas, caso crie alguma.</p>

<p>O problema dessa solução é que muito provavelmente você não poderá mais criar ou alterar manualmente pastas e arquivos (através da interface gráfica, por exemplo).</p>