<?php slot('titulo', 'Sticky footer &middot; Twitter Bootstrap') ?>
<?php slot('porcion_css') ?>
        <style type="text/css">
            /* Sticky footer styles -------------------------------------------------- */
            html, body {
                height: 100%;
                /* The html and body elements cannot have any padding or margin. */
            }
            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by it's height */
                margin: 0 auto -60px;
            }
            /* Set the fixed height of the footer here */
            #push, #footer {
                height: 60px;
            }
            #footer {
                background-color: #f5f5f5;
            }
            /* Lastly, apply responsive CSS fixes as necessary */
            @media (max-width: 767px) {
                #footer {
                    margin-left: -20px;
                    margin-right: -20px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
            }
            /* Custom page CSS -------------------------------------------------- */
            /* Not required for template or sticky footer method. */
            #wrap > .container {
                padding-top: 60px;
            }
            .container .credit {
                margin: 20px 0;
            }
            code {
                font-size: 80%;
            }
        </style>
<?php end_slot() ?>
<!-- Part 1: Wrap all page content here -->
        <div id="wrap">
            <!-- Fixed navbar -->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="brand" href="#">Project name</a>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="active"><a href="#">Home</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#contact">Contact</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li class="nav-header">Nav header</li>
                                        <li><a href="#">Separated link</a></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1>Sticky footer with fixed navbar</h1>
                </div>
                <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added within <code>#wrap</code> with <code>padding-top: 60px;</code> on the <code>.container</code>.</p>
                <p>Back to <?=link_to('the sticky footer', '@bootstrap2_examples_sticky_footer')?> minus the navbar.</p>
            </div>
            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit">Example courtesy <?=link_to('Martin Bean', 'http://martinbean.co.uk')?> and <?=link_to('Ryan Fait', 'http://ryanfait.com/sticky-footer/')?>.</p>
            </div>
        </div>