# Produto System

## Case

Backend:

Criar uma api para realizar o gerenciamento de um produto.

Campos:
Cod Produto
Nome produto
Valor Produto
Estoque
Cidade (Chave estrangeira)

A partir desse cadastro um recurso REST para gerenciamento desse modelo com os seguintes métodos devem estar disponíveis:

GET /products - Lista todos os produtos
GET /products/{id} - Busca um produto por id
POST /products - Cria um novo produto
PUT /products/{id} - Edita um produto
DELETE /products/{id} - Deleta um produto
GET /cidades - Lista todas as cidades

Front-end:

Agora que nossa api já está feita, precisamos fazer um front-end para conversar com essa api.
O projeto do frontend, deverá ser feito com o framework Vuejs.

O projeto Backend devera ser feito em Laravel(PHP) com o banco de dados mysql.

Implementar teste unitário.

Utilizar as técnicas de clean code e orientação a objetos S.O.L.I.D

Após o fim do projeto disponibilizar no github.

A data limite de entrega do projeto será de 7 dias a partir do recebimento do teste.

## Execução

Para lançar o banco de dados mysql

`docker run --name didatikos-mysql -e MYSQL_ROOT_PASSWORD=devdidatikos -p 33060:3306 -d mysql:8.3`
OBS: senhas não deveriam estar commitadas nem 