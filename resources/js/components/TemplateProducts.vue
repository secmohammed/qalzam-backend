<template>
    <form action="" @submit.prevent="save">
    <div>
        <div v-for="(product, index) in form.products">
            <input type="text" v-model="form.products[index].id">
            <input type="text" v-model="form.products[index].price">
            <input type="text" v-model="form.products[index].quantity">
        </div>
        <button @click.prevent="addProduct">Add Product</button>
        <button type="submit"></button>
    </div>
        
    </form>
</template>
<script>
    export default {
        props: {
            action: {
                required: true,
                type: String,
            },

            template: {
                required: true,
                type: Object
            },
            auth_token: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                errors: [],
                form: {
                    products: [
                        {id: null, price: null, quantity: null}
                    ],
                }
            }
        },
        mounted() {
        },
        methods: {
            save() {
                axios.post(`temlpates/${this.template.id}/products`, this.form, {
                    headers: {
                        Authorization: 'Bearer ' + this.auth_token
                    }
                }).then(res => {
                    // window.location = '/templates'
                }).catch(err => {
                    // console.log(err.response.data.errors)
                    //set errors array
                })
            },
            addProduct() {
                this.form.products.push(
                    {id: null, price: null, quantity: null}
                )
            }
        }
    }
</script>