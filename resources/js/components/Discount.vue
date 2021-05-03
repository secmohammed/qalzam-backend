<template>
<div>
    <template v-if="step === 1">
        <form action="">
            <div class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">code <span style="color: red"> * </span></label>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    <input type="text" class="form-control " placeholder="code" v-model="form.code" name="code">
                    <div v-if="errors['code'] " class="fv-plugins-message-container">

                        <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["code"][0] }}</div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">status</label>
                <div class="col-lg-10 col-md-9 col-sm-12">

                    <multiselect :searchable="true" v-model="form.status" :options="status"></multiselect>

                    <div v-if="errors['status'] " class="fv-plugins-message-container">

                        <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["status"][0] }}</div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">type</label>
                <div class="col-lg-10 col-md-9 col-sm-12">

                    <multiselect :searchable="true" v-model="form.type" :options="type"></multiselect>

                    <div v-if="errors['type'] " class="fv-plugins-message-container">

                        <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["type"][0] }}</div>
                    </div>

                </div>
            </div>

            <div v-if="form.type" class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">{{ form.type }} <span style="color: red"> * </span> </label>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    <input type="number" name="value" v-model="form.value" min="10" max="10000" class="form-control" placeholder="value " />
                    <div class="row">
                        <div v-if="errors['value'] " class="col-md-12">

                            <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["value"][0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">Number of usage <span style="color: red"> * </span> </label>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    <input type="number" name="number_of_usage" v-model="form.number_of_usage" min="10" max="10000" class="form-control" placeholder="Number of usage " />
                    <div class="row">
                        <div v-if="errors['number_of_usage'] " class="col-md-12">

                            <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["number_of_usage"][0] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">Coupon type</label>
                <div class="col-lg-10 col-md-9 col-sm-12">

                    <multiselect :searchable="true" v-model="form.discountable_type" :options="discountTypes"></multiselect>

                    <div v-if="errors['discountable_type'] " class="fv-plugins-message-container">

                        <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["discountable_type"][0] }}</div>
                    </div>

                </div>
            </div>

        </form>

        <div v-if="form.discountable_type" class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">{{ discountableType }}</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <!-- <select class=" form-control " v-model="form.accommodation_id" data-placeholder="select accommodation">
                    <option label="Label"></option>
                    <option v-for="accommodation in accommodations" :value="accommodation.id">{{accommodation.name}}</option>
                </select> -->
                <multiselect :searchable="true" v-model="discountIdValue" :multiple="true" track-by="id" label="name" :options="discountIds"></multiselect>

                <div v-if="errors['discountable_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["discountable_id"][0] }}</div>
                </div>
            </div>

        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-right col-lg-2 col-sm-12">customer</label>
            <div class="col-lg-8 col-md-7 col-sm-10">
                <!-- <select class="form-control  " v-model="form.user_id" data-placeholder="select user">
                    <option label="Label"></option>
                    <option v-for="user in  users" :value="user.id">{{user.name}}</option>
                </select> -->
                <multiselect :searchable="true" :taggable="true" @tag="addTagToUser" v-model="usersValue" track-by="id" :multiple="true" label="nameMobile" :options="users"></multiselect>

                <div v-if="errors['user_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["user_id"][0] }}</div>
                </div>
            </div>
            <p @click="goToStep(0)" class="col-lg-2 col-md-2 col-sm-2 text-primary " style="cursor: -webkit-grab; cursor: pointer;"> add new customer > </p>

        </div>
          <div  class="form-group row">
                <label class="col-form-label text-right col-lg-2 col-sm-12">broadcast</label>
                <div class="col-lg-10 col-md-9 col-sm-12">

                    <multiselect :searchable="true" v-model="broadcastValue" track-by="id" label="name"  :options="broadcasts"></multiselect>

                    <div v-if="errors['broadcast'] " class="fv-plugins-message-container">

                        <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["broadcast"][0] }}</div>
                    </div>

                </div>
            </div>

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">Expires at <span style="color: red"> * </span></label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="datetime-local" class="form-control " placeholder="end date" v-model="form.expires_at" name="expires_at" id="expires_at" data-toggle="datetimepicker" data-target="#expires_at">
                <div v-if="errors['expires_at'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["expires_at"][0] }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5">

            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save">
                Create Discount
            </button>
            <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editDiscount">
                Edit Discount
            </button>

        </div>
        </form>
    </template>
    <template v-if="step == 0">
        <CreateUserForm :roles="roles" @prevClicked="goToStep(1)" @userCreated="userCreated($event)" :auth_token="auth_token" />

    </template>
</div>
</template>

<script>
import moment from 'moment'
import CreateUserForm from './CreateUserForm.vue';
import Multiselect from 'vue-multiselect'

export default {
    components: {
        CreateUserForm,
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
        discountable: {
            required: false,
            type: Object,
        },
        action: {
            required: true,
            type: String,
        },

        allUsers: {
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
            branchesValue: {},
            broadcastValue: {},
            discountIdValue: {},
            usersValue: [],
            errors: [],
            step: 1,
            discounts: [],
            discountIds: [],
            discountTypes: ['product', 'variation', 'category'],
            status: ['active', 'inActive'],
            broadcasts: [{id:1,name:'yes'}, {id:0,name:'no'}],
            type: ['percentage', 'amount'],
            users: [],
            newUserToken: "",
            branch_id: "",
            form: {

                users: [],
                type: "",
                discountable_id: null,
                discountable_type: null,
                expires_at: "",
                value: "",
                number_of_usage: "",
                code: "",
                broadcast: null,
            },
        };
    },
    watch: {
        "usersValue"(vals) {
        console.log("🚀 ~ file: Discount.vue ~ line 218 ~ vals", vals)
            const users = vals.map(val=>({id:val.id}))
        console.log("🚀 ~ file: Discount.vue ~ line 218 ~ users", users)
            this.form.users = users
        },
        async "form.discountable_type"(val) {
            console.log("🚀 ~ file: Discount.vue ~ line 206 ~ val", val)
            let discountIds = [];
            switch (val) {
                case 'product':
                    discountIds = await axios.get("/api/products?per_page=10000000000")
                    break;
                case 'variation':
                    discountIds = await axios.get("/api/product_variations?per_page=10000000000")
                    break;
                case 'category':
                    discountIds = await axios.get("/api/categories?per_page=10000000000")
                    break;

                default:
                    break;
            }
            this.discountIds = await discountIds.data.data
            this.discountIdValue = {}
            //   console.log("🚀 ~ file: ReservationProduct.vue ~ line 170 ~ val", val)
            //       const branch = this.branches.find(branch => branch.id == val.id);
            //       console.log("🚀 ~ file: ReservationProduct.vue ~ line 228 ~ this.branches", this.branches)

        },
        "discountIdValue"(val) {
            this.form.discountable_id = val.id
        },
        "broadcastValue"(val) {
            this.form.broadcast = val.id
        },

    },
    computed: {
        discountableType() {
            return this.form.discountable_type === 'variation' ? "product variations" : this.form.discountable_type
        }
        // isCreateOrderButtonDisabled() {
        //     return this.form.products.length
        // },
        // isNextStepDisabled() {
        //     return this.form.user_id && this.form.branch_id && this.form.address_id
        // },
        // canBeSubmited() {
        //     return this.errors.length === 0;
        // },

    },
    mounted() {
        this.users = this.allUsers
        this.users.forEach(function(user){
            user.nameMobile = user.name + ' | ' + user.mobile
            console.log(user.nameMobile)
        })
        if (this.action === 'edit') {

            console.log("🚀 ~ file: Discount.vue ~ line 293 ~ mounted ~ this.edit", this.edit)
            console.log("🚀 ~ file: Discount.vue ~ line 296 ~ mounted ~ this.discountable", this.discountable)
            this.form.code = this.edit.code
            this.form.value = this.edit.value
            this.form.type = this.edit.type
            this.usersValue = this.edit.users
            this.form.expires_at = moment(this.edit.expires_at ).format("YYYY-MM-DDTHH:MM")
            this.form.number_of_usage = this.edit.number_of_usage
            this.form.discountable_type = this.edit.discountable_type
            this.form.status = this.edit.status
            this.discountIdValue = this.discountable

        }
    },
    methods: {
        goToStep(step) {
            this.step = step
        },
        userCreated(user) {
            this.users.push(user);
            this.form.user_id = user.id;
            this.newUserToken = user.token;
            this.step = 1
        },
        addTagToUser(newTag) {
            console.log("🚀 ~ file: Discount.vue ~ line 300 ~ addTagToUser ~ newTag", newTag)

            //   this.options.push(tag)
            this.form.users(newTag)

            console.log("🚀 ~ file: Discount.vue ~ line 302 ~ addTagToUser ~ this.form.users", this.form.users)
        },

        save() {

            axios.post("/api/discounts", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location = "/discounts"
            }).catch((err) => {
                this.errors = err.response.data.errors;
                if ("user_id" in this.errors || "address_id" in this.errors || "branch_id" in this.errors) {
                    this.step = 1
                }
                // check if err contains the array of validation errors and then set errors property
            });
        },

        editDiscount() {
            axios.put(`/api/discounts/${this.edit.id}`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location = `/discounts/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;

            });
        },
    },
};
</script>
