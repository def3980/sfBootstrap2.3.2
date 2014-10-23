[?php

/**
 * <?php echo $this->table->getOption('name') ?> formulario.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

/**
 * Fecha creacion : "<?=$this->_fechaYHora?>"
 */
class <?php echo $this->table->getOption('name') ?>Form extends Base<?php echo $this->table->getOption('name') ?>Form {

<?php if ($parent = $this->getParentModel()): ?>
    /**
     * @see <?php echo $parent ?>Form
     */
    public function configure() {
        parent::configure();
    }
<?php else: ?>
<?php
        $fecha_o_fecha_y_hora = false;
        foreach ($this->getColumns() as $column):
            if ('date' == $column->getDoctrineType() || 'timestamp' == $column->getDoctrineType()):
                $fecha_o_fecha_y_hora = true;
                break;
            endif;
        endforeach;
?>
<?php   if (!$fecha_o_fecha_y_hora): ?>
    public function configure() {}
<?php   else: ?>
    public function configure() {
        // Personalizo los widget asociados a date o datetime de acuerdo al tipo
        // de dato obtenido desde la base de datos. Esto debido a que el widget
        // por defecto de Symfony no se ve amigable para el usuario y con esto
        // se podra aplicar el plugin bootstrap-datetimepicker.
        // Nota: se puede eliminar las siguientes lineas de codigo y volver al
        // estado normal del framework.
<?php       foreach ($this->getColumns() as $column): ?>
<?php           if ('date' == $column->getDoctrineType() || 'timestamp' == $column->getDoctrineType()): ?>
        $this->widgetSchema['<?php echo $column->getFieldName() ?>']<?php echo str_repeat(' ', ($this->getColumnNameMaxLength() + 23) - (strlen($column->getFieldName()) + 23)) ?> = new sfWidgetFormInputText();
<?php           endif; ?>
<?php       endforeach; ?>
    }
<?php   endif; ?>
<?php endif; ?>

}