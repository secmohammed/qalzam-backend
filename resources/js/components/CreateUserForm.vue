<template>
<div>
<div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">name <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input v-model="form.name" type="text" class="form-control "   placeholder="name">
      <div class="row">
            <div class="col-md-12">
         <div v-if="errors['name'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["name"][0] }}</div>
                </div>
            </div>
              </div>
        </div>
              
    </div>
  
       <div class="form-group row">
        <label class=   "col-form-label text-right col-lg-2 col-sm-12">email <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="email"  v-model="form.email" class="form-control email"
                   value="" placeholder="email">
           
         <div v-if="errors['email'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["email"][0] }}</div>
                </div>
        </div>
       </div>
       
      
      
       
       <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">mobile <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="number" class="form-control "v-model="form.mobile"
                   placeholder="mobile" value="mobile">
          
         <div v-if="errors['mobile'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["mobile"][0] }}</div>
                </div>
        </div>
       </div>
       
      
   
  
     
        <div class="d-flex justify-content-between">

          <button class="btn btn-secondary" @click.prevent="$emit('prevClicked')" >
                previous
            </button>
          <button class="btn btn-primary" @click.prevent="createUser" >
                Create User
            </button>
        </div>
   </div>
   

</template>

<script>
export default {
    props:{
        roles:{
            type:Array,
            required:true

        },
          auth_token: {
            required: true,
            type: String,
        },
        
    },
    data() {
        return {
            errors: [],
          
            form: {
                
                name:"",
                mobile:"",
                email: "",
            },
        }
    },
        methods: {
            createUser(){
        let data = new FormData();
        for(let key in this.form )
        {
        data.append(key,this.form[key]);

        }

 axios.post("/api/store-fast-user", data, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                    'Content-Type': 'application/json'

                },
            }).then(({data:{data:user,  meta:{token}}}) => {
                // {}
                        console.log("🚀 ~ file: CreateUserForm.vue ~ line 204 ~ createUser ~ token", token)
                        console.log("🚀 ~ file: CreateUserForm.vue ~ line 204 ~ createUser ~ data", user)
                        this.$emit("userCreated",{id:user.id,token});
            }).catch((err) => {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 257 ~ save ~ err.response.data.errors", err.response.data.errors, err.response)
                console.log("🚀 ~ file: CreateUserForm.vue ~ line 198 ~ createUser ~ err", err)
                this.errors = err.response.data.errors;
               
            });

            }
            ,
               selectFile(event) {
            this.form.image = event.target.files[0];
        }
        },
    computed: {
        isCreateOrderButtonDisabled() {
            return this.form.length 
        },
        },    
    mounted(){
    //    this.roles
       console.log("🚀 ~ file: CreateUserForm.vue ~ line 124 ~ mounted ~ this.roles", this.roles)
    }
}
</script>