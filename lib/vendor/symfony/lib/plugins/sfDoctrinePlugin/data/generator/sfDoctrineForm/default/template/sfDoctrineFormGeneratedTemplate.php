[?php

/**
 * <?php echo $this->modelName ?> clase base de formulario.
 *
 * @method <?php echo $this->modelName ?> getObject() Retorna el objeto actual del modelo del formulario
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
 
/**
 * Fecha creacion : "<?php echo !$this->_existeArchivo 
                                ? $this->obtenerFechaYHoraEnEsp(date('Y-m-d H:i:s'))
                                : $this->_fechaYHora  ?>"
 * 
 * Acciones realizadas:
 * - Veces ejecutado doctrine:build-model  : "000000"
 * - Ultima vez que se actualizo el modelo : "yyyy-mm-dd_hh:mm:ss"
 */
abstract class Base<?php echo $this->modelName ?>Form extends <?php echo $this->getFormClassToExtend() ?> {

    public function setup() {
        $this->setWidgets(array(
<?php foreach ($this->getColumns() as $column): ?>
            '<?php echo $column->getFieldName() ?>'<?php echo str_repeat(' ', $this->getColumnNameMaxLength() - strlen($column->getFieldName())) ?> => new <?php echo $this->getWidgetClassForColumn($column) ?>(<?php echo $this->getWidgetOptionsForColumn($column) ?>),
<?php endforeach; ?>
<?php foreach ($this->getManyToManyRelations() as $relation): ?>
            '<?php echo $this->underscore($relation['alias']) ?>_list'<?php echo str_repeat(' ', $this->getColumnNameMaxLength() - strlen($this->underscore($relation['alias']).'_list')) ?> => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => '<?php echo $relation['table']->getOption('name') ?>')),
<?php endforeach; ?>
        ));

        $this->setValidators(array(
<?php foreach ($this->getColumns() as $column): ?>
            '<?php echo $column->getFieldName() ?>'<?php echo str_repeat(' ', $this->getColumnNameMaxLength() - strlen($column->getFieldName())) ?> => new <?php echo $this->getValidatorClassForColumn($column) ?>(<?php echo $this->getValidatorOptionsForColumn($column) ?>),
<?php endforeach; ?>
<?php foreach ($this->getManyToManyRelations() as $relation): ?>
            '<?php echo $this->underscore($relation['alias']) ?>_list'<?php echo str_repeat(' ', $this->getColumnNameMaxLength() - strlen($this->underscore($relation['alias']).'_list')) ?> => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => '<?php echo $relation['table']->getOption('name') ?>', 'required' => false)),
<?php endforeach; ?>
        ));

<?php if ($uniqueColumns = $this->getUniqueColumnNames()): ?>
        $this->validatorSchema->setPostValidator(
<?php if (count($uniqueColumns) > 1): ?>
            new sfValidatorAnd(array(
<?php foreach ($uniqueColumns as $uniqueColumn): ?>
                new sfValidatorDoctrineUnique(array('model' => '<?php echo $this->table->getOption('name') ?>', 'column' => array('<?php echo implode("', '", $uniqueColumn) ?>'))),
<?php endforeach; ?>
            ))
<?php else: ?>
            new sfValidatorDoctrineUnique(array('model' => '<?php echo $this->table->getOption('name') ?>', 'column' => array('<?php echo implode("', '", $uniqueColumns[0]) ?>')))
<?php endif; ?>
        );

<?php endif; ?>
        $this->widgetSchema->setNameFormat('<?php echo $this->underscore($this->modelName) ?>[%s]');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        $this->setupInheritance();

        parent::setup();
    }

    public function getModelName() {
        return '<?php echo $this->modelName ?>';
    }

<?php if ($this->getManyToManyRelations()): ?>
    public function updateDefaultsFromObject() {
        parent::updateDefaultsFromObject();

<?php foreach ($this->getManyToManyRelations() as $relation): ?>
        if (isset($this->widgetSchema['<?php echo $this->underscore($relation['alias']) ?>_list'])) {
            $this->setDefault('<?php echo $this->underscore($relation['alias']) ?>_list', $this->object-><?php echo $relation['alias']; ?>->getPrimaryKeys());
        }

<?php endforeach; ?>
    }

    protected function doSave($con = null) {
<?php foreach ($this->getManyToManyRelations() as $relation): ?>
        $this->save<?php echo $relation['alias'] ?>List($con);
<?php endforeach; ?>

        parent::doSave($con);
    }

<?php foreach ($this->getManyToManyRelations() as $relation): ?>
    public function save<?php echo $relation['alias'] ?>List($con = null) {
        if (!$this->isValid()) {
            throw $this->getErrorSchema();
        }

        if (!isset($this->widgetSchema['<?php echo $this->underscore($relation['alias']) ?>_list'])) {
            // somebody has unset this widget
            return;
        }

        if (null === $con) {
            $con = $this->getConnection();
        }

        $existing = $this->object-><?php echo $relation['alias']; ?>->getPrimaryKeys();
        $values = $this->getValue('<?php echo $this->underscore($relation['alias']) ?>_list');
        if (!is_array($values)) {
            $values = array();
        }

        $unlink = array_diff($existing, $values);
        if (count($unlink)) {
            $this->object->unlink('<?php echo $relation['alias'] ?>', array_values($unlink));
        }

        $link = array_diff($values, $existing);
        if (count($link)) {
            $this->object->link('<?php echo $relation['alias'] ?>', array_values($link));
        }
    }
<?php endforeach; ?>
<?php endif; ?>
}