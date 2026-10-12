<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delisso</title>
		<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
		<script src="js/jquery.js"></script>
		<script src="js/jquery.mobile-1.4.5.min.js"></script>

	</head>
	<body>
	<div data-role="page" class="jqm-demos" data-quicklinks="true">

		<div data-role="header" class="jqm-header">
			<h2>Delisso</h2>

		</div><!-- /header -->

    <div role="main" class="ui-content jqm-content">
	<form>
	
	<div>
		<label for="select-choice-1" class="select">Pédiatre</label>
		<select id="filter-menu" data-native-menu="false">
			<option value="">-</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			<option value="SFO">San Francisco</option>
			<option value="LAX">Los Angeles</option>
			<option value="YVR">Vancouver</option>
			<option value="YYZ">Toronto</option>
			
			
		</select>
	</div>
	
	
	
	
	<div>
	
	<label for="gift_1" class="select">Porte carnets de santé</label>
		<select name="gift_1" id="select-choice-1">
		    <option value="0">0<option>
		    <option value="1">1<option>
		</select>
	</div>
	
		<label for="gift_2" class="select">Carnet de santé</label>
		<select name="gift_2" id="select-choice-1">
		    <option value="0">0<option>
		    <option value="1">1<option>
		</select>
	</div>
	
		<label for="gift_3" class="select">Toise</label>
		<select name="gift_3" id="select-choice-1">
		    <option value="0">0<option>
		    <option value="1">1<option>
		</select>
	</div>
	
		<label for="gift_4" class="select">Rouleaux Papier drap</label>
		<select name="gift_4" id="select-choice-1">
		    <option value="0">0<option>
		    <option value="1">1<option>
		</select>
	</div>
	
		<label for="gift_5" class="select">Porte Abaisse langue</label>
		<select name="gift_5" id="select-choice-1">
		    <option value="0">0<option>
		    <option value="1">1<option>
		</select>
	</div>
	
	
	
	
	<div>	
		<label for="file">Images:</label>
		<input type="file" name="file" id="file" value="">
	</div>
	

	
	
	
	</div>
	
	</form>
	</div>
	
	
</body>
</html>

<script>

$(document).ready(function() {
    // $('#select-choice-1').select2();
});


$.mobile.document
    // "filter-menu-menu" is the ID generated for the listview when it is created
    // by the custom selectmenu plugin. Upon creation of the listview widget we
    // want to prepend an input field to the list to be used for a filter.
    .on( "listviewcreate", "#filter-menu-menu", function( e ) {
        var input,
            listbox = $( "#filter-menu-listbox" ),
            form = listbox.jqmData( "filter-form" ),
            listview = $( e.target );
        // We store the generated form in a variable attached to the popup so we
        // avoid creating a second form/input field when the listview is
        // destroyed/rebuilt during a refresh.
        if ( !form ) {
            input = $( "<input data-type='search'></input>" );
            form = $( "<form></form>" ).append( input );
            input.textinput();
            $( "#filter-menu-listbox" )
                .prepend( form )
                .jqmData( "filter-form", form );
        }
        // Instantiate a filterable widget on the newly created listview and
        // indicate that the generated input is to be used for the filtering.
        listview.filterable({ input: input });
    })
    // The custom select list may show up as either a popup or a dialog,
    // depending how much vertical room there is on the screen. If it shows up
    // as a dialog, then the form containing the filter input field must be
    // transferred to the dialog so that the user can continue to use it for
    // filtering list items.
    //
    // After the dialog is closed, the form containing the filter input is
    // transferred back into the popup.
    .on( "pagebeforeshow pagehide", "#filter-menu-dialog", function( e ) {
        var form = $( "#filter-menu-listbox" ).jqmData( "filter-form" ),
            placeInDialog = ( e.type === "pagebeforeshow" ),
            destination = placeInDialog ? $( e.target ).find( ".ui-content" ) : $( "#filter-menu-listbox" );
        form
            .find( "input" )
            // Turn off the "inset" option when the filter input is inside a dialog
            // and turn it back on when it is placed back inside the popup, because
            // it looks better that way.
            .textinput( "option", "inset", !placeInDialog )
            .end()
            .prependTo( destination );
    });
</script>

<style>
.ui-selectmenu.ui-popup .ui-input-search {
    margin-left: .5em;
    margin-right: .5em;
}
.ui-selectmenu.ui-dialog .ui-content {
    padding-top: 0;
}
.ui-selectmenu.ui-dialog .ui-selectmenu-list {
    margin-top: 0;
}
.ui-selectmenu.ui-popup .ui-selectmenu-list li.ui-first-child .ui-btn {
    border-top-width: 1px;
    -webkit-border-radius: 0;
    border-radius: 0;
}
.ui-selectmenu.ui-dialog .ui-header {
    border-bottom-width: 1px;
}

</style>