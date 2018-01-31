<template>
    <div :class="{'is-loading' : isLoading}" class="skills">
        <div class="title is-6">Select your skills</div>
        <div class="" id="skills-list">
            <div v-if="skills" class="skills-list-wrapper" id="skills">
                <a v-for="skill in skills" class="item" v-on:click.prevent="addSkill(skill)">
                    <div class="content">
                        <span>{{ skill.skill }}</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="">
            <div v-if="getUserSkills" class="selected-skills-wrapper" id="selectedSkills">
                <!-- <div class="title is-6">Selected skills</div> -->
                <a v-for="skill in selectedSkills" class="tag is-link" v-on:click.prevent="removeSkill(skill)">
                    {{ skill.skill }} &nbsp; <button class="delete is-small"></button>
                </a>
            </div>
            <div v-if="selectedSkills == null">
                <p>You have not selected any skills</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },

        data() {
            return {
                skills : this.getSkills(),
                selectedSkills : this.getUserSkills(),
                isLoading: true,
            }
        },

        methods : {

            getSkills(){
                var _this = this;
                axios.get('/skills/all').then((response)=>{
                    _this.skills = response.data;
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
                if(this.selectedSkills.length >= 5){
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
