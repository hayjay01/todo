<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading head">My Daily Tasks</div>
                    </center>
                    <div class="panel-body">
                        <div class="input-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Task name" v-model="task.name" @keyup.enter="create" class="form-control">
                                </div>

                                <!-- <div class="col-lg-6">

                                    <input type="time" placeholder="Start time" v-model="task.name" @keyup.enter="create" class="form-control">
                                </div>
 -->
                                


                            </div>
                            
                            <span class="input-group-btn">
                                <button class="btn btn-success nn" @click="create">Add New Task</button>
                            </span>

                            
                        </div>
                        
                        <div class="tasks-list">

                            <div class="alert alert-danger" v-if="!tasks.length">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Oops!</strong> <span class="white">You have no tasks!</span>
                            </div>


                            <ul class="list-unstyled">
                                <li v-for="task in tasks" v-bind:key="task.id" :class="{ done: task.completed }">
                                    <div class="checkbox">
                                        <label> 
                                            <input type="checkbox" @click="done(task)" v-model="task.completed"> {{ task.name }} 
                                        </label> 
                                        <div class="pull-right">
                                            <a href="#" @click.prevent="remove(task)" class="glyphicon glyphicon-trash dump"></a>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="panel-footer" v-if="tasks.length">
                        <span class="label label-default">You have total of {{ tasks.length }} tasks</span>
                        <span class="label label-warning">{{ remainingTasks() }} tasks left</span>
                        <span class="label label-success">{{ completedTasks() }} tasks completed</span>

                    </div>      
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.fetchData();
            // this.create();
        },

        data () {
            return {
                tasks: [],
                task: {
                    name : '',
                }


            }
        },

        methods: {
            remainingTasks() {
                return this.tasks.filter(task => {
                    return !task.completed
                }).length
            },

            completedTasks(){
                return this.tasks.filter(task => {
                    return task.completed
                }).length
            },

            fetchData () {
                axios.get('/tasks')
                        .then((res) => {
                            this.tasks = res.data
                        })
                        .catch((err) => {
                            console.log(err);
                        })
            },

            create() {
                axios.post('/tasks', this.task)
                    .then((res) =>{
                        console.log(res)

                        this.tasks.unshift(res.data)
                        this.task.name = ''
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            },

            done(task) {
                axios.put(`/tasks/${task.id}`, {
                    completed: !task.completed
                })
                .then((res) => {
                    // alert('sj');
                    console.log('task updated');
                })
                .catch((err) => {
                    console.log(err);
                })
            },

            remove (task) {
                axios.delete(`/tasks/${task.id}`)
                    .then((res) => {
                        const taskIndex = this.tasks.indexOf(task)
                        this.tasks.splice(taskIndex, 1)                    
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            }
        }


    }
</script>

<style type="text/css">
    body, .tasks-list {
        padding-top: 20px;
    }

    .done label {
        text-decoration: line-through;
    }

    .white{
        color:green;
        font-weight: bold;
        font-size: 15px;
    }

    .dump{
        color:red;
    }

    .head{
        color: green;
        font-size: 30px;

    }
    /*.done span {
        text-decoration: line-through;
    }*/
    /*.nn{
        color: red;
        font-weight: bold;
    }*/
</style>
