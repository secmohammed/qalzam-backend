<template>
<form action="">

    <template v-if="step == 1">

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
            <div class="col-lg-10 col-md-9 col-sm-12">

                <multiselect :searchable="true" v-model="branchesValue" track-by="id" label="name" :options="branches"></multiselect>
                <div v-if="errors['branch_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["branch_id"][0] }}</div>
                </div>

            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-right col-lg-2 col-sm-12">customer</label>
            <div class="col-lg-8 col-md-7 col-sm-10">

                <multiselect :searchable="true" v-model="usersValue" track-by="id" label="nameMobile" :options="users"></multiselect>

                <div v-if="errors['user_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["user_id"][0] }}</div>
                </div>
            </div>
            <p @click="goToStep(0)" class="col-lg-2 col-md-2 col-sm-2 text-primary " style="cursor: -webkit-grab; cursor: pointer;"> add new user > </p>

        </div>

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">address</label>
            <div class="col-lg-10 col-md-9 col-sm-12">

                <multiselect :searchable="true" v-model="addressesValue" track-by="id" label="name" :options="addresses"></multiselect>

                <div v-if="errors['address_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["address_id"][0] }}</div>
                </div>
            </div>

        </div>

        <div v-if="action === 'edit'"  class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">Status</label>
            <div class="col-lg-10 col-md-9 col-sm-12">

                <multiselect :searchable="true" v-model="statusValue" :options="statuses"></multiselect>

                <div v-if="errors['status'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["status"][0] }}</div>
                </div>
            </div>

        </div>
        <div   class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">payment type </label>
            <div class="col-lg-10 col-md-9 col-sm-12">

                <multiselect :show-labels="false"  v-model="paymentTypeValue" :options="paymentWays"></multiselect>

                <div v-if="errors['payment_type'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["payment_type"][0] }}</div>
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

                <multiselect :searchable="true" v-model="productsValue[index]" @select="(data)=> { productSelected(data,index)}" track-by="id" label="name" :options="products"></multiselect>


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
                <multiselect :searchable="true" v-model="discountsValue" track-by="id" label="code" :options="discounts"></multiselect>


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
            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save" >
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
 import Multiselect from 'vue-multiselect'
import axios from 'axios';
export default {
    components: {
        CreateUserForm,
        CreateAddressForm,
        Multiselect
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
    

        roles: {
            required: true,
            type: Array,
        },
  
        id: {
            required: false,
           
        },
    },
    data() {
        return {

            branchesValue: {},
            addressesValue: {},
            usersValue: {},
            discountsValue: {},
            productsValue: [],
            errors: [],
            step: 1,
            edit:{},
            discounts: [],
            addresses: [],
            locations:[],
            allUsers:[],

            users:[],
            statuses: [
                'pending','picked','processing','delivered'
            ],
            paymentWays: [
               'visa','cash'
            ],
            statusValue:'',
            branches:[],
            paymentTypeValue:'',
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
                status:'',
            },

        };
    },
    watch: {
        "usersValue"(val) {
            const {
                addresses,
                discounts
            } = this.users.find(
                (user) => user.id == val.id
            );
                console.log("🚀 ~ file: OrderProduct.vue ~ line 227 ~ discounts", discounts)

            this.addresses = addresses;
            this.discounts = discounts;
            this.form.user_id= val.id

        },
        "branchesValue"(val) {
            this.products = this.branches.find(branch => branch.id == val.id).products
            this.form.branch_id= val.id
        },
        "addressesValue"(val) {
            this.form.address_id= val.id
        },
        "discountsValue"(val) {
            this.form.discount_id= val.id
        },
        "statusValue"(val) {
            this.form.status = val
        },
        "paymentTypeValue"(val) {
            console.log(val)
            this.form.payment_type = val
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
  async  mounted() {

        
         const {data:{data:branches}} =   await axios.get('/api/branches?per_page=10000000&include=products', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
         const {data:{data:users}} =   await axios.get('/api/users?per_page=10000000&include=addresses,discounts', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
         const {data:{data:locations}} =   await axios.get('/api/locations?per_page=10000000', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
     this.branches = branches
     this.users =users
     this.locations =locations

        this.users.forEach(function(user){
            user.nameMobile = user.name + ' | ' + user.mobile
        })
        if (this.action === 'edit') {
             const {data:{data:edit}} =   await axios.get(`/api/orders/${this.id}?include=user,address,branch,products`, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
            this.edit = edit;
            const branch = this.branches.find(branch=>branch.id === this.edit.branch.id)
            console.log("🚀 ~ file: OrderProduct.vue ~ line 329 ~ mounted ~ branch", branch)
            this.branchesValue = branch;
            console.log("🚀 ~ file: OrderProduct.vue ~ line 330 ~ mounted ~ this.branchesValue", this.branchesValue)

            this.edit.user.nameMobile = this.edit.user.name + ' | ' + this.edit.user.mobile;
            this.usersValue = this.edit.user;

            this.addressesValue = this.edit.address;
            this.paymentTypeValue = this.edit.payment_type;
            this.statusValue = this.edit.status;

            this.edit.products.forEach((product, index) => {
            // console.log("🚀 ~ file: OrderProduct.vue ~ line 267 ~ this.edit.products.forEach ~ product", product)

                this.productsValue[index] = product
                this.form.products[index].quantity = product.pivot.quantity
                this.form.products[index].id = product.id

            });

        }

        // console.log("🚀 ~ file: OrderProduct.vue ~ line 194 ~ mounted ~ this.edit", this.edit, this.branches)
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
                this.$forceUpdate();
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 275 ~ goToStep ~ this.errors", this.errors,this.errors["branch_id"][0])
                return
            }
            this.step = step
        },
            productSelected(product,productIndex) {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2", productIndex,product)
                this.form.products[productIndex].id=product.id
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2",this.form.products)

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
            // console.log("🚀 ~ file: OrderProduct.vue ~ line 269 ~ userCreated ~ id", user)
            this.users.push(user);

          this.form.user_id =user.user.id;
            this.newUserToken =user.token;
            this.step = 0.5
        },
        addressCreated(id){
            // console.log("🚀 ~ file: OrderProduct.vue ~ line 269 ~ addressCreated ~ id", id)
            this.form.address_id =id;
            this.step = 2
        }
        ,
        save() {
// console.log("🚀 ~ file: OrderProduct.vue ~ line 314 ~ save ~ this.form", this.form)

            axios.post("/api/orders", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log("🚀 ~ file: OrderProduct.vue ~ line 259 ~ save ~ res", res)
                window.location = '/' + this.$dashboardPrefix+'/orders'
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
                // console.log(res);
                window.location = `/${this.$dashboardPrefix}/orders/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;

                // check if err contains the array of validation errors and then set errors property
            });
        },
    },
};
</script>
<style>
fieldset[disabled] .multiselect {
	pointer-events: none
}

.multiselect__spinner {
	position: absolute;
	right: 1px;
	top: 1px;
	width: 48px;
	height: 35px;
	background: #fff;
	display: block
}

.multiselect__spinner:after,
.multiselect__spinner:before {
	position: absolute;
	content: "";
	top: 50%;
	left: 50%;
	margin: -8px 0 0 -8px;
	width: 16px;
	height: 16px;
	border-radius: 100%;
	border-color: #ffe2e5 transparent transparent;
	border-style: solid;
	border-width: 2px;
	box-shadow: 0 0 0 1px transparent
}

.multiselect__spinner:before {
	animation: a 2.4s cubic-bezier(.41, .26, .2, .62);
	animation-iteration-count: infinite
}

.multiselect__spinner:after {
	animation: a 2.4s cubic-bezier(.51, .09, .21, .8);
	animation-iteration-count: infinite
}

.multiselect__loading-enter-active,
.multiselect__loading-leave-active {
	transition: opacity .4s ease-in-out;
	opacity: 1
}

.multiselect__loading-enter,
.multiselect__loading-leave-active {
	opacity: 0
}

.multiselect,
.multiselect__input,
.multiselect__single {
	font-family: inherit;
	font-size: 16px;
	-ms-touch-action: manipulation;
	touch-action: manipulation
}

.multiselect {
	box-sizing: content-box;
	display: block;
	position: relative;
	width: 100%;
	min-height: 40px;
	text-align: left;
	color: #35495e
}

.multiselect * {
	box-sizing: border-box
}

.multiselect:focus {
	outline: none
}

.multiselect--disabled {
	opacity: .6
}

.multiselect--active {
	z-index: 1
}

.multiselect--active:not(.multiselect--above) .multiselect__current,
.multiselect--active:not(.multiselect--above) .multiselect__input,
.multiselect--active:not(.multiselect--above) .multiselect__tags {
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0
}

.multiselect--active .multiselect__select {
	transform: rotate(180deg)
}

.multiselect--above.multiselect--active .multiselect__current,
.multiselect--above.multiselect--active .multiselect__input,
.multiselect--above.multiselect--active .multiselect__tags {
	border-top-left-radius: 0;
	border-top-right-radius: 0
}

.multiselect__input,
.multiselect__single {
	position: relative;
	display: inline-block;
	min-height: 20px;
	line-height: 20px;
	border: none;
	border-radius: 8px;
	background: #fff;
	padding: 0 0 0 5px;
	width: 100%;
	transition: border .1s ease;
	box-sizing: border-box;
	margin-bottom: 8px;
	vertical-align: top
}

.multiselect__input::-webkit-input-placeholder {
	color: #35495e
}

.multiselect__input:-ms-input-placeholder {
	color: #35495e
}

.multiselect__input::placeholder {
	color: #35495e
}

.multiselect__tag~.multiselect__input,
.multiselect__tag~.multiselect__single {
	width: auto
}

.multiselect__input:hover,
.multiselect__single:hover {
	border-color: #cfcfcf
}

.multiselect__input:focus,
.multiselect__single:focus {
	border-color: #a8a8a8;
	outline: none
}

.multiselect__single {
	padding-left: 5px;
	margin-bottom: 8px
}

.multiselect__tags-wrap {
	display: inline
}

.multiselect__tags {
	min-height: 40px;
	display: block;
	padding: 8px 40px 0 8px;
	border-radius: 8px;
	border: 1px solid #e8e8e8;
	background: #fff;
	font-size: 14px
}

.multiselect__tag {
	position: relative;
	display: inline-block;
	padding: 4px 26px 4px 10px;
	border-radius: 8px;
	margin-right: 10px;
	color: #fff;
	line-height: 1;
	background:  #f5727f;
	margin-bottom: 5px;
	white-space: nowrap;
	overflow: hidden;
	max-width: 100%;
	text-overflow: ellipsis
}

.multiselect__tag-icon {
	cursor: pointer;
	margin-left: 7px;
	position: absolute;
	right: 0;
	top: 0;
	bottom: 0;
	font-weight: 700;
	font-style: normal;
	width: 22px;
	text-align: center;
	line-height: 22px;
	transition: all .2s ease;
	border-radius: 5px
}

.multiselect__tag-icon:after {
	content: "\D7";
	color: #ffe2e5;
	font-size: 14px
}

.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
	background: #ffe2e5
}

.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
	color: #fff
}

.multiselect__current {
	min-height: 40px;
	overflow: hidden;
	padding: 8px 12px 0;
	padding-right: 30px;
	white-space: nowrap;
	border-radius: 8px;
	border: 1px solid #e8e8e8
}

.multiselect__current,
.multiselect__select {
	line-height: 16px;
	box-sizing: border-box;
	display: block;
	margin: 0;
	text-decoration: none;
	cursor: pointer
}

.multiselect__select {
	position: absolute;
	width: 40px;
	height: 38px;
	right: 1px;
	top: 1px;
	padding: 4px 8px;
	text-align: center;
	transition: transform .2s ease
}

.multiselect__select:before {
	position: relative;
	right: 0;
	top: 65%;
	color: #999;
	margin-top: 4px;
	border-style: solid;
	border-width: 5px 5px 0;
	border-color: #999 transparent transparent;
	content: ""
}

.multiselect__placeholder {
	color: #adadad;
	display: inline-block;
	margin-bottom: 10px;
	padding-top: 2px
}

.multiselect--active .multiselect__placeholder {
	display: none
}

.multiselect__content-wrapper {
	position: absolute;
	display: block;
	background: #fff;
	width: 100%;
	max-height: 240px;
	overflow: auto;
	border: 1px solid #e8e8e8;
	border-top: none;
	border-bottom-left-radius: 5px;
	border-bottom-right-radius: 5px;
	z-index: 1;
	-webkit-overflow-scrolling: touch
}

.multiselect__content {
	list-style: none;
	display: inline-block;
	padding: 0;
	margin: 0;
	min-width: 100%;
	vertical-align: top
}

.multiselect--above .multiselect__content-wrapper {
	bottom: 100%;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-bottom: none;
	border-top: 1px solid #e8e8e8
}

.multiselect__content::webkit-scrollbar {
	display: none
}

.multiselect__element {
	display: block
}

.multiselect__option {
	display: block;
	padding: 12px;
	min-height: 40px;
	line-height: 16px;
	text-decoration: none;
	text-transform: none;
	vertical-align: middle;
	position: relative;
	cursor: pointer;
	white-space: nowrap
}

.multiselect__option:after {
	top: 0;
	right: 0;
	position: absolute;
	line-height: 40px;
	padding-right: 12px;
	padding-left: 20px;
	font-size: 13px
}

.multiselect__option--highlight {
	background: #bebbbc;
	outline: none;
	color: #fff
}

.multiselect__option--highlight:after {
	content: attr(data-select);
	background: #bebbbc;
	color: #fff
}

.multiselect__option--selected {
	background: #f3f3f3;
	color: #35495e;
	font-weight: 700
}

.multiselect__option--selected:after {
	content: attr(data-selected);
	color: silver
}

.multiselect__option--selected.multiselect__option--highlight {
	background: #ff6a6a;
	color: #fff
}

.multiselect__option--selected.multiselect__option--highlight:after {
	background: #ff6a6a;
	content: attr(data-deselect);
	color: #fff
}

.multiselect--disabled {
	background: #ededed;
	pointer-events: none
}

.multiselect--disabled .multiselect__current,
.multiselect--disabled .multiselect__select,
.multiselect__option--disabled {
	background: #ededed;
	color: #a6a6a6
}

.multiselect__option--disabled {
	cursor: text;
	pointer-events: none
}

.multiselect__option--group {
	background: #ededed;
	color: #35495e
}

.multiselect__option--group.multiselect__option--highlight {
	background: #35495e;
	color: #fff
}

.multiselect__option--group.multiselect__option--highlight:after {
	background: #35495e
}

.multiselect__option--disabled.multiselect__option--highlight {
	background: #dedede
}

.multiselect__option--group-selected.multiselect__option--highlight {
	background: #ffe2e5;
	color: #fff
}

.multiselect__option--group-selected.multiselect__option--highlight:after {
	background: #ffe2e5;
	content: attr(data-deselect);
	color: #fff
}

.multiselect-enter-active,
.multiselect-leave-active {
	transition: all .15s ease
}

.multiselect-enter,
.multiselect-leave-active {
	opacity: 0
}

.multiselect__strong {
	margin-bottom: 8px;
	line-height: 20px;
	display: inline-block;
	vertical-align: top
}

[dir=rtl] .multiselect {
	text-align: right
}

[dir=rtl] .multiselect__select {
	right: auto;
	left: 1px
}

[dir=rtl] .multiselect__tags {
	padding: 8px 8px 0 40px
}

[dir=rtl] .multiselect__content {
	text-align: right
}

[dir=rtl] .multiselect__option:after {
	right: auto;
	left: 0
}

[dir=rtl] .multiselect__clear {
	right: auto;
	left: 12px
}

[dir=rtl] .multiselect__spinner {
	right: auto;
	left: 1px
}

@keyframes a {
	0% {
		transform: rotate(0)
	}
	to {
		transform: rotate(2turn)
	}
}
</style>
