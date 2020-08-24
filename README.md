# Laravel XML Parser

* [Instalación](#instalación)
* [Uso](#uso)

Este paquete te ayuda a convertir un XML a object, array y json mediante un trait.

## Instalación

Este paquete puede ser utlizado en Laravel 5.5 o superior.

Instalar el paquete a través de composer:

```bash
composer require ralego/laravel-xml-parser
```
Opcional: Puedes publicar el archivo de configuración ``` config/xmlparser.php ``` para personalizar la forma en que quieras obtener los datos.

```bash
php artisan vendor:publish --tag=laravel-xml-parser
```

## Uso

Primero, agrega el trait donde deseas utilizar el parser con ``` Ralego\Parser\Traits\XmlParser ```

Ejemplo:
```php
use Ralego\Parser\Traits\XmlParser;

class HomeController extends Controller
{
    use XmlParser;

    public function test()
    {
        $xml = file_get_contents('http://www-db.deis.unibo.it/courses/TW/DOCS/w3schools/xml/cd_catalog.xml');
        $object = $this->xmlToObject($xml);
        $array = $this->xmlToArray($xml);
        $json = $this->xmlToJson($xml);
        dd($object, $array, $json);
    }
}
```