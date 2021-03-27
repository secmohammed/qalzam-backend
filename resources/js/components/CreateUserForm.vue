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
    <label class="col-form-label text-right col-lg-2 col-sm-12">Name Ar <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input v-model="form.name_ar" type="text" class="form-control"
                placeholder="name Ar">
      
     <div v-if="errors['name_ar'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["name_ar"][0] }}</div>
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
        <label class="col-form-label text-right col-lg-2 col-sm-12">password <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="password" v-model="form.password" name="password" class="form-control "
                   placeholder="password">
         
         <div v-if="errors['password'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["password"][0] }}</div>
                </div>
        </div>
       </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">Password Confirmation <span
                    style="color: red"> * </span> </label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="password" v-model="form.password_confirmation" 
                       class="form-control "
                       placeholder="password confirmation">
             <div v-if="errors['password_confirmation'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["password_confirmation"][0] }}</div>
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
       
       <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">role <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <select class="form-control kt_select2_products " v-model="form.role_id">
                <option label="Label"></option>
                    <option 
                      v-for="role in roles"
                      :value="role.id"

                        :key="role.id "
                         >
                       {{ role.name }}
                        </option>
            </select>
           
         <div v-if="errors['role_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["role_id"][0] }}</div>
                </div>
        </div>
       </div>
   
       <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">type <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <select class="form-control kt_select2_products " v-model="form.type">
            <option label="Label"></option>

                <option v-for="type in types" :key="type" >
                    {{ type }}
                </option>
       
            </select>
       
         <div v-if="errors['type'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["type"][0] }}</div>
                </div>
        </div>
       </div>
        <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">image</label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="file"  @change="selectFile" class="form-control">
           
         <div v-if="errors['image'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["image"][0] }}</div>
                </div>
        </div>
       </div> 
        <div class="d-flex justify-content-center">

          <button class="btn btn-secondry" @click.prevent="$emit('prevClicked')" >
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
            types:[
                        "user",
                        "admin",
                        "branch",
                        "kitchen"

            ],
            form: {
                
                name:"",
                name_ar:"",
                password:"",
                password_confirmation:"",
                mobile:"",
                image:"",
                role_id: null,
                type: "",
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

 axios.post("/api/users", data, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                    'Content-Type': 'application/json'

                },
            }).then(({data:{data:user,  meta:{token}}}) => {
                // {}
                        console.log("🚀 ~ file: CreateUserForm.vue ~ line 204 ~ createUser ~ token", token)
                        console.log("🚀 ~ file: CreateUserForm.vue ~ line 204 ~ createUser ~ data", user)
                        this.$emit("userCreated",{id:user.id,token});
                // window.location = "/orders"
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