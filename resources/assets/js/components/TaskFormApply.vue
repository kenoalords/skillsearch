<template>
    <div class="container" style="background: #fff">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 padded">
                
                <div>
                    <h1 class="text-center"><span class="bold">Submit</span> <span class="thin">Application</span></h1>
                    <hr>
                    <div>
                        <h5>Job Details</h5>
                        <h3 class="bold">{{job.title}}</h3>
                        <ul class="list-inline">
                            <li>
                                <a :href="job.href">
                                    <img :src="job.profile.avatar" :alt="job.profile.fullname" width="24" height="24" class="img-circle">
                                     <span>{{ job.profile.fullname }}</span>
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-calendar"></i> {{ job.date }}
                            </li>
                            <li><span class="bold"><i class="fa fa-user"></i> {{ job.applications.length }} {{ job.applications.length > 1 ? 'Interests' : 'Interest' }}</span></li>
                        </ul>
                        <p>{{job.excerpt}}</p>
                        <p><a :href="job.href" class="bold"><small>View Job</small></a></p>
                        <hr>
                        <form action="#" method="POST" class="boxed-form">
                            
                            <div class="form-group">
                                <label for="application">Application Letter</label>
                                <textarea id="application" class="form-control" rows="7" placeholder="Be as detailed as possible to increase your chances" v-model="application.application" v-on:keyup="checkFormInput()"></textarea>
                            </div>

                            <div class="form-group">
                                <h4 class="block-title bold" style="color:#31708f">Clients budget is <strong>N{{job.human_budget}}</strong></h4>
                                <label for="budget">Your Proposed Budget</label>
                                <div class="input-group">
                                    <span class="input-group-addon">N</span>
                                    <input type="number" class="form-control" v-model="application.budget" placeholder="e.g 50000">
                                </div>
                            </div>
                            
                            <div class="clearfix">
                                <button type="submit" class="btn btn-success" style="padding: 10px 24px" v-on:click.prevent="submitApplication()" :disabled="!isComplete"> Submit your application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                errors: {},
                job: JSON.parse(this.task),
                isComplete: false,
                application: {},
                baseUrl: window.Laravel.url,
            }
        },
        props: {
            task: null,
        },
        methods: {
            submitApplication(){
                var _this = this;
                if(_this.isComplete === true){
                    $('body').addClass('loading');
                    axios.post(_this.job.href + '/apply', _this.application).then((response)=>{
                        $('body').removeClass('loading');
                        _this.isComplete = false;
                        _this.application = {};
                        alert('Your application was submitted successfully');
                        window.location.href = _this.job.href;
                        // console.log(response);
                    })
                }
            },

            checkFormInput(){
                var input = this.application;
                if(input.application){
                    this.isComplete = true;
                } else {
                    this.isComplete = false;
                }
            }
        },
        mounted() {
            // console.log(JSON.parse(this.job))
        }
    }
</script>
