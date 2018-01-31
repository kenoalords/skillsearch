<template>
    <div>
        <h2 class="title is-6">Submit Application</h2>

        <div>
            <h3 class="title is-2">{{job.title}}</h3>
            <div class="level is-mobile">
                <div class="level-left">
                    <a :href="job.href" class="level-item">
                        <img :src="job.profile.avatar" :alt="job.profile.fullname" width="24" height="24" class="ui avatar image">
                        {{ job.profile.fullname }}
                    </a>
                    <div class="level-item">
                        <i class="fa fa-calendar"></i> {{ job.date }}
                    </div>
                    <div class="level-item">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span>{{ job.applications.length }} {{ job.applications.length > 1 ? 'Interests' : 'Interest' }}</span>
                    </div>
                </div>
            </div>
            <p>{{job.excerpt}}</p>
            <p><a :href="job.href" class="button is-small is-primary"><span>View Job</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a></p>
            <div class="ui divider"></div>
            <form action="#" method="POST" class="ui form">
                <div class="field">
                    <label for="application" class="label">Application Letter</label>
                    <textarea id="application" class="textarea" rows="5" placeholder="Be as detailed as possible to increase your chances" v-model="application.application" v-on:keyup="checkFormInput()"></textarea>
                </div>

                <div class="field">
                    <h4 class="title is-5">Clients budget is <strong>N{{job.human_budget}}</strong></h4>
                    <label for="budget" class="label">Your Proposed Budget</label>
                    <div class="control">
                        <input type="number" class="input" v-model="application.budget" placeholder="e.g 50000">
                    </div>
                </div>
                
                <div class="clearfix">
                    <button type="submit" class="button is-primary" :class="{ 'is-loading' : isSubmitting }" v-on:click.prevent="submitApplication()" :disabled="!isComplete"> Submit your application</button>
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
                isSubmitting: false,
            }
        },
        props: {
            task: null,
        },
        methods: {
            submitApplication(){
                var _this = this;
                _this.isSubmitting = true;
                if(_this.isComplete === true){
                    $('body').addClass('loading');
                    axios.post(_this.job.href + '/apply', _this.application).then((response)=>{
                        $('body').removeClass('loading');
                        _this.isComplete = false;
                        _this.application = {};
                        alert('Your application was submitted successfully');
                        _this.isSubmitting = false;
                        window.location.href = _this.job.href;
                        // console.log(response);
                    }).catch((err)=>{
                        _this.isSubmitting = false;
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
