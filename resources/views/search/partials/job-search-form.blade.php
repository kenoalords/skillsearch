<form action="{{ route('job_search') }}" class="job-form" id="search-form">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <select name="skill" class="form-control">
                    <option value="">Choose Category</option>
                    @if($skills->count())
                        @foreach($skills as $skill)
                        <option value="{{$skill->skill}}"  {{ (Request::get('skill') == $skill->skill) ? 'selected' : '' }} >{{$skill->skill}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Location" name="location" value="{{Request::get('location')}}">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-success btn-block" type="submit">Find Jobs</button>
            </div>
        </div>
    </div>
</form>