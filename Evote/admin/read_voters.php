<?php

include_once "../config/core.php";
include_once "../admin/login_checker.php";
include_once "../admin/layout_head.php";

$page_title = "read_voters";

echo "<br><br><br>";
?>

<!-- selection option for pagging -->
<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
    <option value="">Select filter search</option>
    <option value="read_voters.php">View voters</option>
    <option value="read_events.php">View events</option>
    <option value="read_type_document.php">View type document</option>
</select>

<!-- live search box -->
<br>
<label for="search_text"></label>
<input type="search" name="search_text" id="search_text" placeholder="Search something" class="form-control" onclick=""/>
<br>
<div id="result"></div>

<script>
    $(document).ready(function(){
        load_data();
        // do a POST for fetching autocomplete results from text insert
        function load_data(query) {
            $.ajax({
                url:"../search_box/search_box_voters.php",
                method:"POST",
                data:{query:query},
                // if success, show results in tag result
                success:function(data) {
                    $('#result').html(data);
                }
            });
        }

        // autocomplete results
        $(function() {
            $( "#search_text" ).autocomplete({
                source: '../search_box/autocomplete_results_voters.php'
            });
        });

        // to view results on HTML table
        $('#search_text').keyup(function(){
            var search = $(this).val();
            // if text inserted != from null show results
            if(search !== '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
</script>

</div>

<?php
// include page footer HTML
include_once "../layout_foot.php";
?>
