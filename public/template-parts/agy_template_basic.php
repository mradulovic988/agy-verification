<?php
include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
$agy_dashboard = new Agy_Dashboard();

if(!isset($_COOKIE['agy_verification'])) { ?>
    <div id="agy-my-modal" class="agy-modal">
        <div style="<?= $agy_dashboard->template_styling('', '', 'background_color') ?>" class="agy-modal-content">
            <div class="agy-headline">
                <p style="<?= $agy_dashboard->template_styling('', 'headline_color') ?>">
                    <?php echo $agy_dashboard->options_check('headline') ?>
                </p>
                <div class="agy-separator-horizontal-line"></div>
            </div>
            <div class="agy-subtitle">
                <p style="<?= $agy_dashboard->template_styling('', 'subtitle_color') ?>">
                    <?php echo $agy_dashboard->options_check('subtitle') ?>
                </p>
            </div>
            <div class="agy-description">
                <p style="<?= $agy_dashboard->template_styling('', 'message_color') ?>">
                    <?php echo $agy_dashboard->options_check('message') ?>
                </p>
            </div>
            <div class="agy-enter-btn">
                <button style="<?= $agy_dashboard->template_styling('', 'btn_font_color', 'btn_background_color') ?>" type="button">
                    <?php echo $agy_dashboard->options_check('enter_btn') ?>
                </button>
            </div>
            <div class="agy-separator">
                <p style="<?= $agy_dashboard->template_styling('', 'separator_color') ?>">
                    <?php echo $agy_dashboard->options_check('separator_text') ?>
                </p>
            </div>
            <div class="agy-exit-btn">
                <a href="<?php echo $agy_dashboard->options_check('exit_url') ?>">
                    <button style="<?= $agy_dashboard->template_styling('', 'exit_btn_font_color', 'exit_btn_background_color') ?>" type="button"><?php echo $agy_dashboard->options_check('exit_btn') ?></button>
                </a>
            </div>
            <div class="agy-footer">
                <p style="<?= $agy_dashboard->template_styling('', 'slogan_color') ?>">
                    <?php echo $agy_dashboard->options_check('slogan') ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>