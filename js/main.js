$(document).ready(() => {
    $('.next_btn').on('click', (event) => {
        $('.answers .radio_inp').attr("disabled",true);
    })

    $('.answers .radio_inp').on('change', function() {
        if ($('.answers .radio_inp:checked').length > 0) {
            $('.next_btn').prop('disabled', false);
        } else {
            $('.next_btn').prop('disabled', true);
        }
        console.log($('.answers .radio_inp:checked').val());
        $('.answer_id').val($('.answers .radio_inp:checked').val());
    });
})

document.addEventListener('click', (event) => {
    if($(event.target).hasClass('copied_text_btn')  )
    {
        let url_path = $(event.target).siblings('.copied_text').val().trim();

        copyTextToClipboard(url_path);
    }
})


function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
  
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
  
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
      console.error('Fallback: Oops, unable to copy', err);
    }
  
    document.body.removeChild(textArea);
    var toastEl = document.getElementById('copiedToast');
    var copiedToast = new bootstrap.Toast(toastEl);
    copiedToast.show();
  }
  
  function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
      fallbackCopyTextToClipboard(text);
      return;
    }
    navigator.clipboard.writeText(text).then(function() {
      console.log('Async: Copying to clipboard was successful!');
    }, function(err) {
      console.error('Async: Could not copy text: ', err);
    });
  }
  