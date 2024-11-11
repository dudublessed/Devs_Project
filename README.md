# Devs_Project

Um software para gerenciamento de associados e suas anuidades.

#

### Instalar PostgreSQL

1. **Baixe o PostgreSQL**: Acesse o site oficial [PostgreSQL](https://www.postgresql.org/download/) e faça o download da versão compatível com seu sistema operacional.

2. **Instalar o PostgreSQL**: Siga as instruções de instalação do PostgreSQL no seu sistema.

#

### Iniciando Servidor do PostgreSQL

#### Abra o prompt de comando como administrador e digite o seguinte:

```bash
cd "C:\\Program Files\\PostgreSQL\\17\\bin"
```

(Substitua pelo caminho até a pasta bin de onde está localizado o seu PostgreSQL)

#### Em seguida, utilize o comando abaixo para verificar se o servidor já está rodando:

```bash
pg_ctl -D "C:\\Program Files\\PostgreSQL\\17\\data" status
```

#### Caso não esteja, inicie com:

```bash
pg_ctl -D "C:\\Program Files\\PostgreSQL\\17\\data" start
```

#

### Instalar PHP

1. **Baixar o PHP**: Acesse o site oficial [PHP](https://www.php.net/downloads.php) e baixe a versão compatível com seu sistema operacional.

2. **Instalar o PHP**: Siga as instruções de instalação do PHP no seu sistema.
  
3. **Adicionar o PHP ao PATH**: Certifique-se de adicionar a pasta onde o PHP foi instalado ao PATH do sistema. Isso permite que você execute o PHP a partir de qualquer terminal. 

#

### Configurar PHP

1. Habilitar extensão do PostgreSQL: Se diriga ao arquivo php.ini no seu arquivo PHP e remova o ";" de:

```ini
;extension=pgsql
;extension=pdo_pgsql
```

Após as alterações, deve se parecer com isso:

```ini
extension=pgsql
extension=pdo_pgsql
```

#

### Instalar o Composer

1. **Baixar o Composer**: Acesse o site oficial Composer e siga as instruções para instalar o Composer no seu sistema.

2. **Verificar a instalação**: Após a instalação, no terminal, digite:

```bash
composer --version
```
(Isso irá mostrar a versão do Composer, indicando que a instalação foi bem-sucedida.)

#

### Para iniciar o PHP

#### Abra o projeto no Visual Studio Code e, no terminal, digite:

```bash
cd Public
```
(Para navegar até a pasta onde se encontra o arquivo index.php que lida com as requisições)

#### Então, inicie o PHP:

```bash
php -S localhost:8000
```

(Isso irá iniciar o servidor embutido do PHP no endereço localhost na porta 8000.)


#### Para acessar a página inicial do site, digite no navegador o seguinte:

```bash
http://localhost:8000/home
```
