jQuery(document).ready(function ($) {
    if ($('body').hasClass('wp-admin')) {
        const getSubmitBtn = $('#agy-save-changes-btn');
        const getForm = $('#agy-form-submit');

        function agyAjaxDone(s) {
            getSubmitBtn.attr('value', s)
        }

        function agyRestartAnimation() {
            setTimeout(() => getSubmitBtn.attr('value', 'Save changes'), 3000);
        }

        function agyAjaxSubmit() {
            let agyFormData = new FormData(this);

            agyFormData.append('agy_save_changes_btn', 1);
            agyFormData.append('security', agy_admin_ajax.ajax_publisher_name);

            $.ajax({
                type: 'POST',
                url: agy_admin_ajax.ajax_ajaxurl,
                data: agyFormData,
                processData: false,
                contentType: false,
                complete: function () {
                    agyAjaxDone('Saved')
                    agyRestartAnimation();
                },
                error: function () {
                    agyAjaxDone('Not saved. Please try again!');
                    agyRestartAnimation();
                }
            });

            return false;
        }

        getSubmitBtn.bind('click', () => getSubmitBtn.attr('value', 'Saving...'));
        getForm.submit(agyAjaxSubmit);
    }
});