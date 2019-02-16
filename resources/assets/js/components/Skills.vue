<template>
    <div :class="{'is-loading' : isLoading}" class="skills">
        <div class="card" id="skills-list" style="margin-bottom:10px">
            <div v-if="skills" class="skills-list-wrapper" id="skills">
                <a v-for="skill in skills" class="item" v-on:click.prevent="addSkill(skill)">
                    <div class="content">
                        <span>{{ skill.skill }}</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="" v-if="selectedSkills !== null && !isLoading" style="margin-bottom:10px">
            <div class="box" id="selectedSkills">
                <div class="title is-6">Selected skills</div>
                <a v-for="skill in selectedSkills" class="tag is-link" v-on:click.prevent="removeSkill(skill)" style="margin-right: 5px;">
                    {{ skill.skill }} &nbsp; <button class="delete is-small"></button>
                </a>
            </div>
        </div>

        <div class="has-text-right" v-if="isIntro && !isLoading">
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <a href="/dashboard?step=3">
                            Skip
                        </a>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="/dashboard?step=3" class="button is-info">
                            <span>Proceed</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getUserSkills();
        },

        data() {
            return {
                skills : this.getSkills(),
                selectedSkills : null,
                isLoading: true,
                isIntro: this.intro,
            }
        },
        props: {
            intro: false,
        },

        methods : {

            getSkills(){
                var _this = this;
                $('body').addClass('is-loading');
                axios.get('/skills/all').then((response)=>{
                    _this.skills = response.data;
                    $('body').removeClass('is-loading');
                    _this.isLoading = false;
                })
            },

            getUserSkills(){
                var _this = this;
                axios.get('/skills/user').then((response)=>{
                    _this.selectedSkills = response.data;
                })
            },

            addSkill(skill, event){
                if(this.selectedSkills.length >= 3){
                    iziToast.error({ title: "You can only select a maximum of 3 skills" });
                    return false;
                }
                var i = this.skills.indexOf(skill);
                this.skills.splice(i,1);
                this.selectedSkills.push(skill);

                axios.post('/skills/add',{
                    'id'    : skill.id,
                    'skill' : skill.skill
                }).then((response)=>{
                    // console.log(response);
                });
            },

            removeSkill(skill, event){
                var i = this.selectedSkills.indexOf(skill);
                this.selectedSkills.splice(i,1);
                this.skills.push(skill);

                axios.delete('/skills/delete/'+ skill.skill).then((response)=>{
                    // console.log(response);
                });
            }
        }      
    }
</script>
