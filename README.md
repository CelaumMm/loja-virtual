
# Loja virtual

Projeto desenvolvido sem Framework

## Instalação

1. Clone ou baixe o repositorio e execute os comandos no terminal

    ```bash
    cd loja-virtual/estrutura
    cp env-example .env

    # Instalação das dependencias do Projeto (Demora um pouco)
    composer install
    npm install
    ```
    
2. Criar o banco de dados com o arquivo `banco.sql` dentro da pasta database

3. Configurar o acesso ao banco de dados no arquivo `.env` dentro da pasta estrutura, sobrescrevendo as linhas com suas informações de acesso ao banco de dados.

    ```bash
    MYSQL_LOCAL_DRIVE=mysql
    MYSQL_LOCAL_HOST=127.0.0.1
    MYSQL_LOCAL_PORT=3306
    MYSQL_LOCAL_DATABASE=loja-virtual
    MYSQL_LOCAL_USER=root
    MYSQL_LOCAL_PASSWORD=root
    ```

4. Usuario e senha de administrador

    >Usuario: admin@exemplo.com  
    >Senha: 123456  


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
