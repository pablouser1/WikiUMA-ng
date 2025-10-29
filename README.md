# WikiUMA-ng
Valora a los profesores de la Universidad de Málaga.

## Funciones
* Conexión a DUMA, por lo que la lista de profesores siempre está actualizada.
* Anonimato, no se almacena información acerca de ti al enviar tu valoración.
* Seguridad, no se almacena información sensible del profesor.
* Sano, los insultos se filtran, tanto automáticamente como manualmente, para conseguir un entorno mucho más agradable para todos.

## Instalación
Para poder usar WikiUMA-ng necesitas como mínimo:
* PHP >= 8.0
* ext-curl
* ext-iconv
* ext-mbstring
* Dart-Sass
* Base de datos MySQL/MariaDB/PostgreSQL
* Token de [hCaptcha](https://www.hcaptcha.com)

Recomendado:
* Redis + ext-redis

```bash
composer install # Usa --no-dev si estás en producción
```

Una vez instaladas las dependencias, compila bulma usando:
```bash
composer run-script bulma
```

Para terminar, copia el .env de ejemplo y modifícalo encajándolo con tu instalación:
```bash
cp .env.example .env
```

## Docs
Con PHPDoc instalado, ejecuta:
```bash
phpdoc run -d src -t docs
```

## Desarrollo
### Styling
```bash
./vendor/bin/php-cs-fixer fix src
```
