                <div id="carbonads-container">
                    <div class="carbonad"<?php echo $home ? ' style="text-align: center !important"' : '' ?>>
                        <div id="azcarbon">
                            <?php 
                                if (!$home):
                                    echo image_tag('venom_avatar_260x120', array('class' => 'img-rounded')).PHP_EOL;
                                else:
                                    for ( $i = 1 ; $i < 5 ; $i += 1 ):
                                        echo $i === 1
                                             ? image_tag('venom_avatar_260x120', array('class' => 'img-rounded')).PHP_EOL
                                             : "\t\t\t    ".image_tag('venom_avatar_260x120', array('class' => 'img-rounded')).PHP_EOL;
                                    endfor;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
