<?php 
    
?>
<div class="toggle-sidebar-widget position-right">
    <div class="toggle-content">
        <div class="close-toggle-sidebar"></div>

        <div class="widget-area">
            <div class="widget-logo">
                <?php koganic_toggle_logo(); ?>
            </div>

            <div class="widget-content">
                <?php echo koganic_toggle_content(); ?>
            </div>

            <div class="widget-banner">
                <?php koganic_toggle_banner(); ?>
            </div>

            <?php koganic_toggle_contact(); ?>
        </div>

        <div class="widget-social">
            <?php koganic_social_icons(); ?>
        </div>
    </div>
</div>