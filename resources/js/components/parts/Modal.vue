<template>
    <div>
        <form>
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CONTACT</h5>
                        <button  type="button" v-on:click="$emit('updated')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Enter first name</label>
                            <input v-model="userName" type="text" class="form-control" placeholder="Full name" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1"  class="form-label">Enter your email</label>
                            <input v-model="userEmail" type="text" class="form-control" placeholder="email" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Enter your address</label>
                            <input v-model="userAddress" type="text" class="form-control" placeholder="address" id="examplesInputPassword1">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button  v-on:click="$emit('updated')" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button  v-on:click="addPost" type="button" class="btn btn-primary">GO</button>
                    </div>
                    <div  v-if="validateErrors.length>0" class="alert alert-danger" role="alert">
                        <ul id="example-1">
                            <li v-for="item in validateErrors" :key="item.message">
                                {{ item}}
                            </li>
                        </ul>
                    </div>
                    <div v-if="isUpdated">
                        <div class="alert alert-success" role="alert">
                           Dates was updated
                        </div>
                    </div>
                    <div v-if="isCreated">
                        <div class="alert alert-success" role="alert">
                            Dates was created
                        </div>
                    </div>

<!--                    {{fieldEditable}}-->
<!--                    <span v-on:click="this.fieldEditable = !this.fieldEditable">aaaaaaaaa</span>-->
                </div>
             </div>

        </form>
    </div>
</template>


<script>
export default {
    name:'modal',
    props:['edit', 'name','email','address','postId'],

    data(){

        return{
            isUpdated:false,
            isCreated:false,
            validateErrors:[],
            userName:'',
            userEmail:'',
            userAddress:'',
            userPostId:'',

        }
    },

    mounted() {
        console.log( {
            name:this.name,
            email:this.email,
            address:this.address,
            id:this.postId
        });
        this.userName = this.name;
        this.userEmail = this.email;
        this.userAddress = this.address;
        this.userPostId = this.postId;
    },

    watch: {
        'name':function (value, oldValue) {
            this.userName = value;
        },
        'email':function (value, oldValue) {
            this.userEmail = value;
        },
        'address':function (value, oldValue) {
            this.userAddress = value;
        },
    },
    computed: {
        fieldEditable: {
            get() {
                return this.edit;
            },
            set(value) {
                this.$emit('updateEditable', value)
            }

        }
    },


    methods: {
        updateEditable() {
            console.log(this.fieldEditable);
            this.fieldEditable = !this.fieldEditable;

        },
        addPost() {
            let dataObject = {
                name:this.userName,
                email:this.userEmail,
                address:this.userAddress,
                id:this.userPostId
            };



            this.validation(dataObject.name,dataObject.email,dataObject.address)

            if(this.validateErrors.length>0){
                return;
            }

            if (this.edit) {
                axios
                    .post(`api/edit/`,dataObject)
                    .then(response => {
                        this.isUpdated=true
                        setTimeout(()=>this.isUpdated=false, 2000);
                    })
                    .catch(error => console.log(error))
                    .finally()
                document.querySelector('body').style.backgroundColor = '#ffff';
            } else {
                axios
                    .post(`api/posts/`,dataObject)
                    .then(response => {
                        this.isCreated=true
                        setTimeout(()=>this.isCreated=false, 2000);

                    })
                    .catch(error => console.log(error))
                    .finally()

            }
        },



        validation(name,email,address){
            let regEmailCheck=/^[^]+@[^ ]+\.[a-z]{2,3}$/;
            let regNumCheck=/[0-9]/;

            this.validateErrors = []

            if(name===''||email===''||address===''){
                this.validateErrors.unshift('all fields are required')
                return;
            }

            if(!email.match(regEmailCheck))
                this.validateErrors.unshift('invalid field email');

            if(regNumCheck.test(name)){
                this.validateErrors.unshift('invalid field name');
            }

        },


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



