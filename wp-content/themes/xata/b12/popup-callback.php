<!-- Modal -->
<div class="modal fade " id="popup_callback" role="dialog">
    <div class="modal-dialog modal_dialog_custom">
        <!-- Modal content-->
        <div class="modal-content modal_custom">
            <div class="modal-header modal_header_custom">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="product-h">
                    <h2 class="modal-title"><?php _e('Заказать звонок', 'imperia'); ?></h2>
                    <h2 class="modal-title after-submit" style="display: none"><?php _e('Заявка принята', 'imperia'); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 col-sm-offset-5 modal_border"></div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo get_template_directory_uri(); ?>/includes/callback/callback.php">
                <div class="modal-body modal_body_custom">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="name" class="form-control form_control_custom" id="name" placeholder="<?php _e('Ваше имя', 'imperia'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="tel" name="telephone" class="form-control form_control_custom" id="phone" placeholder="<?php _e('Ваш телефон', 'imperia'); ?>" required>
                        </div>
                    </div>
                    <div class="text-danger text-left col-sm-12"><small>* всі поля обов'язкові</small></div>
                </div>
                <?php wp_nonce_field('callback_email_send'); ?>
                <div class="modal-footer btn_reg_padding">
                    <div class="col-sm-12 text-center">
                        <button type="submit" id="sendCallbackForm" class="find"><?php _e('Заказать звонок', 'imperia'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal-->
