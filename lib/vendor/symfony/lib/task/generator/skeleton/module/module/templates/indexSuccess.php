<!-- Navbar ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo link_to('Bootstrap', '@bootstrap2_index', array('class' => 'brand')).PHP_EOL ?>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><?php echo link_to('Home', '@bootstrap2_index') ?></li>
                            <li class=""><?php echo link_to('Get started', '@bootstrap2_getting_started') ?></li>
                            <li class=""><?php echo link_to('Scaffolding', '@bootstrap2_scaffolding') ?></li>
                            <li class=""><?php echo link_to('Base CSS', '@bootstrap2_base_css') ?></li>
                            <li class=""><?php echo link_to('Components', '@bootstrap2_components') ?></li>
                            <li class=""><?php echo link_to('JavaScript', '@bootstrap2_javascript') ?></li>
                            <li class=""><?php echo link_to('Customize', '@bootstrap2_customize') ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="jumbotron masthead">
            <div class="container">
                <h1>Bootstrap</h1>
                <p>Sleek, intuitive, and powerful front-end framework for faster and easier web development.</p>
                <p>
                    <a href="assets/bootstrap.zip" class="btn btn-primary btn-large" onclick="">Download Bootstrap</a>
                </p>
                <ul class="masthead-links">
                    <li>
                        <?php echo link_to('GitHub project', 'https://github.com/twbs/bootstrap', array('onclick' => null)).PHP_EOL ?>
                    </li>
                    <li>
                        <a href="./getting-started.html#examples" onclick="">Examples</a>
                    </li>
                    <li>
                        <a href="./extend.html" onclick="">Extend</a>
                    </li>
                    <li>Version 2.3.2</li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="alert alert-danger bs-alert-old-docs">
                <strong>Heads up!</strong> These docs are for v2.3.2, which is no longer officially supported. <a href="http://getbootstrap.com">Check out the latest version of Bootstrap!</a>
            </div>
            <div class="marketing">
                <h1>Introducing Bootstrap.</h1>
                <p class="marketing-byline">Need reasons to love Bootstrap? Look no further.</p>
                <div class="row-fluid">
                    <div class="span4">
                        <?php echo image_tag('bs-docs-twitter-github', array('class' => 'marketing-img')).PHP_EOL ?>
                        <h2>By nerds, for nerds.</h2>
                        <p>Built at Twitter by <?=link_to('@mdo', 'http://twitter.com/mdo')?> and <?=link_to('@fat', 'http://twitter.com/fat')?>, Bootstrap utilizes <?=link_to('LESS CSS', 'http://lesscss.org')?>, is compiled via <?=link_to('Node', 'http://nodejs.org') ?>, and is managed through <?=link_to('GitHub', 'http://github.com')?> to help nerds do awesome stuff on the web.</p>
                    </div>
                    <div class="span4">
                        <?php echo image_tag('bs-docs-responsive-illustrations', array('class' => 'marketing-img')).PHP_EOL ?>
                        <h2>Made for everyone.</h2>
                        <p>Bootstrap was made to not only look and behave great in the latest desktop browsers (as well as IE7!), but in tablet and smartphone browsers via <a href="./scaffolding.html#responsive">responsive CSS</a> as well.</p>
                    </div>
                    <div class="span4">
                        <?php echo image_tag('bs-docs-bootstrap-features', array('class' => 'marketing-img')).PHP_EOL ?>
                        <h2>Packed with features.</h2>
                        <p>A 12-column responsive <a href="./scaffolding.html#gridSystem">grid</a>, dozens of components, <a href="./javascript.html">JavaScript plugins</a>, typography, form controls, and even a <a href="./customize.html">web-based Customizer</a> to make Bootstrap your own.</p>
                    </div>
                </div>
                <hr class="soften">
                <h1>Built with Bootstrap.</h1>
                <p class="marketing-byline">For even more sites built with Bootstrap, <a href="http://builtwithbootstrap.tumblr.com/" target="_blank">visit the unofficial Tumblr</a> or <a href="./getting-started.html#examples">browse the examples</a>.</p>
                <div class="row-fluid">
                    <ul class="thumbnails example-sites">
                        <li class="span3">
                            <?php echo link_to(
                                        image_tag('example-sites/soundready', array('alt' => 'SoundReady.fm')),
                                        'http://soundready.fm/',
                                        array('class' => 'thumbnail', 'target' => '_blank')
                                       ).PHP_EOL ?>
                        </li>
                        <li class="span3">
                            <a class="thumbnail" href="http://kippt.com/" target="_blank">
                                <?php echo image_tag('example-sites/kippt', array('alt' => 'Kippt')).PHP_EOL ?>
                            </a>
                        </li>
                        <li class="span3">
                            <?php echo link_to(
                                        image_tag('example-sites/gathercontent', array('alt' => 'Gather Content')),
                                        'http://www.gathercontent.com/',
                                        array('class' => 'thumbnail', 'target' => '_blank')
                                       ).PHP_EOL ?>
                        </li>
                        <li class="span3">
                            <?php echo link_to(
                                        image_tag('example-sites/jshint', array('alt' => 'JS Hint')),
                                        'http://www.jshint.com/',
                                        array('class' => 'thumbnail', 'target' => '_blank')
                                       ).PHP_EOL ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
<?php include_partial('bootstrap_footer') ?>