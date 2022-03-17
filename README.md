# Gimnasio

## Technologías
<ul>
    <li>PHP7.2</li>
    <li>MySQL</li>
    <li>Bootstrap</li>
    <li>HTML</li>
    <li>CSS</li>
    <li>AJAX</li>
</ul>

## Descripción
Es un sistema para administrar un gimnasio, se pueden administrar las membresías de los socios,
cuenta con un punto de venta, historiales de venta de membresías y productos, crear recepcionistas y además los socios tienen su perfil en donde pueden ver las rutinas acorde a cada músculo, de igual manera pueden registrar si tienen alguna lesión, de esa manera su entrenador puede saberlo antes de asignarles su rutina. El sistema maneja dos tipos de roles, los administradores y recepcionistas. Los administradores pueden crear/eslimiar recepcionistas, dar de alta/baja nuevos productos, cambiar precios de las membresías, reestablecer la contraseña de los recepcionistas, ver los historiales de días anteriores. Y los recepcionistas sólo puede vender productos, renovar las membresías de los socios y registrar nuevos socios.
El perfil de los socios es un aparado aparte, ellos no necesitan contraseña para ingresar, basta con so código y su correo electrónico, sólo pueden modificar sus datos y ver las rutinas, también cuentan con un chatbot, el que responde a preguntas sobre precios de productos/membresías, horarios el gimnasio, si cuentan con instructores, regaderas, preguntas sencillas.

## Uso de teconologías
PHP Se usó para crear toda la lógica del sistema, se creo con un patrón de diseño parecido al MVC, por cada modelo tenemos la clase, una clase DAO (Objeto de acceso a datos (En donde hacemos las consultas, inserciones a la base de datos)), y una clase administradora que es la que tiene la instancia de un DAO y es ahí en donde se validan los datos antes de llamar al DAO y después se tienen los archivos los cuales tienen el código HTML y la instancia de una clase administradora.
Bootstrap fue usado para hacer el chatbot, de esa manera no era necesario recargar la página en cada pregunta que se le hacía, de esa manera te respondía al instante.
