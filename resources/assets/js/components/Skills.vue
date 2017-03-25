<template>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Select your skills</div>

                <div class="panel-body" id="skills-list">
                    <div v-if="skills" class="list-group" id="skills">
                        <a v-for="skill in skills" class="list-group-item" v-on:click.prevent="addSkill(skill)">
                            {{ skill.skill }}
                            <div class="pull-right">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Selected skills</div>

                <div class="panel-body">
                    <div v-if="getUserSkills" class="list-group" id="selectedSkills">
                        <a v-for="skill in selectedSkills" class="list-group-item" v-on:click.prevent="removeSkill(skill)">
                            {{ skill.skill }}
                            <div class="pull-right">
                                <i class="glyphicon glyphicon-remove"></i>
                            </div>
                        </a>
                    </div>
                    <div v-if="selectedSkills == null">
                        <p>You have not selected any skills</p>
                    </div>
                </div>
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
            }
        },

        methods : {

            getSkills(){
                var _this = this;
                axios.get('/skills/all').then((response)=>{
                    _this.skills = response.data;
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
                    console.log(response);
                });
            },

            removeSkill(skill, event){
                var i = this.selectedSkills.indexOf(skill);
                this.selectedSkills.splice(i,1);
                this.skills.push(skill);

                axios.delete('/skills/delete/'+ skill.skill).then((response)=>{
                    console.log(response);
                });
            }

        }

        

    }
</script>
