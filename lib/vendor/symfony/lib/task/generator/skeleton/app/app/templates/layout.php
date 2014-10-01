<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php include_slot('titulo', 'Bootstrap') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->        
<?php 
/*print   
    "\t".stylesheet_tag(assets_css_path('css/bootstrap'), array('bootstrap' => true)).
    "\t".stylesheet_tag(assets_css_path('css/bootstrap-responsive'), array('bootstrap' => true)).
    "\t".stylesheet_tag(assets_css_path('css/docs'), array('bootstrap' => true)).
    "\t".stylesheet_tag(assets_css_path('js/google-code-prettify/prettify'), array('bootstrap' => true));*/
?>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <?php //echo javascript_include_tag(assets_javascript_path('js/html5shiv'), array('bootstrap' => true)) ?>
        <![endif]-->

        <!-- Le fav and touch icons -->
<?php
//print   
//    "\t".stylesheet_tag(assets_css_path('ico/apple-touch-icon-144-precomposed.png'), array(
//            'rel'       => 'apple-touch-icon-precomposed',
//            'sizes'     => '144x144',
//            'bootstrap' => true
//        )).
//    "\t".stylesheet_tag(assets_css_path('ico/apple-touch-icon-114-precomposed.png'), array(
//            'rel'       => 'apple-touch-icon-precomposed',
//            'sizes'     => '114x114',
//            'bootstrap' => true
//        )).
//    "\t ".stylesheet_tag(assets_css_path('ico/apple-touch-icon-72-precomposed.png'), array(
//            'rel'       => 'apple-touch-icon-precomposed',
//            'sizes'     => '72x72',
//            'bootstrap' => true
//        )).
//    "\t ".stylesheet_tag(assets_css_path('ico/apple-touch-icon-57-precomposed.png'), array(
//            'rel'       => 'apple-touch-icon-precomposed',
//            'bootstrap' => true
//        )).
//    "\t                              ".stylesheet_tag(assets_css_path('ico/favicon.png'), array(
//            'rel'       => 'shortcut icon',
//            'bootstrap' => true
//        ));
?>

        <!-- inclucion librerias adicionales -->
<?php 
    include_http_metas();
    include_metas();
    include_stylesheets();
    include_javascripts();
?>
        <!-- // fin de la inclucion -->
    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <?php echo $sf_content."\n" ?>
        <!-- Librerias javascript/jQuery ============================== -->
        <!-- Ubicamos al final del documento asi se cargaran mas rapido -->
<?php
print
    "\t".javascript_include_tag(assets_javascript_path('js/widgets'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/jquery'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-transition'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-alert'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-modal'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-dropdown'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-scrollspy'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-tab'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-tooltip'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-popover'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-button'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-collapse'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-carousel'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-typeahead'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/bootstrap-affix'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/holder/holder'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/google-code-prettify/prettify'), array('bootstrap' => true)).
    "\t".javascript_include_tag(assets_javascript_path('js/application'), array('bootstrap' => true));
?>
    </body>
</html>