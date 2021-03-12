<template>
 <!-- step 1 -->
 <form action="">
     <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">address</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class="form-control select2 " v-model="form.address_id" data-placeholder="select address">
                 <option label="Label"></option>
                 <option v-for="address in addresses" :value="address.id">{{address.name}}</option>
             </select>
             
         </div>
     </div>
     <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class="form-control select2 " v-model="form.branch_id" data-placeholder=" select branch">
                 <option label="Label"></option>
                 <option v-for="branch in  branches " :value="branch.id">{{branch.name}}</option>
             </select>

         </div>
     </div>
     <div class="form-group row">
         <label class="col-form-label text-right col-lg-2 col-sm-12">user</label>
         <div class="col-lg-10 col-md-9 col-sm-12">
             <select class="form-control select2 " v-model="form.user_id" data-placeholder="select user">
                 <option label="Label"></option>
                 <option v-for="user in  users " :value="user.id">{{user.name}}</option>
             </select>
         </div>
     </div>

     <!-- step2 -->

     <div class="form-group row">
         <div v-for="(product, index) in form.products">

             <div class="col-md-2 col-form-label">
                 products
             </div>

             <div class="col-md">
                 <div class="row">
                     <div class="col-md">
                         <select v:model="form.products[index].id" class="form-control kt_select2_products ">
                             <option label="Label"></option>
                             <option v-for="procutsVariation in productVariations" :value="procutsVariation.id">{{ procutsVariation.name }}</option>

                         </select>

                     </div>
                     <div class="form-group mr-2">

                         <input class="form-control " v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />

                     </div>
                     <div class="form-group">

                         <input class="form-control price " v-model="form.products[index].price" type="numeric" placeholder="price" />

                     </div>
                     <div class="col-md-auto">

                         <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click="removeProduct(index)">
                             <i class="fa fa-trash-alt"></i>
                         </button>
                     </div>
                 </div>

             </div>
         </div>
     </div>

     <div class="d-flex justify-content-end mt-5">

         <button class="btn btn-secondary " @click="addProduct">
             add porduct
         </button>

     </div>

     <div class="d-flex justify-content-between mt-5">
         <button class="btn btn-primary " @click.prevent="">
             previous
         </button>

         <button class="btn btn-secondary " @click.prevent="submit">
             create order
         </button>

     </div>
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
            form: {
                products: [],
                user_id: null,
                branch_id: null,
                address_id: null,
                discount_id: null,
            },
        };
    },
    mounted() {},
    watch: {
        "form.user_id"(val) {
            const {
                addresses,
                discounts
            } = this.users.find(
                (user) => user.id == val
            );
            this.addresses = addresses;
            this.discounts = discounts;
        },
    },
    methods: {
        canBeSubmited() {
            return this.errors.length === 0;
        },
        nextStep() {
            this.step++;
        },
        previousStep() {
            this.step--;
        },
        save() {
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
