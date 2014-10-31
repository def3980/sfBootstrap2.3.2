[?php use_stylesheet('bootstrap-select') ?]
[?php use_javascript('bootstrap-select') ?]
[?php use_stylesheet('bootstrap-datetimepicker.min.css') ?]
[?php use_javascript('bootstrap-datetimepicker') ?]
[?php use_javascript('locales/bootstrap-datetimepicker.es.js') ?]
[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
<?php 
    $form = $this->getFormObject();
    $con = 1;
    $tot = count($form) - 2; // porque -2, para eliminar por defecto id y csrf_token de la lista de conteo
    $objTabla = Doctrine_Core::getTable($this->getModelClass());
    $columns  = array(); $campoDateODateTime = $fk = array(); $flag = false;
    // Recorrido para obtener el acceso a los campos de la tabla indicada
    // ademas de los tipos de datos que tiene cada campo.
    foreach (array_diff(array_keys($objTabla->getColumns()), array()) as $name) {
        $columns[] = new sfDoctrineColumn($name, $objTabla);
    }
    foreach ($columns as $column) {
        if ('date' == $column->getDoctrineType() || 'timestamp' == $column->getDoctrineType()) {
            $campoDateODateTime[$column->getFieldName()] = $column->getDoctrineType();
        }
        if ($column->isForeignKey()) { // Valido los campos claves foraneos para adaptarle el plugin bootstrap-select
            $fk[$column->getFieldName()] = $column->getDoctrineType();
        }
    }
?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
<?php else: ?>
                    <form action="[?php echo url_for('<?php echo $this->getModuleName() ?>/'.
                                                ($form->getObject()->isNew() 
                                                    ? 'create' 
                                                    : 'update'
                                                ).(!$form->getObject()->isNew() 
                                                    ? '?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?> : '')) ?]" class="form-horizontal" method="post" autocomplete="off"[?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?]>
[?php if (!$form->getObject()->isNew()): ?]
                        <input type="hidden" name="sf_method" value="put" />
[?php endif; ?]
<?php endif;?>
<?php if (isset($this->params['non_verbose_templates']) && $this->params['non_verbose_templates']): ?>
                        [?php echo $form ?]
<?php else: ?>
                        <div class="row">
                            <div class="span6">
<?php   foreach ($form as $name => $field): if ($field->isHidden()) continue ?>
                                <div class="control-group">
                                    [?php echo $form['<?php echo $name ?>']->renderLabel('', array('class' => 'control-label')).PHP_EOL ?]
                                    <div class="controls">
<?php       foreach ($campoDateODateTime as $campo => $tipo):
                if ($field->getName() === $campo): $flag = true; ?>
                                        <div class="input-append date" id="dtp_<?=$field->renderId()?>">
[?php echo $form['<?php echo $name ?>']->renderError() ?]
                                            [?php echo $form['<?php echo $name ?>']->render(array('placeholder' => '<?php echo $name ?>', 'style' => 'width: 180px', 'readonly' => 'true')).PHP_EOL ?]
                                            <span class='add-on'>
                                                <i data-date-icon='icon-calendar' data-time-icon='icon-time'></i>
                                            </span>
                                        </div>
<?php           endif; ?>
<?php       endforeach; ?>
<?php       if (true !== $flag): ?>
[?php echo $form['<?php echo $name ?>']->renderError() ?]
                                        [?php echo $form['<?php echo $name ?>']->render(array('placeholder' => '<?php echo $name ?>')).PHP_EOL ?]
<?php       endif; $flag = false; ?>
                                    </div>
                                </div>
<?php       if ($con == ceil($tot / 2)): ?>
                            </div>
                            <div class="span6">                            
<?php       endif; $con += 1; ?>
<?php   endforeach; ?>
                            </div>
                        </div>
<?php endif; ?>
                        <hr style="margin: 0 0 20px 0" />
                        <div style="text-align: center">
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                            <a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]">Regresar a la lista</a>
<?php else: ?>
                            <a class="btn btn-small" href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index') ?]">Regresar</a>
<?php endif; ?>
                             |&nbsp;<button type="submit" class="btn btn-small btn-success" style="margin: 0 auto">Guardar</button>
[?php if (!$form->getObject()->isNew()): ?]
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                             |&nbsp;[?php echo link_to('Eliminar', '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => 'Estas seguro?')) ?]
<?php else: ?>
<?php /*&nbsp; | &nbsp;[?php echo link_to('Eliminar', '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => 'Estas seguro?', 'class' => 'btn btn-danger')).PHP_EOL ?]*/ ?>
                             |&nbsp;<button class="btn btn-small btn-danger" id="del">Eliminar</button>
<?php endif; ?>
[?php endif; ?]
                        </div>
[?php echo $form->renderGlobalErrors() ?]
<?php if (!isset($this->params['non_verbose_templates']) || !$this->params['non_verbose_templates']): ?>
[?php echo $form->renderHiddenFields(false).PHP_EOL ?]
<?php endif; ?>
                    </form>
[?php if (!$form->getObject()->isNew()): ?]
                    <!-- Modal -->
                    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="text-align: center">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 id="myModalLabel">Advertencia !!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Se va a proceder a eliminar un registro <br />con n&uacute;mero de identificador <code><?php echo $this->getFormObject()->getFormFieldSchema()->key() ?> = [?php echo $form['<?php echo $this->getFormObject()->getFormFieldSchema()->key() ?>']->getValue() ?]</code></p>
                            <p>Est&aacute;s seguro?</p>
                        </div>
                        <div class="modal-footer" style="text-align: center">
                            <button class="btn btn-small btn-danger">Aceptar</button>
                            <button class="btn btn-small" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        </div>
                    </div>
[?php endif; ?]
<?php 
// Aqui un caso especial. La eliminacion de un registro en Symfony 1.4.20
// genera una problematica que se detalla a continuacion: 
// El _csrf_token (que es una clave sha1 aleatoria con el cual se valida los formularios) 
// es reservado para el envio de formularios y para las peticiones 
// link_to (Helper que te ayuda a crear el link "<a href='#'>enlace</a>"). 
// Entonces, ¿si esto es reservado para estos items como poder usarlo desde 
// JQuery en cualquier template de nuestros modulos ?
// Ver la solucion: http://comunidad.fware.pro/general/csrf-token-en-symfony-y-jquery/#sthash.05aJLi2c.dpuf
// 
// Aqui el detalle de la solucion:
// Sin embargo instanciando BaseForm() hacia un objeto accedemos al token de la sesion del navegador
// Y podemos pasar la validacion checkCSRFProtection() ubicada en el actions.class.php del modulo en
// el que estemos trabajando.
//
// Para este caso de modificaciones de Symfony 1.4.20 con Bootstrap toco hacer dos tipos de casos
// con BaseForm(). Uno para validar la utilizacion en csrf_token al momento de crear el modulo
// con el comando doctrine:generate-module y otro para cuando ya en el modulo creado deseas eliminar
// el registro.
//
// Nota: Me tomo un dia averiguar esto... :-|
$token = new BaseForm();
$date = $time = $foreanKey = "";
foreach ($form as $name => $field): 
    foreach ($campoDateODateTime as $campo => $tipo):
        if ($field->getName() === $campo && $tipo == "date"): 
            $date .= "#dtp_{$field->renderId()}, ";
        elseif ($field->getName() === $campo && $tipo == "timestamp"): 
            $time .= "#dtp_{$field->renderId()}, ";
        endif;
    endforeach;
    if (count($fk)):
        foreach ($fk as $fkk => $fkv):
            if ($field->getName() === $fkk):
                $foreanKey .= "#{$field->renderId()}, ";
            endif;
        endforeach;
    endif;
endforeach; ?>
[?php slot('porcion_css') ?]
        <style>
            span.add-on .icon-calendar {
                background-position: -191px -118px;
            }
            span.add-on .icon-time {
                background-position: -47px -22px;
            }
            .opc {
                display: block;
                text-decoration: none;
                background-color: #eeeeee;
                border-color: #eeeeee #eeeeee #dddddd;
                color: #0088cc;
                padding-top: 8px;
                padding-bottom: 8px;
                margin-top: 2px;
                margin-bottom: 2px;
                padding-right: 12px;
                padding-left: 12px;
                margin-right: 2px;
                line-height: 14px;
                -webkit-border-radius: 5px;
                   -moz-border-radius: 5px;
                        border-radius: 5px;
            }
        </style>
[?php end_slot() ?]
[?php slot('porcion_js') ?]
        <script>
            $(function() {
                var inputDate = "<?php echo rtrim($date, ', ') ?>",
                    inputDateTime = "<?php echo rtrim($time, ', ') ?>"<?php if (count($fk)): ?>,
                    inputForeanKey = "<?php echo rtrim($foreanKey, ', ') ?>"<?php endif; ?>;
                $(inputDate).datetimepicker({
                    format : 'yyyy-MM-dd', language: 'es', pickTime: false
                });
                $(inputDateTime).datetimepicker({ 
                    format : 'yyyy-MM-dd hh:mm:ss', language: 'es' 
                });
[?php if (!$form->getObject()->isNew()): $token = new BaseForm(); ?]
                // para abrir el modal
                $('#del').bind('click', function(e) {
                    e.preventDefault();
                    $('#myModal').modal({
                        keyboard : false
                    });
                });
                
                // para borrar el registro ~[?php echo sfConfig::get('sf_csrf_secret') ?]~
                $('#myModal div:last .btn-danger').bind('click', function() {
                    $('#myModal').find('div:last').append(
                        $('<form/>', { 
                            action : '[?php echo url_for('<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>) ?]', 
                            method : 'post',
                            style  : 'display: none'
                        }).append(
                            $('<input />', {
                                type  : 'hidden',
                                name  : 'sf_method',
                                value : 'delete'
                            })<?php if ($token->isCSRFProtected()): ?>,
                            $('<input />', {
                                type  : 'hidden',
                                name  : '[?=$token->getCSRFFieldName()?]',
                                value : '[?=$token->getCSRFToken()?]'
                            })<?php echo PHP_EOL; endif; ?>
                        )
                    ).find('form').submit();
                });
[?php endif; ?]
<?php if (count($fk)): ?>
                // activando bootstrap-select en los campos que son claves foreaneas
                $(inputForeanKey).selectpicker({
                    size : 5
                });
<?php endif; ?>
            });
        </script>
[?php end_slot() ?]
