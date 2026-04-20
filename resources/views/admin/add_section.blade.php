<form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>{{ __('messages.admin.lecture') }}</label>
    <select name="lectID">
        @foreach($lectures as $lecture)
        <option value="{{ $lecture->lectID }}">{{ $lecture->lectName }}</option>
        @endforeach
    </select>
    <br><br>
    <label>{{ __('messages.admin.section_title') }}</label>
    <input type="text" name="section_title">
    <br><br>
    <label class="form-label">{{ __('messages.admin.section_type') }}</label>
        <select name="section_type" class="form-select">
            <option value="text">{{ __('messages.admin.text') }}</option>
            <option value="video">{{ __('messages.admin.video') }}</option>
            <option value="pdf">{{ __('messages.admin.pdf') }}</option>
            <option value="image">{{ __('messages.admin.image') }}</option>
        </select>
    </select>
    <br><br>
        <label class="form-label">{{ __('messages.admin.content') }}</label>
        <textarea name="section_content" class="form-control" rows="3"></textarea>
    <br><br>
        <label class="form-label">{{ __('messages.admin.upload_file') }}</label>
        <input type="file" name="section_file" class="form-control">
    <br><br>
        <label class="form-label">{{ __('messages.admin.section_order') }}</label>
        <input type="number" name="section_order" class="form-control">
    <br><br>
    <button type="submit">{{ __('messages.admin.add_section') }}</button>
</form>