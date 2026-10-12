<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Select2 Template</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
  </head>
  <body>
  
  <h4>Limited Number of Selections using Chosen</h4>
		<select class="limitedNumbChosen">
        <option value="1">Monday</option>
        <option value="2">Tuesday</option>
        <option value="3">Wednesday</option>
        <option value="4">Thursday</option>
        <option value="5">Friday</option>
        <option value="6">Saturday</option>
        <option value="7">Sunday</option>
		</select>


    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
    <script>
	$(document).ready(function(){
  //Chosen
  $(".limitedNumbChosen").chosen({
		max_selected_options: 1,
    placeholder_text_multiple: "Which are two of most productive days of your week"
	})
	.bind("chosen:maxselected", function (){
		window.alert("You reached your limited number of selections which is 2 selections!");
	})

});
	
	</script>
  </body>
</html>

