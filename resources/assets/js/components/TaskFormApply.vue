<template>
    <div>
        <h2 class="ui small grey header">Submit Application</h2>

        <div>
            <div class="ui large header">{{job.title}}</div>
            <div class="ui horizontal list">
                <div class="item">
                    <a :href="job.href">
                        <img :src="job.profile.avatar" :alt="job.profile.fullname" width="24" height="24" class="ui avatar image">
                        {{ job.profile.fullname }}
                    </a>
                </div>
                <div class="item">
                    <i class="fa fa-calendar"></i> {{ job.date }}
                </div>
                <div class="item"><span class="bold"><i class="fa fa-user"></i> {{ job.applications.length }} {{ job.applications.length > 1 ? 'Interests' : 'Interest' }}</span></div>
            </div>
            <p>{{job.excerpt}}</p>
            <p><a :href="job.href" class="bold"><small>View Job</small></a></p>
            <div class="ui divider"></div>
            <form action="#" method="POST" class="ui form">
                <div class="field">
                    <label for="application">Application Letter</label>
                    <textarea id="application" class="form-control" rows="7" placeholder="Be as detailed as possible to increase your chances" v-model="application.application" v-on:keyup="checkFormInput()"></textarea>
                </div>

                <div class="field">
                    <h4 class="ui red header">Clients budget is <strong>N{{job.human_budget}}</strong></h4>
                    <label for="budget">Your Proposed Budget</label>
                    <div class="ui labeled input">
                        <div class="ui label">N</div>
                        <input type="number" class="form-control" v-model="application.budget" placeholder="e.g 50000">
                    </div>
                </div>
                
                <div class="clearfix">
                    <button type="submit" class="ui primary button" v-on:click.prevent="submitApplication()" :disabled="!isComplete"> Submit your application</button>
                </div>
            </form>
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
