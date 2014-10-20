<?php $con = 0; ?>
<!-- Navbar ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="[?php echo url_for('@homepage') ?]">Bootstrap</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="[?php echo url_for('@homepage') ?]">Home</a></li>
                            <li class="active">[?php echo link_to('<?=sfInflector::humanize($this->getModuleName())?>', '<?php echo $this->getModuleName() ?>/index') ?]</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Subhead ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?=sfInflector::humanize($this->getPluralName())?></h1>
                <p class="lead">Vista principal de datos de la tabla <?=$this->getPluralName()?></p>
            </div>
        </header>
        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <div class="page-header"><h2>Descripci&oacute;n</h2></div>
                    <p>Este es un detalle de todos los campos que comprenden la tabla <?=$this->getModelClass()?> que ya incluye un paginador por defecto para filas y campos de ser necesario.</p>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
<?php foreach ($this->getColumns() as $column): $con += 1; ?>
                                <th<?php echo 1 === $con ? ' style="text-align: center"' : '' ?>><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?></th>
<?php if ($con >= 5): $con = 0; break; endif; endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>[?php if ($<?php echo $this->getPluralName() ?>->count()): foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): echo PHP_EOL; ?]
                            <tr>
<?php foreach ($this->getColumns() as $column): $con += 1; ?>
<?php   if ($column->isPrimaryKey()): ?>
<?php       if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                                <td><a href="[?php echo url_for('<?php echo $this->getUrlForAction(isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit') ?>', $<?php echo $this->getSingularName() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</a></td>
<?php       else: ?>
                                <td><a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/<?php echo isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit' ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</a></td>
<?php       endif; ?>
<?php   else: ?>
                                <td>[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</td>
<?php   endif; ?>
<?php if ($con >= 5): $con = 0; break; endif; endforeach; ?>
                            </tr>[?php endforeach; echo PHP_EOL; ?]
[?php else: echo PHP_EOL; ?]
                            <tr>
<?php foreach ($this->getColumns() as $column): $con += 1; ?>
                                <td>-</td>
<?php if ($con >= 5): $con = 0; break; endif; endforeach; ?>
                            </tr>[?php endif; ?]
                        </tbody>
                    </table>
                </div>
            </div>
        </div>