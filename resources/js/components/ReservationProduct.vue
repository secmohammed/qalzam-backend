<template>
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">Start date <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
             v-model="start_date"
               class="form-control datetimepicker-input kt_datetimepicker_5"
               placeholder="start date"
               value=""
               data-toggle="datetimepicker"
               data-target="#start_date">
      <div v-if="errors['start_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["start_date"][0] }}</div>
                </div>
    </div>
</div>
        <div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">End date <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
               class="form-control datetimepicker-input kt_datetimepicker_5"
               placeholder="start date"
                v-model="end_date"
               value=""
               data-toggle="datetimepicker"
               data-target="#end_date">
      <div v-if="errors['end_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["end_date"][0] }}</div>
                </div>
    </div>
</div>



 

    <div class="d-flex justify-content-between mt-5">
        
            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save" >
                Create Order
            </button>
            <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editOrder" >
                Edit Order
            </button>

    
    </div>
</form>
</template>

<script>
  import moment from 'moment'
export default {
 
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
        // roles: {
        //     required: true,
        //     type: Array,
        // },
      
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
            newUserToken:"",
            branch_id:"",
            form: {
               
                user_id: null,
                branch_id: null,
                accommodation_id: null,
                discount_id: null,
                start_date: "",
                end_date: "",
            },
        };
    },
    watch: {
        "branch_id"(val) {
            const branch = this.branches.find(branch=>branch.id == val );
            console.log("🚀 ~ file: ReservationProduct.vue ~ line 124 ~ branch", branch)
            this.accommodations = branch.accommodations
            console.log("🚀 ~ file: ReservationProduct.vue ~ line 125 ~ this.accommodations", this.accommodations)
        
        },
    
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
        // if (this.action === 'edit') {
        //     this.form.branch_id = this.edit.branch_id
        //     this.form.user_id = this.edit.user_id
        //     this.form.address_id = this.edit.address_id
        //     this.edit.products.forEach((product, index) => {

        //         this.form.products[index].id = product.id
        //         this.form.products[index].quantity = product.pivot.quantity

        //     });

        // }
        const today = moment();
      this.form.start_date =   today.format("YYYY/MM/DD H:M"); 
      console.log("🚀 ~ file: ReservationProduct.vue ~ line 195 ~ mounted ~ this.form.start_date", this.form.start_date)
        console.log("🚀 ~ file: OrderProduct.vue ~ line 194 ~ mounted ~ this.edit",  this.branches)
    },
    // ,
    methods: {
       
       
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
