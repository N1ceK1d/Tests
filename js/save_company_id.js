$(document).ready(() => {

    $('.selected_id').on('change', (event) => {

        console.log($(event.target).val().split(', '));
        let is_anon = $('.selected_id').val().split(', ')[1];
        let company_id = $('.selected_id').val().split(', ')[0];

        if(is_anon == 0)
        {
            $('.anon_btn').hide();
            $('.user_btn').show();
        } else {
            $('.anon_btn').show();
            $('.user_btn').hide();
        }

        $.map($('.company_id'), (item) => {
            $(item).val(company_id);
            console.log($(item).val())
        })

        $('#nextAfterSelect').prop('disabled', false);
    })
})