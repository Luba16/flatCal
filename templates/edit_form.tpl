<form action="{form_action}" method="POST">

<div class="row">
	<div class="col-md-8">
		<div class="form-group">
		    <label>Titel</label>
		    <input name="cal_title" type="text" class="form-control" value="{cal_title}" placeholder="Titel, Überschrift">
		</div>
		<div class="form-group">
		    <label>Author</label>
		    <input name="cal_author" type="text" class="form-control" value="{cal_author}">
		</div>
		<div class="form-group">
    	<label>Text</label>
			<textarea name="cal_text" class="mceEditor_small">{cal_text}</textarea>
		</div>
	</div> <!-- col -->
	<div class="col-md-4">
		<div class="input-group">
		    <span class="input-group-addon">Beginn</span>
		    <input type="text" name="cal_startdate" class="dp form-control" value="{cal_startdate}">
		</div>
		<br>
		<div class="input-group">
		    <span class="input-group-addon">Ende</span>
		    <input type="text" name="cal_enddate" class="dp form-control" value="{cal_enddate}" placeholder="optional">
		</div>
		<hr>
		<fieldset>
			<legend>Rubriken</legend>
			<div style="max-height:100px;overflow: auto;">{categories_list}</div>
		</fieldset>
		<fieldset>
			<legend>Banner</legend>
			{images_list}
		</fieldset>
	</div> <!-- col -->
</div> <!-- row -->


<input type="hidden" name="modus" value="{modus}">
<input type="hidden" name="id" value="{id}">
<input type="submit" name="save_cal" value="{btn_value}" class="btn btn-success">
</form>