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
                <div v-if="errors['branch_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["branch_id"][0] }}</div>
                </div>

            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-right col-lg-2 col-sm-12">user</label>
            <div class="col-lg-8 col-md-7 col-sm-10">
                <select class="form-control  " v-model="form.user_id" data-placeholder="select user">
                    <option label="Label"></option>
                    <option v-for="user in  users" :value="user.id">{{user.name}}</option>
                </select>
                <div v-if="errors['user_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["user_id"][0] }}</div>
                </div>
            </div>
            <p @click="goToStep(0)" class="col-lg-2 col-md-2 col-sm-2 text-primary " style="cursor: -webkit-grab; cursor: pointer;"> add new user > </p>

        </div>

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">address</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <select class=" form-control " v-model="form.address_id" data-placeholder="select address">
                    <option label="Label"></option>
                    <option v-for="address in addresses" :value="address.id">{{address.name}}</option>
                </select>
                <div v-if="errors['address_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["address_id"][0] }}</div>
                </div>
            </div>

        </div>

    </template>

    <template v-if="step == 0">
        <CreateUserForm :roles="roles" @prevClicked="goToStep(1)" @userCreated="userCreated($event)" :auth_token="auth_token" />

    </template>
    <template v-if="step == 0.5">
        <CreateAddressForm :auth_token="newUserToken" @addressCreated="addressCreated($event)" :locations="locations" />

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
                            <div v-if="errors[`products.${index}.id`] " class="fv-plugins-message-container">

                                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.id`][0] }}</div>
                            </div>
                        </div>

                        <div class="form-group mr-2">

                            <input class="form-control " v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />
                            <div v-if="errors[`products.${index}.quantity`] " class="fv-plugins-message-container">

                                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.quantity`][0] }}</div>
                            </div>
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
                    <option v-for="discount in discounts" :value="discount.id">{{discount.name}}</option>
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
        <button class="btn btn-primary " @click.prevent="previousStep" v-if="step != 1 && step!=0&& step!=0.5">
            Previous Step
        </button>
        <template v-if="step == 1">
            <button class="btn btn-secondary " @click.prevent="nextStep" :disabled="!isNextStepDisabled">
                Next Step
            </button>

        </template>
        <template v-else-if="step == 2">
            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save" :disabled="!isCreateOrderButtonDisabled">
                Create Order
            </button>
            <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editOrder" :disabled="!isCreateOrderButtonDisabled">
                Edit Order
            </button>

        </template>
        <template v-else>
         

        </template>

    </div>
</form>
</template>

<script>
import CreateAddressForm from './CreateAddressForm.vue';
import CreateUserForm from './CreateUserForm.vue';
export default {
    components: {
        CreateUserForm,
        CreateAddressForm
    },
    props: {
        // CreateAddressFormction: {
        //     required: true,
        //     type: String,
        // },
        auth_token: {
            required: true,
            type: String,
        },
        action: {
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
        roles: {
            required: true,
            type: Array,
        },
        locations: {
            required: true,
            type: Array,
        },
        edit: {
            required: false,
            default: () => {},
            type: Object,
        },
    },
    data() {
        return {
            errors: [],
            step: 1,
            discounts: [],
            addresses: [],
            products: [],
            newUserToken:"",
            form: {
                products: [{
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
            );
            1
            this.addresses = addresses;
            this.discounts = discounts;
        },
        "form.branch_id"(val) {
            this.products = this.branches.find(branch => branch.id == val).products
        }
    },
    computed: {
        isCreateOrderButtonDisabled() {
            return this.form.products.length 
        },
        isNextStepDisabled() {
            return this.form.user_id && this.form.branch_id && this.form.address_id
        },
        canBeSubmited() {
            return this.errors.length === 0;
        },

    },
    mounted() {
        // this.edit
        // console.log(",smlddk")
        if (this.action === 'edit') {
            this.form.branch_id = this.edit.branch_id
            this.form.user_id = this.edit.user_id
            this.form.address_id = this.edit.address_id
            this.edit.products.forEach((product, index) => {

                this.form.products[index].id = product.id
                this.form.products[index].quantity = product.pivot.quantity

            });

        }

        console.log("🚀 ~ file: OrderProduct.vue ~ line 194 ~ mounted ~ this.edit", this.edit, this.branches)
    },
    // ,
    methods: {
        nextStep() {
            this.step++;
        },
        previousStep() {
            this.step--;
        },
        goToStep(step) {
            if(step === 0 && !this.form.branch_id)
            {
                this.errors.branch_id=[ "you should choose branch"]
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 275 ~ goToStep ~ this.errors", this.errors,this.errors["branch_id"][0])
                return
            }
            this.step = step
        },
        removeProduct(index) {
            this.form.products.splice(index, 1)
        },
        addProduct() {
            this.form.products.push({
                id: null,
                quantity: null
            })
        },
        userCreated(user){
            console.log("🚀 ~ file: OrderProduct.vue ~ line 269 ~ userCreated ~ id", user)
          this.form.user_id =user.id; 
            this.newUserToken =user.token; 
            this.step = 0.5 
        },
        addressCreated(id){
            console.log("🚀 ~ file: OrderProduct.vue ~ line 269 ~ addressCreated ~ id", id)
            this.form.address_id =id; 
            this.step = 2 
        }
        ,
        save() {
console.log("🚀 ~ file: OrderProduct.vue ~ line 314 ~ save ~ this.form", this.form)

            axios.post("/api/orders", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log("🚀 ~ file: OrderProduct.vue ~ line 259 ~ save ~ res", res)

                // window.location = "/orders"
            }).catch((err) => {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 257 ~ save ~ err.response.data.errors", err.response.data.errors, err.response)
                this.errors = err.response.data.errors;
                if ("user_id" in this.errors || "address_id" in this.errors || "branch_id" in this.errors) {
                    this.step = 1
                }
                // check if err contains the array of validation errors and then set errors property
            });
        },

        editOrder() {
            axios.put(`/api/orders/${this.edit.id }`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log(res);
                window.location = `/orders/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;

                // check if err contains the array of validation errors and then set errors property
            });
        },
    },
};
</script>
