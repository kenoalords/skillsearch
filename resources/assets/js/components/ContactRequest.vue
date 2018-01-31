<template>
    <div>
        <div>
            <h2 class="title is-6 has-text-danger">{{ pendingRequests.length }} Pending Requests</h2>
            <p class="subtitle is-6" v-if="pendingRequests.length == 0">You have no pending requests</p>
            <div class="ui divided very relaxed list" v-if="pendingRequests">
                <div class="level is-raised is-mobile" v-for="pending in pendingRequests" style="padding: 10px;">
                    <div class="level-left">
                        <div class="level-item has-text-weight-bold">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span>{{ pending.fullname }}</span>
                        </div>
                        <div class="level-item">
                            <span class="icon"><i class="fa fa-map-marker"></i></span> <span>{{ pending.location }}</span>
                        </div>
                        <div class="level-item" v-if="pending.phone">
                            <span class="icon"><i class="fa fa-phone"></i></span> <span>{{ pending.phone }}</span>
                        </div>                       
                    </div>

                    <div class="level-right">
                        <a v-on:click.prevent="approveRequest(pending)" class="button is-small is-primary" :id="'btn-'+pending.id"><span class="icon"><i class="fa fa-check-circle"></i></span></a>
                    </div>

                </div>
            </div>
            
        </div>

        <div class="white-boxed" style="margin-top: 3em">
            <h2 class="title is-6 has-text-danger">{{ approvedRequests.length }} Approved Requests</h2>
            <p class="subtitle is-6" v-if="approvedRequests.length == 0">You have no approved requests</p>

            <div v-if="approvedRequests">
                <div class="level is-raised" style="padding: 10px;" v-for="approved in approvedRequests">
                    <div class="level-left">
                        <div class="level-item has-text-weight-bold">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span>{{ approved.fullname }}</span>
                        </div>
                        <div class="level-item">
                            <span class="icon"><i class="fa fa-map-marker"></i></span> <span>{{ approved.location }}</span>
                        </div>
                        <div class="level-item" v-if="approved.phone">
                            <span class="icon"><i class="fa fa-phone"></i></span> <span>{{ approved.phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
    import toastr from "toastr";
    export default {
        data(){
            return {
                approvedRequests: (this.approved) ? jQuery.parseJSON(this.approved) : {},
                pendingRequests: (this.pending) ? jQuery.parseJSON(this.pending) : {},
                isPosting: false,
            }
        },

        props: {
            approved: null,
            pending: null,
        },

        methods: {
            approveRequest: function(request){
                if(confirm('Are you sure you want to aprove this contact request')){
                    var _this = this;
                    this.isPosting = true;
                    var btn = $('#btn-'+request.id);
                    btn.addClass('loading');
                    axios.post('/dashboard/contact-requests/'+request.id+'/approve').then((response)=>{
                        btn.removeClass('loading');
                        iziToast.success({ title : 'Contact request approved!'});
                        if(response.data == 1){
                            var index = _this.pendingRequests.indexOf(request);
                            _this.pendingRequests.splice(index, 1);
                            _this.approvedRequests.unshift(request);
                            _this.isPosting = false;
                            $('#req-count').html(_this.pendingRequests.length);
                        }
                    });
                }
            }
        },

        mounted() {
            // console.log(this.pending);
        }
    }
</script>
