<template>
    <div class="container" style="background: #fff">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 padded">
                
                <div>
                    <h1 class="text-center" v-if="!task.id"><span class="bold">Submit</span> <span class="thin">Your Job</span></h1>
                    <h1 class="text-center" v-if="task.id"><span class="bold">Edit</span> <span class="thin"> Job</span></h1>
                    <hr>
                    <div>
                        <form action="#" method="POST" class="boxed-form">

                            <div class="form-group">
                                <label for="">What category of service do you require</label>
                                <select name="category" v-model="task.category" class="form-control" v-on:change="checkFormInput()">
                                    <option value="0">Select a category</option>
                                    <option :value="category.skill" v-for="category in categories">{{category.skill}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">What is the job title</label>
                                <input v-model="task.title" type="text" name="title" class="form-control" placeholder="e.g I need a graphics designer" autofocus v-on:focus="checkFormInput()">
                            </div>

                            <div class="form-group">
                                <label for="description">Tell us more about this job</label>
                                <textarea v-model="task.description" rows="7" name="description" class="form-control" placeholder="Describe your project here" v-on:focus="checkFormInput()"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="location" id="location">Where is this job located</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                    <input v-model="task.location" type="text" name="location" class="form-control" placeholder="e.g Ikeja, Lagos" v-on:focus="checkFormInput()">
                                </div>
                            </div>

                            
                            <div class="row">

                            <div class="form-group col-sm-6">
                                <label for="budget">What is your budget</label>
                                <div class="input-group">
                                    <span class="input-group-addon">₦</span>
                                    <input v-model="task.budget" type="number" name="budget" id="budget" class="form-control" placeholder="e.g 50000"  v-on:focus="checkFormInput()">
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="">Budget type</label>
                                <select name="budget_type" class="form-control" v-model="task.budget_type" v-on:focus="checkFormInput()">
                                    <option value="0">Select</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="negotiable">Negotiable</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="expiry_date">When does this job offer close?</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input v-model="task.expires" type="text" id="expiry_date" class="form-control" placeholder="mm/dd/yyyy"  v-on:focus="checkFormInput()">
                                </div>
                                <small v-html="selectedDate"></small>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="application_limit">How many applications do you need?</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input v-model="task.application_limit" type="number" id="application_limit" class="form-control" placeholder="e.g. 25"   v-on:focus="checkFormInput()">
                                </div>
                            </div>

                            </div>
                            
                            <div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" v-model="task.is_public" value="1"> Make this job public
                                    </label>
                                </div>
                            </div>

                            <hr>
                            <div class="">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" v-model="agree"> 
                                        Please agree to our <a href="/terms-and-condition#jobs" target="_blank">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 24px" v-on:click.prevent="submitProject()" :disabled="!isComplete"><i class="fa fa-send"></i> Submit Your Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
