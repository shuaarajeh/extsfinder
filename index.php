<?php
$title="Telephone Extension Finder";
include('header.php'); ?>
<br /><br />
<div class="container"  style="width:900px;">
   <h2 align="center">Please search using the extension or the name of the employee</h2>
   <br /><br />
   <div align="center">
      <input type="text" name="search" id="search" placeholder="Search Here . . . " class="form-control" />
   </div>
   <ul class="list-group" id="result"></ul>
   <br />

<div class="btns">
   <button class="btn"><a href="add.php">Add</a></button>
   <button class="btn"><a href="delete.php">Delete</a></button>
</div>
</div>
<script>
   $(document).ready(function() {
      $.ajaxSetup({
         cache: false
      });
      $('#search').keyup(function() {
         $('#result').html('');
         $('#state').val('');
         var searchField = $('#search').val();
         var expression = new RegExp(searchField, "i");
         $.getJSON('data.json', function(data) {
            $.each(data, function(key, value) {
               if (value.name.search(expression) != -1 || value.number.search(expression) != -1) {
                  $('#result').append('<li class="list-group-item link-class"><span class="text-muted">' + value.name + '</span> | <span class="text-muted">' + value.number + '</span></li>');
               }
            });
         });
      });

      $('#result').on('click', 'li', function() {
         var click_text = $(this).text().split('|');
         $('#search').val($.trim('Name: '+click_text[0]+'. Extension:'+click_text[1]));
         $("#result").html('');
      });
   });
</script>
<?php include('footer.php'); ?>