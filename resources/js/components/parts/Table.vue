<template>
    <div>
        <modal v-show="modalShow"
            :edit="edit"
            :name="post.name"
            :email="post.email"
               :address="post.address"
               :postId="editId"
            @updated="closeModal()"
               @updateEditable="(value) => edit = value"
        ></modal>
        <div class="container mt-5 table-responsive mb-4">
            <table class=" table table-striped table-hover table-sm ">
                <thead>
                <tr>
                    <th scope="col">FULL NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col"><button  v-on:click="createPost" type="button" class=" btn btn-secondary"  @click="createPost()"> + CREATE</button></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="post in posts":key="post.id">
                    <td>{{post.id}}</td>
                    <td>{{post.name}}</td>
                    <td>{{post.email}}</td>
                    <td>{{post.address}}</td>
                    <td>{{post.created_at.substr(0, 10)}}</td>
                    <td>
                        <button   type="button" class="btn btn-warning" @click="editPost(post)">Edit</button>
                        <button    @click="deletePost(post.id)" type="button" class="btn btn-dark">Delete</button>
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
                name:'',
                email:'',
                address:''
            },
            editId:'',
            modalShow:false,
            btnFun:' ',
            pagination:{},
            edit:false,
            loading:true,
            errored:false,
            validateErrors :[],
            // entityInEdit: {},
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
                .finally(()=> this.loading=false)

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

        validation(){
            let regEmailCheck=/^[^]+@[^ ]+\.[a-z]{2,3}$/;
            let regNumCheck=/[0-9]/;

            this.validateErrors = []

            if(this.post.name===''||this.posts.email===''||this.post.address===''){
                this.validateErrors.unshift('all fields are required')
                return;
            }

            if(!this.post.email.match(regEmailCheck))
                this.validateErrors.unshift('invalid field email');

            if(regNumCheck.test(this.post.name)){
                this.validateErrors.unshift('invalid field name');
            }

        },

        addPost(){
            this.validation()
            if(this.validateErrors.length>0)
                return;

            if (this.edit===false){
                axios
                    .head(`api/posts/${this.post.name}/${this.post.email}/${this.post.address}`)
                    .then(response=>{
                        this.post.name='';
                        this.post.email='';
                        this.post.address='';
                        this.getPosts()
                    })
                    .catch(error=>console.log(error))
            }
            else {
                this.btnFun='update users';
                axios
                    .head(`api/edit/${this.editId}/${this.post.name}/${this.post.email}/${this.post.address}`)
                    .then(response=>{
                        this.post.name='';
                        this.post.email='';
                        this.post.address='';
                        this.getPosts()
                        this.edit=false;
                        this.modalShow=false;
                    })
                    .catch(error=>console.log(error))
                document.querySelector('body').style.backgroundColor ='#ffff';
            }
        },
        editPost(post){
            this.modalShow=true;
            this.post.name=post.name;
            this.post.email=post.email;
            this.post.address=post.address;
            this.editId=post.id;
            this.edit=true;
            document.querySelector('body').style.backgroundColor ='#d2d0d0';
            this.btnFun='push update';
        },
        closeModal(){
            this.getPosts()
            this.post.name='';
            this.post.email='';
            this.post.address='';
            this.modalShow=false;
            this.edit=!this.edit;
            document.querySelector('body').style.backgroundColor ='#ffff';
            this.validateErrors = []

        },
        createPost(){
            this.modalShow=true;
            this.edit=false;
            this.post.name='';
            this.post.email='';
            this.post.address='';
            this.btnFun='create contact';
            document.querySelector('body').style.backgroundColor ='#d2d0d0';

        }
    }
}

</script>
<style>
form{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
</style>
