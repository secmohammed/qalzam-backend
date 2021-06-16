<template>
<div>
   <template v-if="step === 1">
        <form action="">

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <!-- <select class="form-control  " v-model="branch_id" data-placeholder=" select branch">
                    <option label="Label"></option>
                    <option v-for="branch in  branches " :value="branch.id">{{branch.name}}</option>
                </select> -->

                <multiselect :searchable="true" v-model="branchesValue" track-by="id" label="name" :options="branches"></multiselect>

                <div v-if="errors['branch_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["branch_id"][0] }}</div>
                </div>

            </div>
        </div>
      </form>  <div class="form-group row align-items-center">
            <label class="col-form-label text-right col-lg-2 col-sm-12">customer</label>
            <div class="col-lg-8 col-md-7 col-sm-10">
                <!-- <select class="form-control  " v-model="form.user_id" data-placeholder="select user">
                    <option label="Label"></option>
                    <option v-for="user in  users" :value="user.id">{{user.name}}</option>
                </select> -->
                <multiselect :searchable="true" v-model="usersValue" track-by="id" label="nameMobile" :options="users"></multiselect>

                <div v-if="errors['user_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["user_id"][0] }}</div>
                </div>
            </div>
            <p @click="goToStep(0)" class="col-lg-2 col-md-2 col-sm-2 text-primary " style="cursor: -webkit-grab; cursor: pointer;"> add new customer > </p>

        </div>

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">accommodation</label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <!-- <select class=" form-control " v-model="form.accommodation_id" data-placeholder="select accommodation">
                    <option label="Label"></option>
                    <option v-for="accommodation in accommodations" :value="accommodation.id">{{accommodation.name}}</option>
                </select> -->
                <multiselect :searchable="true" v-model="accommodationsValue" track-by="id" label="name" :options="accommodations"></multiselect>

                <div v-if="errors['accommodation_id'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["accommodation_id"][0] }}</div>
                </div>
            </div>

        </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">Start date <span style="color: red"> * </span></label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="datetime-local"  v-model="form.start_date" class="form-control " placeholder="start date" name="start_date" id="start_date" data-toggle="datetimepicker" data-target="#start_date">
                <div v-if="errors['start_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["start_date"][0] }}</div>
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
        <!-- <div class="form-group row">
            <label class="col-form-label text-right col-lg-2 col-sm-12">End date <span style="color: red"> * </span></label>
            <div class="col-lg-10 col-md-9 col-sm-12">
                <input type="datetime-local" class="form-control" placeholder="end date" v-model="form.end_date" name="end_date" id="end_date" data-toggle="datetimepicker" data-target="#end_date">
                <div v-if="errors['end_date'] " class="fv-plugins-message-container">

                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["end_date"][0] }}</div>
                </div>
            </div>
        </div> -->

        <div class="d-flex justify-content-center mt-5">

            <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save">
                Create Reservation
            </button>
            <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editReseravation">
                Edit Reservation
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
 import Multiselect from 'vue-multiselect'

export default {
  components: { CreateUserForm ,
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
        accommodation: {
            required: false,
            type: Object,
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
            accommodationsValue: {},
            usersValue: {},
            errors: [],
            step: 1,
            edit:{},
            discounts: [],
            accommodations: [],
            statusValue:"",
            users:[],
            branches:[],
            users:[],
            newUserToken: "",
                statuses: [
                'upcoming', 'done', 'delivered'
            ],
            branch_id: "",
            form: {

                user_id: null,
                accommodation_id: null,
                start_date: "",
                status:''
                // end_date: "",
            },
        };
    },
    watch: {
           "usersValue"(val) {
            this.form.user_id= val.id
        },
          "branchesValue"(val) {
        //       const branch = this.branches.find  (branch => branch.id == val.id);
        //       console.log("🚀 ~ file: ReservationProduct.vue ~ line 228 ~ this.branches", this.branches)

          this.accommodations = val.accommodations
        },
          "accommodationsValue"(val) {
            this.form.accommodation_id = val.id
        },

     "statusValue"(val) {
            console.log(val)
            this.form.status = val
        },


        "form.start_date"() {
            // this.form.end_date = moment(this.form.start_date).add(4, "hours").format("MM/DD/YYYY HH:MM");
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
 async   mounted() {
      const {data:{data:branches}} =   await axios.get('/api/branches?per_page=10000000&include=accommodations', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
         const {data:{data:users}} =   await axios.get('/api/users?per_page=10000000s', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
        this.users = users
        this.branches = branches
        this.users.forEach(function(user){
            user.nameMobile = user.name + ' | ' + user.mobile
        })
        if (this.action === 'edit') {
              const {data:{data:edit}} =   await axios.get(`/api/reservations/${this.id}?include=user,accommodation,accommodation.branch.accommodations`, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
            this.edit = edit;
            console.log(this.edit,"edit",moment(this.edit.start_date ).format("HH"));
            this.edit.user.nameMobile = this.edit.user.name + ' | ' +  this.edit.user.mobile
            this.usersValue = this.edit.user;
            this.statusValue = this.edit.status;

            // this.form.branch_id = this.edit.branch_id
            this.branchesValue =  this.edit.accommodation.branch
            this.accommodationsValue = this.edit.accommodation
            this.accommodations = this.edit.accommodation.branch.accommodations
            this.form.start_date = moment(this.edit.start_date).format("YYYY-MM-DDTHH:mm");
            // this.form.end_date = moment(this.edit.end_date).format("YYYY-MM-DDTHH:mm");

      

        } 
        console.log(this.edit,'edit')
    },
    methods: {
        goToStep(step) {
            this.step = step
        },
        userCreated(user){
            this.users.push(user.user);
            this.usersValue =user.user;
            this.newUserToken =user.token;
            this.step = 1
        },

        save() {


            axios.post("/api/reservations", this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location = `/${this.$dashboardPrefix}/reservations`
            }).catch((err) => {

              this.errors = err.response.data.errors;
              const toastMessage = err.response.data.message
              if(toastMessage)toastr.error(toastMessage);


                // check if err contains the array of validation errors and then set errors property
            });
        },

        editReseravation() {
            axios.put(`/api/reservations/${this.edit.id}`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location = `/${this.$dashboardPrefix}/reservations/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;
              const toastMessage = err.response.data.message

                if(toastMessage)
                {

}
toastr.error(toastMessage)

            });
        },
    },
};
</script>
