<form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<label>Lecture</label>
<select name="lectID">
@foreach($lectures as $lecture)
<option value="{{ $lecture->lectID }}">{{ $lecture->lectName }}</option>
@endforeach
</select>

<br><br>

<label>Section Title</label>
<input type="text" name="section_title">

<br><br>

<label>Section Type</label>
<select name="section_type">
<option value="text">Text</option>
<option value="video">Video</option>
<option value="pdf">PDF</option>
<option value="image">Image</option>
</select>

<br><br>

<label>Content</label>
<textarea name="section_content"></textarea>

<br><br>

<label>Upload File</label>
<input type="file" name="section_file">

<br><br>

<label>Order</label>
<input type="number" name="section_order">

<br><br>

<button type="submit">Add Section</button>

</form>