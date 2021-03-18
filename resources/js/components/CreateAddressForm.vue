<template>
<div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">name <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input v-model="form.name" type="text" class="form-control " placeholder="name">
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
        <label class="col-form-label text-right col-lg-2 col-sm-12">address 1 <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="address_1" v-model="form.address_1" class="form-control address_1" value="" placeholder="address_1">

            <div v-if="errors['address_1'] " class="fv-plugins-message-container">

                <div data-field="address_1" data-validator="notEmpty" class="fv-help-block">{{ errors["address_1"][0] }}</div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">landmark <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="number" class="form-control " v-model="form.landmark" placeholder="landmark" value="landmark">

            <div v-if="errors['landmark'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["landmark"][0] }}</div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">Postal Code <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="number" class="form-control " v-model="form.postal_code" placeholder="postal_code" value="postal_code">

            <div v-if="errors['postal_code'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["postal_code"][0] }}</div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">location <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <select class="form-control kt_select2_products " v-model="form.location_id">
                <option label="Label"></option>
                <option v-for="location in locations" :value="location.id" :key="location.id ">
                    {{ location.name }}
                </option>
            </select>

            <div v-if="errors['location_id'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["location_id"][0] }}</div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">default <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <select class="form-control kt_select2_products " v-model="form.default">
                <option label="Label"></option>
                <option v-for="def in defaults" :value="def.status" :key="def.name ">
                    {{ def.name }}
                </option>
            </select>

            <div v-if="errors['default'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["default"][0] }}</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">

        <button class="btn btn-primary" @click.prevent="createAddress">
            Create Address
        </button>
    </div>
</div>
</template>

<script>
export default {
    props: {
        locations: {
            type: Array,
            required: true

        },
        auth_token: {
            required: true,
            type: String,
        },

    },
    data() {
        return {
            errors: [],
            defaults:[
                {status:1 , name:"active"},
                {status:0 , name:"inActive"}
            ],
            form: {

                name: "",
                landmark : '',
                location_id : '',
                postal_code : '',
                default : '',
                address_id: "",

            },
        }
    },
    methods: {
        createAddress() {
         

            axios.post("/api/addresses", {...this.form}, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then(({data:{
                data: address
            }}) => {
                this.$emit("addressCreated", address.id);
                // window.location = "/orders"
            }).catch((err) => {
                this.errors = err.response.data.errors;

            });

        },
      
    },
    computed: {
        isCreateOrderButtonDisabled() {
            return this.form.length
        },
    },
    mounted() {
        //    this.roles
        console.log("🚀 ~ file: CreateUserForm.vue ~ line 124 ~ mounted ~ this.roles", this.roles)
    }
}
</script>
