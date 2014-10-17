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
 * Fecha creacion : "<?php echo !$this->_existeArchivo 
                                ? $this->obtenerFechaYHoraEnEsp(date('Y-m-d H:i:s'))
                                : $this->_fechaYHora  ?>"
 * 
 * Acciones realizadas:
 * - Veces ejecutado doctrine:build-model  : "<?php echo !$this->_actualizarFechaYHora
                                                         ? str_repeat('0', 6) 
                                                         : $this->_numeracion ?>"
 * - Ultima vez que se actualizo el modelo : "<?php echo !$this->_actualizarFechaYHora
                                                         ? 'yyyy-mm-dd_hh:mm:ss'
                                                         : $this->obtenerFechaYHoraEnEsp(date('Y-m-d H:i:s')) ?>"
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
    public function configure() {}
<?php endif; ?>

}