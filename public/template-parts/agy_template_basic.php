<?php
include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
$agy_dashboard = new Agy_Dashboard();

if(!isset($_COOKIE['agy_verification'])) { ?>
    <div id="agy-my-modal" class="agy-modal">
        <div class="agy-modal-content">
            <div class="agy-headline">
<!--                <p style="--><?php //$agy_dashboard->template_styling('', 'headline_color','') ?><!--">--><?php //echo $agy_dashboard->options_check('headline') ?><!--</p>-->

                <p style=""><?php echo $agy_dashboard->options_check('headline') ?></p>
            </div>
            <div class="agy-subtitle">
                <p><?php echo $agy_dashboard->options_check('subtitle') ?></p>
            </div>
            <div class="agy-description">
                <p><?php echo $agy_dashboard->options_check('message') ?></p>
            </div>
            <div class="agy-enter-btn">
                <button type="button"><?php echo $agy_dashboard->options_check('enter_btn') ?></button>
            </div>
            <div class="agy-separator">
                <p><?php echo $agy_dashboard->options_check('separator_text') ?></p>
            </div>
            <div class="agy-exit-btn">
                <a href="<?php echo $agy_dashboard->options_check('exit_url') ?>"><?php echo $agy_dashboard->options_check('exit_btn') ?></a>
            </div>
            <div class="agy-footer">
                <p><?php echo $agy_dashboard->options_check('slogan') ?></p>
            </div>
        </div>
    </div>
<?php } ?>