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
                        <li class=""><a href="./scaffolding.html">Scaffolding</a></li>
                        <li class=""><a href="./base-css.html">Base CSS</a></li>
                        <li class=""><a href="./components.html">Components</a></li>
                        <li class=""><a href="./javascript.html">JavaScript</a></li>
                        <li class=""><a href="./customize.html">Customize</a></li>
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
                    <a href="https://github.com/twbs/bootstrap" onclick="">GitHub project</a>
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
    <br />
    <div class="container">
        <div class="alert alert-danger bs-alert-old-docs">
            <strong>Heads up!</strong> These docs are for v2.3.2, which is no longer officially supported. <a href="http://getbootstrap.com">Check out the latest version of Bootstrap!</a>
        </div>
        <div class="marketing">
            <h1>Introducing Bootstrap.</h1>
            <p class="marketing-byline">Need reasons to love Bootstrap? Look no further.</p>
            <div class="row-fluid">
                <div class="span4">
                    <?php echo image_tag(assets_css_path('img/bs-docs-twitter-github.png'), array('class' => 'marketing-img')).PHP_EOL ?>
                    <h2>By nerds, for nerds.</h2>
                    <p>Built at Twitter by <a href="http://twitter.com/mdo">@mdo</a> and <a href="http://twitter.com/fat">@fat</a>, Bootstrap utilizes <a href="http://lesscss.org">LESS CSS</a>, is compiled via <a href="http://nodejs.org">Node</a>, and is managed through <a href="http://github.com">GitHub</a> to help nerds do awesome stuff on the web.</p>
                </div>
                <div class="span4">
                    <?php echo image_tag(assets_css_path('img/bs-docs-responsive-illustrations.png'), array('class' => 'marketing-img')).PHP_EOL ?>
                    <h2>Made for everyone.</h2>
                    <p>Bootstrap was made to not only look and behave great in the latest desktop browsers (as well as IE7!), but in tablet and smartphone browsers via <a href="./scaffolding.html#responsive">responsive CSS</a> as well.</p>
                </div>
                <div class="span4">
                    <?php echo image_tag(assets_css_path('img/bs-docs-bootstrap-features.png'), array('class' => 'marketing-img')).PHP_EOL ?>
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
                        <a class="thumbnail" href="http://soundready.fm/" target="_blank">
                            <?php echo image_tag(assets_css_path('img/example-sites/soundready.png'), array('alt' => 'SoundReady.fm')).PHP_EOL ?>
                        </a>
                    </li>
                    <li class="span3">
                        <a class="thumbnail" href="http://kippt.com/" target="_blank">
                            <?php echo image_tag(assets_css_path('img/example-sites/kippt.png'), array('alt' => 'Kippt')).PHP_EOL ?>
                        </a>
                    </li>
                    <li class="span3">
                        <a class="thumbnail" href="http://www.gathercontent.com/" target="_blank">
                            <?php echo image_tag(assets_css_path('img/example-sites/gathercontent.png'), array('alt' => 'Gather Content')).PHP_EOL ?>
                        </a>
                    </li>
                    <li class="span3">
                        <a class="thumbnail" href="http://www.jshint.com/" target="_blank">
                            <?php echo image_tag(assets_css_path('img/example-sites/jshint.png'), array('alt' => 'JS Hint')).PHP_EOL ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer ================================================== -->
    <footer class="footer">
        <div class="container">
            <p>Designed and built with all the love in the world by <a href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a href="http://twitter.com/fat" target="_blank">@fat</a>.</p>
            <p>Code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
            <p><a href="http://glyphicons.com">Glyphicons Free</a> licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
            <ul class="footer-links">
                <li><a href="http://blog.getbootstrap.com">Blog</a></li>
                <li class="muted">&middot;</li>
                <li><a href="https://github.com/twbs/bootstrap/issues?state=open">Issues</a></li>
                <li class="muted">&middot;</li>
                <li><a href="https://github.com/twbs/bootstrap/releases">Changelog</a></li>
            </ul>
        </div>
    </footer>