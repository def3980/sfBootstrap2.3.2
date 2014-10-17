<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Doctrine form generator.
 *
 * This class generates a Doctrine forms.
 *
 * @package    symfony
 * @subpackage generator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormGenerator.class.php 32892 2011-08-05 07:53:57Z fabien $
 */
class sfDoctrineFormGenerator extends sfGenerator
{
  /**
   * Array of all the loaded models
   *
   * @var array
   */
  public $models = array();

  /**
   * Array of all plugin models
   *
   * @var array
   */
  public $pluginModels = array();
  
    /**
     * Para el calculo de fechas en español
     *
     * @var array
     */
    protected $_dias = array(
                       'domingo', 
                       'lunes', 
                       'martes', 
                       'miercoles', 
                       'jueves', 
                       'viernes', 
                       'sabado'
                      ),
              $_diasAbreviados = array(),
              $_meses = array(
                       'enero', 
                       'febrero', 
                       'marzo', 
                       'abril', 
                       'mayo', 
                       'junio',
                       'julio', 
                       'agosto', 
                       'septiembre', 
                       'octubre', 
                       'noviembre', 
                       'diciembre'
                      ),
              $_mesesAbreviados = array();
    
  /**
   * Initializes the current sfGenerator instance.
   *
   * @param sfGeneratorManager A sfGeneratorManager instance
   */
  public function initialize(sfGeneratorManager $generatorManager)
  {
    parent::initialize($generatorManager);

    $this->getPluginModels();
    $this->setGeneratorClass('sfDoctrineForm');
  }

  /**
   * Generates classes and templates in cache.
   *
   * @param array The parameters
   *
   * @return string The data to put in configuration cache
   */
  public function generate($params = array())
  {
    $this->params = $params;

    if (!isset($this->params['model_dir_name']))
    {
      $this->params['model_dir_name'] = 'model';
    }

    if (!isset($this->params['form_dir_name']))
    {
      $this->params['form_dir_name'] = 'form';
    }

    $models = $this->loadModels();

    // create the project base class for all forms
    $file = sfConfig::get('sf_lib_dir').'/form/doctrine/BaseFormDoctrine.class.php';
    if (!file_exists($file))
    {
      if (!is_dir($directory = dirname($file)))
      {
        mkdir($directory, 0777, true);
      }
        $this->_fechaYHora = $this->obtenerFechaYHoraEnEsp(date('Y-m-d H:i:s'));
      file_put_contents($file, $this->evalTemplate('sfDoctrineFormBaseTemplate.php'));
    }

    $pluginPaths = $this->generatorManager->getConfiguration()->getAllPluginPaths();

    // create a form class for every Doctrine class
    foreach ($models as $model)
    {
      $this->table = Doctrine_Core::getTable($model);
      $this->modelName = $model;

      $baseDir = sfConfig::get('sf_lib_dir') . '/form/doctrine';

      $isPluginModel = $this->isPluginModel($model);
      if ($isPluginModel)
      {
        $pluginName = $this->getPluginNameForModel($model);
        $baseDir .= '/' . $pluginName;
      }

      if (!is_dir($baseDir.'/base'))
      {
        mkdir($baseDir.'/base', 0777, true);
      }

        /**
         * Verificando y cargando variables para cuando el archivo Base*Form.class.php
         * existe y necesito su fecha y hora de creacion, para luego ser utilizado en
         * la plantilla 
         * sfDoctrinePlugin/data/generator/sfDoctrineForm/default/template/sfDoctrineFormGeneratedTemplate
         * 
         * Siempre y cuando el archivo en cuestion exista
         */
        $this->_existeArchivo = false;
        $this->_fechaYHora = "";
        if (is_file($baseDir."/base/Base{$model}Form.class.php")) {
            foreach (file($baseDir."/base/Base{$model}Form.class.php") as $k => $v) {
                if (!empty($this->ubicarEntre($v, '"', '"'))) {
                    $this->_existeArchivo = true;
                    $this->_fechaYHora = $this->ubicarEntre($v, '"', '"');
                    break;
                }
            }
        }
        /* + ------------------------------------------------------------------------------------------ + */

      file_put_contents($baseDir.'/base/Base'.$model.'Form.class.php', $this->evalTemplate(null === $this->getParentModel() ? 'sfDoctrineFormGeneratedTemplate.php' : 'sfDoctrineFormGeneratedInheritanceTemplate.php'));

      if ($isPluginModel)
      {
        $pluginBaseDir = $pluginPaths[$pluginName].'/lib/form/doctrine';
        if (!file_exists($classFile = $pluginBaseDir.'/Plugin'.$model.'Form.class.php'))
        {
            if (!is_dir($pluginBaseDir))
            {
              mkdir($pluginBaseDir, 0777, true);
            }
            file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormPluginTemplate.php'));
        }
      }
      if (!file_exists($classFile = $baseDir.'/'.$model.'Form.class.php'))
      {
        if ($isPluginModel)
        {
           file_put_contents($classFile, $this->evalTemplate('sfDoctrinePluginFormTemplate.php'));
        } else {
            /**
             * Verificando y cargando variables para cuando el archivo Base*Form.class.php
             * existe y necesito su fecha y hora de creacion, para luego ser utilizado en
             * la plantilla 
             * sfDoctrinePlugin/data/generator/sfDoctrineForm/default/template/sfDoctrineFormTemplate
             * 
             * Siempre y cuando el archivo en cuestion exista
             */
            $this->_actualizarFechaYHora = false; // me sirve para numeracion y hora
            if (is_file($classFile)) {
                $this->_existeArchivo = false;
                $this->_fechaYHora = "";
                $cont = 0;
                foreach (file($classFile) as $k => $v) {
                    if (!empty($this->ubicarEntre($v, '"', '"'))) {
                        if (($cont += 1) > 1) {
                            $this->_numeracion = $this->numeroDAcceso(($this->ubicarEntre($v, '"', '"') * 1) + 1);
                            $this->_actualizarFechaYHora = true;
                            $cont = 0;
                            break;
                        } else {
                            $this->_existeArchivo = true;
                            $this->_fechaYHora = $this->ubicarEntre($v, '"', '"');
                        }
                    }
                }
            } // si es false utilizo $this->_fechaYHora de la condicion que esta mas arriba
            /* + ------------------------------------------------------------------------------------------ + */
           file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormTemplate.php'));
        }
      }
              var_dump($this->modelName);
        die();
    }
  }

  /**
   * Get all the models which are a part of a plugin and the name of the plugin.
   * The array format is modelName => pluginName
   *
   * @todo This method is ugly and is a very weird way of finding the models which 
   *       belong to plugins. If we could come up with a better way that'd be great
   * @return array $pluginModels
   */
  public function getPluginModels()
  {
    if (!$this->pluginModels)
    {
      $plugins     = $this->generatorManager->getConfiguration()->getPlugins();
      $pluginPaths = $this->generatorManager->getConfiguration()->getAllPluginPaths();

      foreach ($pluginPaths as $pluginName => $path)
      {
        if (!in_array($pluginName, $plugins))
        {
          continue;
        }

        foreach (sfFinder::type('file')->name('*.php')->in($path.'/lib/model/doctrine') as $path)
        {
          $info = pathinfo($path);
          $e = explode('.', $info['filename']);
          $modelName = substr($e[0], 6, strlen($e[0]));

          if (class_exists($e[0]) && class_exists($modelName))
          {
            $parent = new ReflectionClass('Doctrine_Record');
            $reflection = new ReflectionClass($modelName);
            if ($reflection->isSubClassOf($parent))
            {
              $this->pluginModels[$modelName] = $pluginName;
              
              if ($reflection->isInstantiable())
              {
                $generators = Doctrine_Core::getTable($modelName)->getGenerators();
                foreach ($generators as $generator)
                {
                  $this->pluginModels[$generator->getOption('className')] = $pluginName;
                }  
              }
            }
          }
        }
      }
    }

    return $this->pluginModels;
  }

  /**
   * Check to see if a model is part of a plugin
   *
   * @param string $modelName 
   * @return boolean $bool
   */
  public function isPluginModel($modelName)
  {
    return isset($this->pluginModels[$modelName]) ? true:false;
  }

  /**
   * Get the name of the plugin a model belongs to
   *
   * @param string $modelName 
   * @return string $pluginName
   */
  public function getPluginNameForModel($modelName)
  {
    if ($this->isPluginModel($modelName))
    {
      return $this->pluginModels[$modelName];
    } else {
      return false;
    }
  }

  /**
   * Returns an array of relations that represents a many to many relationship.
   *
   * @return array An array of relations
   */
  public function getManyToManyRelations()
  {
    $relations = array();
    foreach ($this->table->getRelations() as $relation)
    {
      if (
        Doctrine_Relation::MANY == $relation->getType()
        &&
        isset($relation['refTable'])
        &&
        (null === $this->getParentModel() || !Doctrine_Core::getTable($this->getParentModel())->hasRelation($relation->getAlias()))
      )
      {
        $relations[] = $relation;
      }
    }

    return $relations;
  }

  /**
   * Returns PHP names for all foreign keys of the current table.
   *
   * This method does not returns foreign keys that are also primary keys.
   *
   * @return array An array composed of: 
   *                 * The foreign table PHP name
   *                 * The foreign key PHP name
   *                 * A Boolean to indicate whether the column is required or not
   *                 * A Boolean to indicate whether the column is a many to many relationship or not
   */
  public function getForeignKeyNames()
  {
    $names = array();
    foreach ($this->table->getRelations() as $relation)
    {
      if ($relation->getType() === Doctrine_Relation::ONE)
      {
        $foreignDef = $relation->getTable()->getDefinitionOf($relation->getForeignFieldName());
        $names[] = array($relation['table']->getOption('name'), $relation->getForeignFieldName(), $this->isColumnNotNull($relation->getForeignFieldName(), $foreignDef), false);
      }
    }

    foreach ($this->getManyToManyRelations() as $relation)
    {
      $names[] = array($relation['table']->getOption('name'), $relation['alias'], false, true);
    }

    return $names;
  }

  /**
   * Returns the first primary key column of the current table.
   *
   * @param ColumnMap A ColumnMap object
   */
  public function getPrimaryKey()
  {
    foreach ($this->getColumns() as $column)
    {
      if ($column->isPrimaryKey())
      {
        return $column;
      }
    }
  }

  /**
   * Returns a sfWidgetForm class name for a given column.
   *
   * @param  sfDoctrineColumn $column
   * @return string    The name of a subclass of sfWidgetForm
   */
  public function getWidgetClassForColumn($column)
  {
    switch ($column->getDoctrineType())
    {
      case 'string':
        $widgetSubclass = null === $column->getLength() || $column->getLength() > 255 ? 'Textarea' : 'InputText';
        break;
      case 'boolean':
        $widgetSubclass = 'InputCheckbox';
        break;
      case 'blob':
      case 'clob':
        $widgetSubclass = 'Textarea';
        break;
      case 'date':
        $widgetSubclass = 'Date';
        break;
      case 'time':
        $widgetSubclass = 'Time';
        break;
      case 'timestamp':
        $widgetSubclass = 'DateTime';
        break;
      case 'enum':
        $widgetSubclass = 'Choice';
        break;
      default:
        $widgetSubclass = 'InputText';
    }

    if ($column->isPrimaryKey())
    {
      $widgetSubclass = 'InputHidden';
    }
    else if ($column->isForeignKey())
    {
      $widgetSubclass = 'DoctrineChoice';
    }

    return sprintf('sfWidgetForm%s', $widgetSubclass);
  }

  /**
   * Returns a PHP string representing options to pass to a widget for a given column.
   *
   * @param sfDoctrineColumn $column
   * 
   * @return string The options to pass to the widget as a PHP string
   */
  public function getWidgetOptionsForColumn($column)
  {
    $options = array();

    if ($column->isForeignKey())
    {
      $options[] = sprintf('\'model\' => $this->getRelatedModelName(\'%s\'), \'add_empty\' => %s', $column->getRelationKey('alias'), $column->isNotNull() ? 'false' : 'true');
    }
    else if ('enum' == $column->getDoctrineType() && is_subclass_of($this->getWidgetClassForColumn($column), 'sfWidgetFormChoiceBase'))
    {
      $options[] = '\'choices\' => '.$this->arrayExport(array_combine($column['values'], $column['values']));
    }

    return count($options) ? sprintf('array(%s)', implode(', ', $options)) : '';
  }

  /**
   * Returns a sfValidator class name for a given column.
   *
   * @param sfDoctrineColumn $column
   * @return string    The name of a subclass of sfValidator
   */
  public function getValidatorClassForColumn($column)
  {
    switch ($column->getDoctrineType())
    {
      case 'boolean':
        $validatorSubclass = 'Boolean';
        break;
      case 'string':
    		if ($column->getDefinitionKey('email'))
    		{
    		  $validatorSubclass = 'Email';
    		}
    		else if ($column->getDefinitionKey('regexp'))
    		{
    		  $validatorSubclass = 'Regex';
    		}
    		else
    		{
    		  $validatorSubclass = 'String';
    		}
        break;
      case 'clob':
      case 'blob':
        $validatorSubclass = 'String';
        break;
      case 'float':
      case 'decimal':
        $validatorSubclass = 'Number';
        break;
      case 'integer':
        $validatorSubclass = 'Integer';
        break;
      case 'date':
        $validatorSubclass = 'Date';
        break;
      case 'time':
        $validatorSubclass = 'Time';
        break;
      case 'timestamp':
        $validatorSubclass = 'DateTime';
        break;
      case 'enum':
        $validatorSubclass = 'Choice';
        break;
      default:
        $validatorSubclass = 'Pass';
    }

    if ($column->isForeignKey())
    {
      $validatorSubclass = 'DoctrineChoice';
    }
    else if ($column->isPrimaryKey())
    {
      $validatorSubclass = 'Choice';
    }

    return sprintf('sfValidator%s', $validatorSubclass);
  }

  /**
   * Returns a PHP string representing options to pass to a validator for a given column.
   *
   * @param sfDoctrineColumn $column
   * @return string    The options to pass to the validator as a PHP string
   */
  public function getValidatorOptionsForColumn($column)
  {
    $options = array();

    if ($column->isForeignKey())
    {
      $options[] = sprintf('\'model\' => $this->getRelatedModelName(\'%s\')', $column->getRelationKey('alias'));
    }
    else if ($column->isPrimaryKey())
    {
      $options[] = sprintf('\'choices\' => array($this->getObject()->get(\'%s\')), \'empty_value\' => $this->getObject()->get(\'%1$s\')', $column->getFieldName());
    }
    else
    {
      switch ($column->getDoctrineType())
      {
        case 'string':
          if ($column['length'])
          {
            $options[] = sprintf('\'max_length\' => %s', $column['length']);
          }
          if (isset($column['minlength']))
          {
            $options[] = sprintf('\'min_length\' => %s', $column['minlength']);
          }
          if (isset($column['regexp']))
          {
            $options[] = sprintf('\'pattern\' => \'%s\'', $column['regexp']);
          }
          break;
        case 'enum':
          $options[] = '\'choices\' => '.$this->arrayExport($column['values']);
          break;
      }
    }

    // If notnull = false, is a primary or the column has a default value then
    // make the widget not required
    if (!$column->isNotNull() || $column->isPrimaryKey() || $column->hasDefinitionKey('default'))
    {
      $options[] = '\'required\' => false';
    }

    return count($options) ? sprintf('array(%s)', implode(', ', $options)) : '';
  }

  /**
   * Returns the maximum length for a column name.
   *
   * @return integer The length of the longer column name
   */
  public function getColumnNameMaxLength()
  {
    $max = 0;
    foreach ($this->getColumns() as $column)
    {
      if (($m = strlen($column->getFieldName())) > $max)
      {
        $max = $m;
      }
    }

    foreach ($this->getManyToManyRelations() as $relation)
    {
      if (($m = strlen($this->underscore($relation['alias']).'_list')) > $max)
      {
        $max = $m;
      }
    }

    return $max;
  }

  /**
   * Returns an array of primary key column names.
   *
   * @return array An array of primary key column names
   */
  public function getPrimaryKeyColumNames()
  {
    return $this->table->getIdentifierColumnNames();
  }

  /**
   * Returns a PHP string representation for the array of all primary key column names.
   *
   * @return string A PHP string representation for the array of all primary key column names
   *
   * @see getPrimaryKeyColumNames()
   */
  public function getPrimaryKeyColumNamesAsString()
  {
    return sprintf('array(\'%s\')', implode('\', \'', $this->getPrimaryKeyColumNames()));
  }

  /**
   * Returns true if the current table is internationalized.
   *
   * @return Boolean true if the current table is internationalized, false otherwise
   */
  public function isI18n()
  {
    return $this->table->hasRelation('Translation');
  }

  /**
   * Returns the i18n model name for the current table.
   *
   * @return string The model class name
   */
  public function getI18nModel()
  {
    return $this->table->getRelation('Translation')->getTable()->create();
  }

  public function underscore($name)
  {
    return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), '\\1_\\2', $name));
  }

  /**
   * Get array of sfDoctrineColumn objects that exist on the current model but not its parent.
   *
   * @return array $columns
   */
  public function getColumns()
  {
    $parentModel = $this->getParentModel();
    $parentColumns = $parentModel ? array_keys(Doctrine_Core::getTable($parentModel)->getColumns()) : array();

    $columns = array();
    foreach (array_diff(array_keys($this->table->getColumns()), $parentColumns) as $name)
    {
      $columns[] = new sfDoctrineColumn($name, $this->table);
    }

    return $columns;
  }

  public function getUniqueColumnNames()
  {
    $uniqueColumns = array();

    foreach ($this->getColumns() as $column)
    {
      if ($column->getDefinitionKey('unique'))
      {
        $uniqueColumns[] = array($column->getFieldName());
      }
    }

    $indexes = $this->table->getOption('indexes');
    foreach ($indexes as $name => $index)
    {
      $index['fields'] = (array) $index['fields'];

      if (isset($index['type']) && $index['type'] == 'unique')
      {
        $tmp = $index['fields'];
        if (is_array(array_shift($tmp)))
        {
          $uniqueColumns[] = array_keys($index['fields']);
        } else {
          $uniqueColumns[] = $index['fields'];
        }
      }
    }

    return $uniqueColumns;
  }

  /**
   * Loads all Doctrine builders.
   */
  protected function loadModels()
  {
    Doctrine_Core::loadModels($this->generatorManager->getConfiguration()->getModelDirs());
    $models = Doctrine_Core::getLoadedModels();
    $models =  Doctrine_Core::initializeModels($models);
    $models = Doctrine_Core::filterInvalidModels($models);
    $this->models = $this->filterModels($models);

    return $this->models;
  }

  /**
   * Filter out models that have disabled generation of form classes
   *
   * @return array $models Array of models to generate forms for
   */
  protected function filterModels($models)
  {
    foreach ($models as $key => $model)
    {
      $table = Doctrine_Core::getTable($model);
      $symfonyOptions = (array) $table->getOption('symfony');

      if ($table->isGenerator())
      {
        $symfonyOptions = array_merge((array) $table->getParentGenerator()->getOption('table')->getOption('symfony'), $symfonyOptions);
      }

      if (isset($symfonyOptions['form']) && !$symfonyOptions['form'])
      {
        unset($models[$key]);
      }
    }

    return $models;
  }

  /**
   * Array export. Export array to formatted php code
   *
   * @param array $values
   * @return string $php
   */
  protected function arrayExport($values)
  {
    $php = var_export($values, true);
    $php = str_replace("\n", '', $php);
    $php = str_replace('array (  ', 'array(', $php);
    $php = str_replace(',)', ')', $php);
    $php = str_replace('  ', ' ', $php);
    return $php;
  }

  /**
   * Returns the name of the model class this model extends.
   * 
   * @return string|null
   */
  public function getParentModel()
  {
    $baseClasses = array(
      'Doctrine_Record',
      'sfDoctrineRecord',
    );

    $builderOptions = sfConfig::get('doctrine_model_builder_options', array());
    if (isset($builderOptions['baseClassName']))
    {
      $baseClasses[] = $builderOptions['baseClassName'];
    }

    // find the first non-abstract parent
    $model = $this->modelName;
    while ($model = get_parent_class($model))
    {
      if (in_array($model, $baseClasses))
      {
        break;
      }

      $r = new ReflectionClass($model);
      if (!$r->isAbstract())
      {
        return $r->getName();
      }
    }
  }

  /**
   * Get the name of the form class to extend based on the inheritance of the model
   *
   * @return string
   */
  public function getFormClassToExtend()
  {
    return null === ($model = $this->getParentModel()) ? 'BaseFormDoctrine' : sprintf('%sForm', $model);
  }

    public function get() {

    }
    public function set() {

    }

  /**
     * Ayuda a traducir la fecha y hora actual del sistema en formato español.
     *
     * Por Oswaldo Rojas ~ Sáb, 27 Sep 2014 13:53:12
     * 
     * @param  date $date Recibe la fecha y hora actual ('Y-m-d H:i:s')
     * @param  boolean $complete Indica si los nombre de las fechas son
     * completas o abreviadas
     * @param  boolean $capital Indica los nombres de las fechas con letra 
     * capital
     * @return string Ej.: Lun, 01 Ene 1970 00:00:01
     */
    public function obtenerFechaYHoraEnEsp($date, $complete = true, $capital = true) {
        // Debido a que este proyecto de modificacion de symfony se realiza en
        // Ecuador se va a poner por default el timezone correspondiente, pero
        // sientete libre de cambiarlo a tu gusto (manualmente) ;-|
        date_default_timezone_set('America/Guayaquil');

        foreach ($this->_dias as $k => $v) { $this->_diasAbreviados[$k] = substr($v, 0, 3); }        
        array_unshift($this->_meses, '');
        foreach ($this->_meses as $k => $v) { $this->_mesesAbreviados[$k] = substr($v, 0, 3); }
        array_unshift($this->_mesesAbreviados, '');
        $dia    = explode('-', $date, 3);
        $year   = reset($dia);
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];
        $hms    = explode(' ', $dia[2], 2);
        $time   = (string) $hms[1];
        $dias   = $this->_dias;
        $dAbr   = $this->_diasAbreviados;
        $tdia   = $dias[intval((date('w', mktime(0, 0, 0, $month, $day, $year))))];
        $tAbr   = $dAbr[intval((date('w', mktime(0, 0, 0, $month, $day, $year))))];
        $meses  = $this->_meses;
        $mesAbr = $this->_mesesAbreviados;

        return $complete 
               ? ($capital 
                  ? ucfirst($tdia) 
                  : $tdia).", {$day} ".($capital 
                                        ? ucfirst($meses[$month]) 
                                        : $meses[$month])." {$year} {$time}"
               : ($capital 
                  ? ucfirst($tAbr) 
                  : $tAbr).", {$day} ".($capital 
                                        ? ucfirst($mesAbr[$month]) 
                                        : $mesAbr[$month])." {$year} {$time}";
    }

    /**
     * Funciones pequeñas para el registro de modificacion por parte del usuario
     * hacia el archivo ubicado en config/doctrine/schema.yml guardando fecha
     * y hora de actualizacion. Esta es mi personalizacion.
     */
    protected function ubicarEntre($contenido, $inicio, $fin) {
        $cadena = explode($inicio, $contenido);
        if (isset($cadena[1])) {
            $cadena = explode($fin, $cadena[1]);
            return reset($cadena);
        }

        return '';
    }
    
    protected function numeroDAcceso($valor) {
        $no = 0;
        switch (true):
            case $valor < 10: $no = '00000'.$valor; break;
            case $valor < 100: $no = '0000'.$valor; break;
            case $valor < 1000: $no = '000'.$valor; break;
            case $valor < 10000: $no = '00'.$valor; break;
            case $valor < 100000: $no = '0'.$valor; break;
            case $valor < 1000000: $no = ''.$valor; break;
        endswitch;
        /**
         * Exageradooo!!! 
         * mmm talvez, pero puede suceder.
         */
        return $no;
    }    
    /* ---------------------------------------------------------------------- */
}