<form action="{{ route('job_search') }}" class="job-form search-form">
    <div>
        <div class="row">
            <div class="col-sm-5 search-input">
                <select name="skill" class="form-control">
                    <option value="">Choose Category</option>
                    @if($skills->count())
                        @foreach($skills as $skill)
                        <option value="{{$skill->skill}}"  {{ (Request::get('skill') == $skill->skill) ? 'selected' : '' }} >{{$skill->skill}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-5 search-input">
                <input type="text" class="form-control" placeholder="Location e.g Lekki, Lagos" name="location" value="{{Request::get('location')}}">
            </div>
            <div class="col-sm-2 search-input">
                <button class="btn btn-default btn-block" type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
        </div>
    </div>
</form>