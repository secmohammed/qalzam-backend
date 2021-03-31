<template>
<div>
   <template v-if="step === 1">
        <form action="">

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <select class="form-control  " v-model="branch_id" data-placeholder=" select branch">
                    <option label="Label"></option>
                    <option v-for="branch in  branches " :value="branch.id">{{branch.name}}</option>
                </select>
                <div v-if="errors['branch_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["branch_id"][0] }}</div>
                </div>

            </div>
        </div>
      </form>  <div class="form-group row align-items-center">
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
            <label class="col-form-label text-right col-lg-2 col-sm-12">accommodation</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <select class=" form-control " v-model="form.accommodation_id" data-placeholder="select accommodation">
                    <option label="Label"></option>
                    <option v-for="accommodation in accommodations" :value="accommodation.id">{{accommodation.name}}</option>
                </select>
                <div v-if="errors['accommodation_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["accommodation_id"][0] }}</div>
                </div>
            </div>

        </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">Start date <span style="color: red"> * </span></label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="text" v-model="form.start_date" class="form-control datetimepicker-input kt_datetimepicker_5" placeholder="start date" name="start_date" id="start_date" data-toggle="datetimepicker" data-target="#start_date">
                <div v-if="errors['start_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["start_date"][0] }}</div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">End date <span style="color: red"> * </span></label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="text" class="form-control datetimepicker-input kt_datetimepicker_5" placeholder="end date" v-model="form.end_date" name="end_date" id="end_date" data-toggle="datetimepicker" data-target="#end_date">
                <div v-if="errors['end_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["end_date"][0] }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5">

            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save">
                Create Order
            </button>
            <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editOrder">
                Edit Order
            </button>

        </div>
    </form>
   </template>
    <template v-if="step == 0">
        <CreateUserForm  :roles="roles" @prevClicked="goToStep(1)" @userCreated="userCreated($event)" :auth_token="auth_token" />

    </template>
</div>
</template>

<script>
import moment from 'moment'
import CreateUserForm from './CreateUserForm.vue';
export default {
  components: { CreateUserForm },

    props: {
        // CreateAddressFormction: {
        //     required: true,
        //     type: String,
        // },
        auth_token: {
            required: true,
            type: String,
        },
        accommodation: {
            required: false,
            type: Object,
        },
        action: {
            required: true,
            type: String,
        },
        branches: {
            required: true,
            type: Array,
        },
        propsUser: {
            required: true,
            type: Array,
        },
        roles: {
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
            accommodations: [],
            users:[],
            newUserToken: "",
            branch_id: "",
            form: {

                user_id: null,
                accommodation_id: null,
                start_date: "",
                end_date: "",
            },
        };
    },
    watch: {
        "branch_id"(val) {
            const branch = this.branches.find(branch => branch.id == val);
            this.accommodations = branch.accommodations

        },
        "form.start_date"(val) {
            console.log("🚀 ~ file: ReservationProduct.vue ~ line 166 ~ val", val)

        }

    },
    computed: {
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
        // this.edit
        // console.log(",smlddk")
        this.users = this.propsUser
        if (this.action === 'edit') {
            this.form.branch_id = this.edit.branch_id
            this.form.user_id = this.edit.user_id
            this.form.accommodation_id = this.accommodation.id
            this.branch_id = this.accommodation.branch.id
            this.form.start_date = this.edit.start_date
            this.form.end_date = this.edit.end_date

        } else {
            this.form.start_date = moment().format("MM/DD/YYYY HH:MM");
            this.form.end_date = moment(this.form.start_date).add(4, "hours").format("MM/DD/YYYY HH:MM");

        }
        // const  = moment();
        //   console.log("🚀 ~ file: ReservationProduct.vue ~ line 195 ~ mounted ~ this.form.start_date", this.form.start_date)
        //     console.log("🚀 ~ file: OrderProduct.vue ~ line 194 ~ mounted ~ this.edit",  this.form.end_date,this.branches)
    },
    // ,
    methods: {
        goToStep(step) {

            this.step = step
        },
          userCreated(user){
            this.users.push(user);
         
         this.form.user_id =user.id; 
            this.newUserToken =user.token; 
            this.step = 1 
        },

        save() {

            // this.form
            console.log("🚀 ~ file: ReservationProduct.vue ~ line 228 ~ save ~ this.form", this.form)

            axios.post("/api/reservations", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log("🚀 ~ file: OrderProduct.vue ~ line 259 ~ save ~ res", res)

                // window.location = "/reservations"
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
            axios.put(`/api/reservations/${this.edit.id }`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                console.log(res);
                // window.location = `/orders/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;

                // check if err contains the array of validation errors and then set errors property
            });
        },
    },
};
</script>
