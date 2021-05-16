<template>
<div>

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
        <label class="col-form-label text-right col-lg-2 col-sm-12">City  </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <multiselect :searchable="true" v-model="cityValue" track-by="id" label="name" :options="cities"></multiselect>

           
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">Name  </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
 <input class="form-control" name="name" v-model="form.name" type="text" placeholder="name">

           
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">Postal code  </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
 <input class="form-control" name="name" v-model="form.postal_code" type="text" placeholder="postal code">

           
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">landMark  </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
                             <input class="form-control" name="landmark" v-model="form.landmark" type="text" placeholder="land mark" value="">

           
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">location <span style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <multiselect :searchable="true" v-model="locationsValue" track-by="id" label="name" :options="locations"></multiselect>

            <div v-if="errors['location_id'] " class="fv-plugins-message-container">
                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["location_id"][0] }}</div>
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
import Multiselect from 'vue-multiselect'
import axios from 'axios'
export default {
    components: {

        Multiselect
    },
    props: {
       
        auth_token: {
            required: true,
            type: String,
        },

    },
    watch: {
        "locationsValue"(val) {
            this.form.location_id = val.id
        },
        async "cityValue"(val) {
        console.log("🚀 ~ file: CreateAddressForm.vue ~ line 82 ~ val", val)
                const {
                data:{data: locations}
            } = await axios.get("/api"+"/location/city-districts?id=" + val.id);
            console.log("🚀 ~ file: AddAddressModal.vue ~ line 91 ~ districts", locations)
            this.locations = locations
        },
    },
        data() {
            return {
                errors: [],
                locations:[],
                cities:[],
                defaults: [{
                        status: 1,
                        name: "active"
                    },
                    {
                        status: 0,
                        name: "inActive"
                    }
                ],
                locationsValue: {},
                cityValue: {},
                form: {

                    location_id: '',
                    name: '',
                    landmark: '',
                    address_1: '',
                    postal_code: '',

                },
            }
        },
        methods: {
            createAddress() {

                axios.post("/api/addresses", this.form, {
                    headers: {
                        Authorization: "Bearer " + this.auth_token,
                        'Content-Type': 'application/json'

                    },
                }).then(({
                    data: {
                        data: address
                    }
                }) => {
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
     async mounted() {
        const {
            data:{data: cities}
        } = await axios.get("/"+this.$dashboardPrefix+"/locations?filter[type]=city");
        this.cities = cities;
    },
}
</script>
