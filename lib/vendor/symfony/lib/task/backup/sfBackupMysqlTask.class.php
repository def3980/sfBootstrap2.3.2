<?php

/**
 * + ------------------------------------------------------------------- +
 * Agregando una nueva tarea para crear respaldo de base de datos solo   |
 * para el motor de base de datos MySQL.  Que pena por los demaas        |
 * Por Oswaldo Rojas un                                                  |
 * Miércoles, 12 Noviembre 2014 17:33:49                                 |
 * + ------------------------------------------------------------------- +
 */

require_once(dirname(__FILE__).'/../generator/sfGeneratorBaseTask.class.php');

/**
 * Genera respaldo de base de datos.
 *
 * @package    symfony
 * @subpackage backup
 * @author     Oswaldo Rojas <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGenerateModuleTask.class.php 23922 2009-11-14 14:58:38Z fabien $
 */
class sfBackupMysqlTask extends sfGeneratorBaseTask {
    
    protected 
        $findDns = "dsn:",
        $findHst = "host=",
        $findDbn = "dbname=",
        $findUsr = "username:",
        $findPwd = "password:";

    /**
     * @see sfTask
     */
    protected function configure() {
        $this->addArguments(array(
            new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'El nombre del archivo a crear'),
        ));
        $this->namespace           = 'backup';
        $this->name                = 'mysql';
        $this->briefDescription    = '>> Genera respaldo de base de datos';
        $this->detailedDescription = <<<EOF
La tarea [backup:mysql|INFO] crea un respaldo de base de datos con
extension *.sql a la vez que se le va a comprimir para mejor
transporte:

  [./symfony backup:mysql nombre_archivo|INFO]

Adicionalmente la instruccion sabe que extension crear para el archivo
comprimido (nombre_archivo.zip), ademas de incluir adicional a nombre
de archivo la fecha y hora actual del sistema donde se encuentre 
instalado.

  backup_2014-11-21_172119.zip

El directorio por defecto para la ubicacion del respaldo de base de datos 
es la carpeta docs.
EOF;
    }

    /**
     * @see sfTask
     */
    protected function execute($arguments = array(), $options = array()) {
        $contenedor = array();
        if ($file = file(sfConfig::get('sf_config_dir').'/databases.yml')) {
            foreach ($file as $k => $v):
                if (false !== strpos($v, $this->findDns)):
                    $contenedor['hst'] = trim(reset(split(';', end(split($this->findHst, trim(end(split(':', $v))))))));
                    $contenedor['dbn'] = trim(rtrim(end(split(
                                            $this->findDbn, 
                                            (end(split(';', end(split($this->findHst, trim(end(split(':', $v))))))))
                                         )), "'"));
                elseif (false !== strpos($v, $this->findUsr)):
                    $contenedor['usr'] = trim(end(split(':', $v)));
                elseif (false !== strpos($v, $this->findPwd)):
                    $contenedor['pwd'] = ltrim(rtrim(trim(end(split(':', $v))), "'"), "'");
                endif;
            endforeach;
        }
        $command = "mysqldump "
                 . "-h ".$contenedor['hst']." "
                 . "-u ".$contenedor['usr']." "
                 . "-p".$contenedor['pwd']." "
//                 . "--opt "
//                 . "--extended-insert=FALSE "
                 . "--skip-extended-insert "
                 . "--single-transaction "
                 . "--quick "
                 . $contenedor['dbn']." > "
                 . sfConfig::get('sf_docs_dir')."/"
                 . $arguments['name']."_".date('Y-m-d')."_".date('His').".sql";
        exec($command);
        
        $file_compress = "7z "
                       . "a "
                       . "-t7z "
                       . sfConfig::get('sf_docs_dir')."/backup.7z "
                       . sfConfig::get('sf_docs_dir')."/"
                       . $arguments['name']."_".date('Y-m-d')."_".date('His').".sql "
//                       . "-m0=BCJ2 -m1=LZMA2:d=1024m -aoa";
//                       . "-mx9 -aoa";
                       . "-mx9";
        
        exec($file_compress);
        $this->logSection('backup:mysql', sprintf('"%s" :: creado satisfactoriamente...', $contenedor['dbn']));
        
//        $app    = $arguments['application'];
//        $module = $arguments['module'];

//        // Se valida el nombre del modulo
//        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $module)) {
//            throw new sfCommandException(sprintf('El nombre del modulo "%s" es invalido.', $module));
//        }
//
//        $moduleDir = sfConfig::get('sf_app_module_dir').'/'.$module;
//
//        if (is_dir($moduleDir)) {
//            throw new sfCommandException(sprintf('El modulo "%s" ya existe en la aplicacion "%s".', $moduleDir, $app));
//        }
//
//        $properties = parse_ini_file(sfConfig::get('sf_config_dir').'/properties.ini', true);
//
//        $constants = array(
//            'PROJECT_NAME' => isset($properties['symfony']['name']) ? $properties['symfony']['name'] : 'symfony',
//            'APP_NAME'     => $app,
//            'MODULE_NAME'  => $module,
//            'AUTHOR_NAME'  => isset($properties['symfony']['author']) ? $properties['symfony']['author'] : 'Aqui tu nombre',
//            'FECHA_y_HORA' => $this->getDateAndTimeInEs(date('Y-m-d H:i:s')),
//        );
//
//        if (is_readable(sfConfig::get('sf_data_dir').'/skeleton/module')) {
//            $skeletonDir = sfConfig::get('sf_data_dir').'/skeleton/module';
//        } else {
//            $skeletonDir = dirname(__FILE__).'/skeleton/module';
//        }
//
//        // crea una estructura basica para la aplicacion
//        $finder = sfFinder::type('any')->discard('.sf');
//        $this->getFilesystem()->mirror($skeletonDir.'/module', $moduleDir, $finder);
//
//        // crea un test basico
//        $this->getFilesystem()->copy($skeletonDir.'/test/actionsTest.php', sfConfig::get('sf_test_dir').'/functional/'.$app.'/'.$module.'ActionsTest.php');
//
//        // personaliza el archivo test
//        $this->getFilesystem()->replaceTokens(
//            sfConfig::get('sf_test_dir').'/functional/'.$app.DIRECTORY_SEPARATOR.$module.'ActionsTest.php', '##', '##', $constants
//        );
//
//        // customize php and yml files
//        $finder = sfFinder::type('file')->name('*.php', '*.yml');
//        $this->getFilesystem()->replaceTokens($finder->in($moduleDir), '##', '##', $constants);
    }

}