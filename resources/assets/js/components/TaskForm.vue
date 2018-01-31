<template>
    <div>
        <h1 class="title is-2" v-if="!task.id">Post a Job</h1>
        <h1 class="title is-2" v-if="task.id">Edit Job</h1>
        <div class="ui divider"></div>
        <div>
            <form action="#" method="POST" class="ui form">

                <div class="field">
                    <label for="" class="label">What category of service do you require</label>
                    <div class="select">
                        <select name="category" v-model="task.category" v-on:change="checkFormInput()">
                            <option value="0">Select a category</option>
                            <option :value="category.skill" v-for="category in categories">{{category.skill}}</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="title" class="label">What is the job title</label>
                    <input v-model="task.title" type="text" name="title" class="input" placeholder="e.g I need a graphics designer" autofocus v-on:focus="checkFormInput()">
                </div>

                <div class="field">
                    <label for="description" class="label">Tell us more about this job</label>
                    <textarea v-model="task.description" rows="7" name="description" class="textarea" placeholder="Describe your project here" v-on:focus="checkFormInput()"></textarea>
                </div>

                <div class="field">
                    <label for="location" id="location" class="label">Where is this job located</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                        <input v-model="task.location" type="text" name="location" class="input" placeholder="e.g Ikeja, Lagos" v-on:focus="checkFormInput()">
                    </div>
                </div>

                
                <div class="field is-grouped">

                    <div class="control">
                        <label for="budget" class="label">What is your budget</label>
                        <div class="field has-addons has-addons-right">
                            <p class="control">
                                <span class="button is-static">₦</span>
                            </p>
                            <p class="control">
                                <input v-model="task.budget" type="number" name="budget" id="budget" class="input" placeholder="e.g 50000"  v-on:focus="checkFormInput()">
                            </p>
                        </div>
                    </div>

                    <div class="control">
                        <label for="" class="label">Budget type</label>
                        <div class="select">
                            <select name="budget_type" class="input" v-model="task.budget_type" v-on:focus="checkFormInput()">
                                <option value="0">Select</option>
                                <option value="fixed">Fixed</option>
                                <option value="negotiable">Negotiable</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <label for="expiry_date" class="label">When does this job offer close?</label>
                        <input v-model="task.expires" type="date" id="expiry_date" class="input date" placeholder="mm/dd/yyyy"  v-on:focus="checkFormInput()">
                        <small v-html="selectedDate"></small>
                    </div>

                    <div class="control">
                        <label class="label">How many applications do you need?</label>
                        <div class="">
                            <input v-model="task.application_limit" type="number" id="application_limit" class="input" placeholder="e.g. 25"   v-on:focus="checkFormInput()">
                        </div>
                    </div>

                </div>
                
                <div class="field">
                    <div class="checkbox">                        
                        <label>
                            <input type="checkbox" v-model="task.is_public" value="1"> Make this job public
                        </label>
                    </div>
                </div>
                <div class="field">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="agree"> Please agree to our <a href="/terms-and-condition#jobs" target="_blank">Terms and Conditions</a>
                        </label>
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="button is-link" v-on:click.prevent="submitProject()" :disabled="!isComplete">Submit</button>
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
                    axios.post(_this.baseUrl + '/dashboard/jobs/add', _this.task).then((response)=>{
                        $('body').removeClass('loading');
                        _this.isComplete = false;
                        if(_this.task.id){
                            alert('Your job has been updated successfully');
                        } else {
                            alert('Your job was posted successfully');
                        }
                        window.location.href = '/dashboard/jobs';
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
