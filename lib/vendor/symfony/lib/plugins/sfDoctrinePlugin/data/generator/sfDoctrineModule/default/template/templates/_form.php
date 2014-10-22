[?php use_stylesheet('bootstrap-datepicker') ?]
[?php use_javascript('bootstrap-datepicker') ?]
[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
<?php $form = $this->getFormObject() ?>
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
<?php else: 
    $con = 1;
    $tot = count($form) - 2; // porque -2, para eliminar por defecto id y csrf_token de la lista de conteo
?>
                        <div class="row">
                            <div class="span6">
<?php   foreach ($form as $name => $field): if ($field->isHidden()) continue ?>
                                <div class="control-group">
                                    [?php echo $form['<?php echo $name ?>']->renderLabel('', array('class' => 'control-label')).PHP_EOL ?]
                                    <div class="controls">
[?php echo $form['<?php echo $name ?>']->renderError() ?]
                                        [?php echo $form['<?php echo $name ?>']->render(array('placeholder' => '<?php echo $name ?>')).PHP_EOL ?]
                                    </div>
                                </div>
<?php       if ($con == ceil($tot / 2)): ?>
                            </div>
                            <div class="span6">                            
<?php       endif; $con += 1; ?>
<?php   endforeach; ?>
                            </div>
<?php endif; ?>
                        </div>
                        <hr style="margin: 0 0 20px 0" />
                        <div style="text-align: center">
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                            <a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]">Regresar a la lista</a>
<?php else: ?>
                            <a class="btn" href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index') ?]">Regresar</a>
<?php endif; ?>
                            &nbsp; | &nbsp;<button type="submit" class="btn btn-success" style="margin: 0 auto">Guardar</button>&nbsp; | &nbsp;
[?php if (!$form->getObject()->isNew()): ?]
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                            [?php echo link_to('Eliminar', '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => 'Estas seguro?')) ?]
<?php else: ?>
                            [?php echo link_to('Eliminar', '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => 'Estas seguro?', 'class' => 'btn btn-danger')).PHP_EOL ?]
<?php endif; ?>
                        </div>
[?php endif; ?]
[?php echo $form->renderGlobalErrors() ?]
<?php if (!isset($this->params['non_verbose_templates']) || !$this->params['non_verbose_templates']): ?>
[?php echo $form->renderHiddenFields(false).PHP_EOL ?]
<?php endif; ?>
                    </form>
[?php slot('porcion_js') ?]
        <script>
            $(function() {
<?php foreach ($form as $name => $field): ?>
<?php   if($field->renderId() == 'dml_personas_pe_fecha_nacimiento'): ?>
                $('#<?=$field->renderId()?>').datepicker({
                    format : 'yyyy-mm-dd'
                });
<?php   endif; ?>
<?php endforeach; ?>
            });
        </script>
[?php end_slot() ?]
