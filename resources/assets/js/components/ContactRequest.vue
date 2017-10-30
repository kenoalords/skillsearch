<template>
    <div>
        <div class="white-boxed" style="margin-bottom: 2em;">
            <h2 class="ui grey medium header">{{ pendingRequests.length }} Pending Requests</h2>
            
            <div class="ui divided very relaxed list" v-if="pendingRequests">
                <div class="item" v-for="pending in pendingRequests">
                    <div class="right floated">
                        <a v-on:click.prevent="approveRequest(pending)" class="ui mini  button" :id="'btn-'+pending.id">Approve</a>
                    </div>
                    <i class="large address card middle aligned icon"></i>
                    <div class="content">
                        <div class="header">{{ pending.fullname }}</div>
                        <div class="description">
                            <div class="ui horizontal list">
                                <div class="item">
                                    <i class="icon marker"></i>{{ pending.location }}
                                </div>
                                <div class="item" v-if="pending.phone">
                                    <i class="icon phone"></i>{{ pending.phone }}
                                </div>
                                <div class="item">
                                    <i class="icon calendar"></i>{{ pending.created_at }}
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
            <div class="ui small header" v-if="pendingRequests.length == 0">You have no pending requests</div>
        </div>

        <div class="white-boxed">
            <h2 class="ui grey medium header">{{ approvedRequests.length }} Approved Requests</h2>
            
            <div class="ui divided very relaxed list" v-if="approvedRequests">
                <div class="item" v-for="approved in approvedRequests">
                    <i class="large address card middle aligned icon"></i>
                    <div class="content">
                        <div class="header">{{ approved.fullname }}</div>
                        <div class="description">
                            <div class="ui horizontal list">
                                <div class="item">
                                    <i class="icon marker"></i>{{ approved.location }}
                                </div>
                                <div class="item" v-if="approved.phone">
                                    <i class="icon phone"></i>{{ approved.phone }}
                                </div>
                                <div class="item">
                                    <i class="icon calendar"></i>{{ approved.created_at }}
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
            <div class="ui small header" v-if="approvedRequests.length == 0">You have no approved requests</div>
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
                var _this = this;
                this.isPosting = true;
                var btn = $('#btn-'+request.id);
                btn.addClass('loading');
                axios.post('/home/contact-requests/'+request.id+'/approve').then((response)=>{
                    // console.log(toastr);
                    btn.removeClass('loading');
                    toastr.success('Contact request approved!');
                    if(response.data == 1){
                        var index = _this.pendingRequests.indexOf(request);
                        _this.pendingRequests.splice(index, 1);
                        _this.approvedRequests.unshift(request);
                        _this.isPosting = false;
                        $('#req-count').html(_this.pendingRequests.length);
                    }
                });
            }
        },

        mounted() {
            // console.log(this.pending);
        }
    }
</script>
