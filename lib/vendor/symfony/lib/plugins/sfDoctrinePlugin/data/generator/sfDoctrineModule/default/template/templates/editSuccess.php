<div class="container">
            <div class="row">
                <div class="span12">
                    <h2>[?php echo link_to('<?=sfInflector::humanize($this->getModuleName())?>', '<?php echo $this->getModuleName() ?>/index') ?]</h2>
                    <hr>
[?php include_partial('form', array('form' => $form)) ?]
                </div>
            </div>
        </div><!-- /container -->
<?php echo str_repeat('        <br />'.PHP_EOL, 6) ?>
[?php include_partial('footer') ?]