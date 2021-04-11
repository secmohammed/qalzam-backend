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

export default {
    components: {

        Multiselect
    },
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
    watch: {
        "locationsValue"(val) {
            this.form.location_id = val.id
        },
    },
        data() {
            return {
                errors: [],
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
                form: {

                    location_id: '',
                    address_1: '',

                },
            }
        },
        methods: {
            createAddress() {

                axios.post("/api/store-fast-address", this.form, {
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
        mounted() {
            //    this.roles
            console.log("🚀 ~ file: CreateUserForm.vue ~ line 124 ~ mounted ~ this.roles", this.auth_token  )
        }
}
</script>
