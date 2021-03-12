<template> 
</template>
<script>
export default {
    props: {
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
            const { addresses, discounts } = this.users.find(
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
