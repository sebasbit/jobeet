# jobeet
Tutorial Jobeet como introducción al framework Symony 1.4

## Instalación
- Debido a la versión de Symfony, la aplicación debe ejecutarse con PHP v5.4.* (recomendado PHP v5.4.45).
- Configurar los parametros para conectar la base de datos en el archivo */config/database.yml* y ejecutar el comando php `.\symfony doctrine:build --all --and-migrate --no-confirmation`
- Para habilitar las dev tools crear un archivo [nombre del módulo]_dev.php y pegar el siguiente código
  ```php
  <?php

  // this check prevents access to debug front controllers that are deployed by accident to production servers.
  // feel free to remove this, extend it or make something more sophisticated.
  if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))
  {
    die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
  }

  require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

  $configuration = ProjectConfiguration::getApplicationConfiguration('AQUÍ VA EL NOMBRE DEL MÓDULO', 'dev', true);
  sfContext::createInstance($configuration)->dispatch();
  ```
  
