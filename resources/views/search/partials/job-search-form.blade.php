<form action="{{ route('job_search') }}" method="GET" style="width: 100%">
    <div class="field is-grouped">
        <div class="control is-expanded">
            <div class="select is-block">
                <select name="skill" style="width: 100%">
                    <option value="">Choose Category</option>
                    @if($skills->count())
                        @foreach($skills as $skill)
                        <option value="{{$skill->skill}}"  {{ (Request::get('skill') == $skill->skill) ? 'selected' : '' }} >{{$skill->skill}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="control is-expanded">
            <input type="text" class="input" placeholder="Location e.g Lekki, Lagos" name="location" value="{{Request::get('location')}}">
        </div>
        <div class="control">
            <button class="button is-dark" type="submit"><span class="icon"><i class="fa fa-search"></i></span></button>
        </div>
    </div>
</form>