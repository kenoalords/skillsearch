<form action="{{ route('job_search') }}" class="ui form" id="searchform">
    <div>
        <div class="ui fields">
            <div class="field">
                <select name="skill" class="ui search dropdown">
                    <option value="">Choose Category</option>
                    @if($skills->count())
                        @foreach($skills as $skill)
                        <option value="{{$skill->skill}}"  {{ (Request::get('skill') == $skill->skill) ? 'selected' : '' }} >{{$skill->skill}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="field">
                <input type="text" class="form-control" placeholder="Location e.g Lekki, Lagos" name="location" value="{{Request::get('location')}}">
            </div>
            <div class="field">
                <button class="ui primary button" type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
        </div>
    </div>
</form>