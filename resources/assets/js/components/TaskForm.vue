<template>
    <div>
        <h1 class="ui header" v-if="!task.id">Post a Job</h1>
        <h1 class="ui header" v-if="task.id">Edit Job</h1>
        <div class="ui divider"></div>
        <div>
            <form action="#" method="POST" class="ui form">

                <div class="field">
                    <label for="">What category of service do you require</label>
                    <!-- <select name="category" v-model="task.category" class="form-control" v-on:change="checkFormInput()">
                        <option value="0">Select a category</option>
                        <option :value="category.skill" v-for="category in categories">{{category.skill}}</option>
                    </select> -->
                    <div class="ui selection dropdown">
                        <input type="hidden" name="category" v-model="task.category">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose a category</div>
                        <div class="menu">
                            <div class="item" :data-value="category.skill" v-for="category in categories">{{category.skill}}</div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label for="title">What is the job title</label>
                    <input v-model="task.title" type="text" name="title" class="form-control" placeholder="e.g I need a graphics designer" autofocus v-on:focus="checkFormInput()">
                </div>

                <div class="field">
                    <label for="description">Tell us more about this job</label>
                    <textarea v-model="task.description" rows="7" name="description" class="form-control" placeholder="Describe your project here" v-on:focus="checkFormInput()"></textarea>
                </div>

                <div class="field">
                    <label for="location" id="location">Where is this job located</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                        <input v-model="task.location" type="text" name="location" class="form-control" placeholder="e.g Ikeja, Lagos" v-on:focus="checkFormInput()">
                    </div>
                </div>

                
                <div class="two fields">

                    <div class="field">
                        <label for="budget">What is your budget</label>
                        <div class="ui labeled input">
                            <div class="ui label">₦</div>
                            <input v-model="task.budget" type="number" name="budget" id="budget" class="form-control" placeholder="e.g 50000"  v-on:focus="checkFormInput()">
                        </div>
                    </div>

                    <div class="field">
                        <label for="">Budget type</label>
                        <!-- <select name="budget_type" class="form-control" v-model="task.budget_type" v-on:focus="checkFormInput()">
                            <option value="0">Select</option>
                            <option value="fixed">Fixed</option>
                            <option value="negotiable">Negotiable</option>
                        </select> -->
                        <div class="ui selection dropdown">
                            <input type="hidden" name="budget_type" v-model="task.budget_type">
                            <i class="dropdown icon"></i>
                            <div class="default text">Budget type</div>
                            <div class="menu">
                                <div class="item" :data-value="fixed">Fixed</div>
                                <div class="item" :data-value="negotiable">Negotiable</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="expiry_date">When does this job offer close?</label>
                        <div class="ui icon input">
                            <i class="icon calendar"></i>
                            <input v-model="task.expires" type="text" id="expiry_date" class="form-control" placeholder="mm/dd/yyyy"  v-on:focus="checkFormInput()">
                        </div>
                        <small v-html="selectedDate"></small>
                    </div>

                    <div class="field">
                        <label>How many applications do you need?</label>
                        <div class="ui icon input">
                            <i class="icon users"></i>
                            <input v-model="task.application_limit" type="number" id="application_limit" class="form-control" placeholder="e.g. 25"   v-on:focus="checkFormInput()">
                        </div>
                    </div>

                </div>
                
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" v-model="task.is_public" value="1">
                        <label>Make this job public</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" v-model="agree">
                        <label>Please agree to our <a href="/terms-and-condition#jobs" target="_blank">Terms and Conditions</a></label>
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="ui primary button" v-on:click.prevent="submitProject()" :disabled="!isComplete">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import datepicker from "bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js";
    export default {
        
        props: {
            skills: null,
            edit: null,
        },

        data(){
            return {
                categories: JSON.parse(this.skills),
                category: null,
                errors: {},
                task: (this.edit) ? JSON.parse(this.edit) : {},
                isComplete: false,
                baseUrl: window.Laravel.url,
                selectedDate: null,
                agree: null,
            }
        },

        methods: {
            submitProject(){
                var _this = this;
                // console.log(_this.agree)
                if(_this.agree !== true){
                    alert('Please agree to our Terms and Conditions');
                    return;
                }
                if(_this.isComplete === true){
                    $('body').addClass('loading');
                    axios.post(_this.baseUrl + '/profile/jobs/add', _this.task).then((response)=>{
                        $('body').removeClass('loading');
                        _this.isComplete = false;
                        if(_this.task.id){
                            alert('Your job has been updated successfully');
                        } else {
                            alert('Your job was posted successfully');
                        }
                        window.location.href = '/profile/jobs';
                    })
                }
            },

            checkFormInput(){
                var input = this.task;
                if(input.title && input.description && input.category && input.location){
                    this.isComplete = true;
                } else {
                    this.isComplete = false;
                }
            }
        },
        mounted() {
            var now = new Date(Date.now()).toLocaleString(),
                _this = this;
            $('.input-group.date').datepicker({
                startDate: now,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                inputs: $('#expiry_date'),
            }).on('changeDate', function(e){
                var date = $('#expiry_date').val();
                _this.task.expires = new Date(date).toISOString().substring(0, 10);
                _this.selectedDate = new Date(date).toDateString();
            })
        }
    }
</script>
