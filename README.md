# Estrutura MVC 

#### Base de uma estrutura utilizando MVC


## Features

- POO
- SOLID
- Clean Code
- Singleton

## Configurações de Ambiente

##### É recomendado utilizar essas configurações no seu arquivo `.ini` para conseguir manipular de forma correta os vídeos:

```
post_max_size = XX
memory_limit = XX
max_execution_time = XX
max_input_time = XX
```

##### Caso esteja utilizando *nginx* com *fastcgi*, utilize esses comandos também:

```
fastcgi_read_timeout XXXX;
fastcgi_send_timeout XXXX;
fastcgi_connect_timeout XXXX;
```