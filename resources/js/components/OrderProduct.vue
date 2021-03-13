<template>
 <form action="">
     
    <template v-if="step == 1">
      
     <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class="form-control  " v-model="form.branch_id" data-placeholder=" select branch">
                 <option label="Label"></option>
                 <option v-for="branch in  branches " :value="branch.id">{{branch.name}}</option>
             </select>

         </div>
     </div>
     <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">user</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class="form-control  " v-model="form.user_id" data-placeholder="select user">
                 <option label="Label"></option>
                 <option v-for="user in  users" :value="user.id">{{user.name}}</option>
             </select>
         </div>
     </div>
      <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">address</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class=" form-control " v-model="form.address_id" data-placeholder="select address">
                 <option label="Label"></option>
                 <option v-for="address in addresses" :value="address.id">{{address.name}}</option>
             </select>
             
         </div>
     </div>

    </template>
     <!-- step2 -->
     <template v-if="step == 2">
         <div v-for="(product, index) in form.products">
           <div class="form-group row">
             <div class="col-md-2 col-form-label">
                 product
             </div>



             <div class="col-md">
                 <div class="row">
                     <div class="col-md">
                         <select v-model="form.products[index].id" class="form-control kt_select2_products ">
                             <option label="Label"></option>
                             <option v-for="product in products" :value="product.id">{{ product.name }}</option>

                         </select>

                     </div>
                     <div class="form-group mr-2">

                         <input class="form-control " v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />

                     </div>
                     <div class="col-md-auto">

                         <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click.prevent="removeProduct(index)">
                             <i class="fa fa-trash-alt"></i>
                         </button>
                     </div>
                 </div>

             </div>
         </div>
     </div>
      <div class="form-group row">
             <div class="col-md-2 col-form-label">
                 discount
             </div>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class=" form-control " v-model="form.discount_id" data-placeholder="select discount">
                 <option label="Label"></option>
                 <option v-for="discount in discountes" :value="discount.id">{{discount.name}}</option>
             </select>
             
         </div>
     </div>
          <div class="d-flex justify-content-end mt-5">

         <button class="btn btn-secondary" @click.prevent="addProduct">
            Add Product
         </button>

     </div>

     </template>
   

     <div class="d-flex justify-content-between mt-5">
         <button class="btn btn-primary " @click.prevent="previousStep" v-if="step != 1">
             Previous Step
         </button>
         <template v-if="step == 1">
             <button class="btn btn-secondary " @click.prevent="nextStep" :disabled="!isNextStepDisabled">
                 Next Step
             </button>
            
         </template>
         <template v-else>
             <button class="btn btn-secondary" @click.prevent="save" :disabled="!isCreateOrderButtonDisabled">
                 Create Order
             </button>
             
         </template>

     </div>
    </form>
</template>

<script>
export default {
    props: {
        action: {
            required: true,
            type: String,
        },
        auth_token: {
            required: true,
            type: String,
        },
        branches: {
            required: true,
            type: Array,
        },
        users: {
            required: true,
            type: Array,
        },
    },
    data() {
        return {
            errors: [],
            step: 1,
            discounts: [],
            addresses: [],
            products: [],
            form: {
                products: [
                {
                    id: null,
                    quantity: null
                }],
                user_id: null,
                branch_id: null,
                address_id: null,
                discount_id: null,
            },
        };
    },
    watch: {
        "form.user_id"(val) {
            const {
                addresses,
                discounts
            } = this.users.find(
                (user) => user.id == val
            );1
            this.addresses = addresses;
            this.discounts = discounts;
        },
        "form.branch_id"(val) {
            this.products = this.branches.find(branch => branch.id == val).products
        }
    },
    computed: {
        isCreateOrderButtonDisabled() {
            // return this.form.products.length && this.form.discount_id
            return this.form.products.length 
        },
        isNextStepDisabled() {
            return this.form.user_id && this.form.branch_id &&  this.form.address_id
        },
        canBeSubmited() {
            return this.errors.length === 0;
        },

    },
    // mounted() {
    //     console.log(",smlddk")
    // },
    // ,
    methods: {
        nextStep() {
            this.step++;
        },
        previousStep() {
            this.step--;
        },
        removeProduct(index) {
            this.form.products.splice(index, 1)
        },
        addProduct() {
            this.form.products.push(
                {id: null, quantity: null}
            )
        },
        save() {
                    console.log("🚀 ~ file: OrderProduct.vue ~ line 209 ~ save ~ this.auth_token", this.auth_token)

            axios.post("/api/orders", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log(res);
                // window.location = "/orders"
            }).catch((err) => {
                console.log(err.response.data.errors);
                // check if err contains the array of validation errors and then set errors property
            });
        },
    },
};
</script>
