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
        $arrayFechaYHora = array();
        $lon = 0;
        foreach ($this->getColumns() as $column):
            if ('date' == $column->getDoctrineType() || 'timestamp' == $column->getDoctrineType()):
                $fecha_o_fecha_y_hora = true;
                $arrayFechaYHora[] = $column->getFieldName(); 
                $lon = strlen($column->getFieldName()) > $lon ? strlen($column->getFieldName()) : $lon;
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
<?php       foreach ($arrayFechaYHora as $column): ?>
        $this->widgetSchema['<?php echo $column ?>']<?php echo str_repeat(' ', ($lon + 23) - (strlen($column) + 23)) ?> = new sfWidgetFormInputText();
<?php       endforeach; ?>
    }
<?php   endif; ?>
<?php endif; ?>

}