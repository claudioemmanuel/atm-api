## 🖥 Tecnologias
#### `Back-end`
- [Laravel](https://laravel.com/)
#### Para executar a aplicação será necessário o [Composer](https://getcomposer.org/download/)
#### Para fazer os testes na API será necessário o [Insomnia](https://insomnia.rest/download)

## 🎴 Como Usar?

Instalação do projeto
```bash
$ composer install
```

#### Após copie/duplique o arquivo .env.example e renomeie para .env configurando com suas variáveis de ambiente de banco
Execute o comando abaixo para criar a estrutura do banco
```bash
$ php artisan migrate:fresh --seed
```

Inicie o servidor do Laravel
```bash
$ php artisan key:generate
$ php artisan serve
```

Para criar as transações de saque e depósito está sendo utilizado filas, em outro tereminal execute o comando abaixo para inicar também o processo de monitoramento da fila
```bash
$ php artisan queue:work
```

## 💻 Insomnia
Para documentação das rotas e teste da API importe o arquivo em **docs/Insomnia.json**

## 🔗 Routes 
#### /api/users - POST para criar o usuário na API

Request a ser enviada
```bash
{
	"name": "Claudio Emmanuel",
	"cpf": "11111111111",
	"birth_date": "11/11/1111"
}
```

#### /api/users - GET para retornar todos os usuários

Request a ser enviada
```bash
curl --request GET \
  --url http://127.0.0.1:8000/api/users
```

#### /api/users/3 - GET para retornar um usuário

Request a ser enviada
```bash
curl --request GET \
  --url http://127.0.0.1:8000/api/users/3 \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json'
```

#### /api/users/{user_id} - PUT para atualizar um usuário

Request a ser enviada
```bash
{
	"name": "Claudio Emmanuel",	
	"birth_date": "11/11/1111"
}
```

#### /api/users/{user_id} - DELETE para deletar um usuário

Request a ser enviada
```bash
curl --request DELETE \
  --url http://127.0.0.1:8000/api/users/3 \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json'
```

#### /api/account - POST para criar uma conta bancária para um usuário

Request a ser enviada
```bash
{
	"cpf": "11111111111",
	"account_type_id": 1,
	"balance": 100
}
```

#### /api/deposit - POST para criar uma transação de depósito

Request a ser enviada
```bash
{
	"cpf": "11111111111",
	"bank_number": {NUMERO_DO_BANCO},
	"account_number": {NUMERO_DA_CONTA},
	"amount": 1000
}
```

#### /api/withdraw - POST para criar uma transação de saque

Request a ser enviada
```bash
{
	"cpf": "11111111111",
	"bank_number": {NUMERO_DO_BANCO},
	"account_number": {NUMERO_DA_CONTA},
	"amount": 500
}
```

#### /api/extract - POST para solicitar extrato 

Request a ser enviada
```bash
{
	"bank_number": {NUMERO_DO_BANCO},
	"account_number": {NUMERO_DA_CONTA},
	"start_date": "01/07/2021",
	"end_date": "01/08/2021",
	"transaction_type_id": 1
}
```

## 📙 Licença
> Com base nos termos de [MIT LICENSE](https://opensource.org/licenses/MIT)

##### Feito por Claudio Emmanuel com ❤️
