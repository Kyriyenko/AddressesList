<template>
<div>
    <navbar></navbar>
    <div class="container">
        <form @submit.prevent="addPost">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Enter first name</label>
                <input v-model="post.title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Enter last name</label>
                <input v-model="post.description" type="text" class="form-control" id="exampleInputPassword1">
            </div>
            <button  type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container mt-5">
        <table class=" table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Do</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts":key="post.id">
                <td>{{post.id}}</td>
                <td>{{post.title}}</td>
                <td>{{post.description}}</td>
                <td>
                    <button  @click="editPost(post)"  type="button" class="btn btn-warning">Edit</button>
                    <button  @click="deletePost(post.id)" type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export  default {
    data(){
        return{
            posts:[],
            post:{
              id:'',
              title:'',
              description:''
            },
            editId:'',
            btnFun:'create user',
            pagination:{},
            edit:false,
            loading:true,
            errored:false

        }
    },
    mounted() {
    this.getPosts()
    },
    methods:{
        getPosts(){
            axios
                .get(`/api`)
                .then(response=>{
                    this.posts=response.data.data
                })
                .catch(error=>console.log(error))
                .finally(()=>this.loading=false)
        },
        deletePost(id){
            axios
            .head(`/api/delete/${id}`)
                .then(response=>{
                    this.getPosts()
                })
                .catch(error=>console.log(error))
            .finally()

        },

        addPost(){
            if(this.post.title===""||this.post.description==="") {
                return;
            }
            if (this.edit===false){
                    axios
                .head(`api/posts/${this.post.title}/${this.post.description}`)
                        .then(response=>{
                            this.post.title='';
                            this.post.description='';
                            this.getPosts()
                        })
                        .catch(error=>console.log(error))
            }
            else {
                this.btnFun='update users';
                axios
                    .head(`api/edit/${this.editId}/${this.post.title}/${this.post.description}`)
                    .then(response=>{
                        this.post.title='';
                        this.post.description='';
                        this.getPosts()
                        this.edit=false;
                    })
                    .catch(error=>console.log(error))
            }
        },
        editPost(post){
            this.post.title=post.title;
            this.post.description=post.description;
            this.editId=post.id;
            this.edit=true;
        }
    }
}


</script>
