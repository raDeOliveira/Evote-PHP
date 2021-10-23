// progress bar
$(document).ready(function() {
    $('.progress .progress-bar').css("width",
        function() {
            return $(this).attr("aria-valuenow") + "%";
        }
    )
});

// for extra field to add new candidate
$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".container1");
    var add_button      = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div>' +
                '<input type="text" class="form-control" placeholder="Candidate name" name="candidate-name[]"/><a href="#" class="delete">Delete</a>' +
                '</div>');
        }
        else
        {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove();
        x--;
    })
});
