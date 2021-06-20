<template>
    <form action="" @submit.prevent="save">
        

       <div v-for="(product, index) in form.products">
            <div class="form-group row">
                <div class="col-md-1 col-form-label">
                    product
                </div>

                    <div class="row col-sm-11">
                        <div class="col-sm-6">
                           
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
                        <div class="form-group mr-2">

                            <input class="form-control " v-model="form.products[index].price" type="numeric" placeholder="price" />
                            <div v-if="errors[`products.${index}.price`] " class="fv-plugins-message-container">

                                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.price`][0] }}</div>
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
                     <!-- <div class="col-md-auto">

                         <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click="removeProduct(index)">
                             <i class="fa fa-trash-alt"></i>
                         </button>
                     </div>
                 </div> -->

             </div>
         </div>

        <div class="d-flex justify-content-between mt-12">

            <button class=" btn btn-secondary"  @click.prevent="addProduct">Add Product</button>
                        <button type="submit" v-if="action === 'create'" class="btn btn-primary" @click.prevent="save">Create Product Template</button>
   <button class="btn btn-primary" v-if="action === 'edit'"@click.prevent="save">edit Product Template</button>
        </div>
    </form>
</template>
<script>
 import Multiselect from 'vue-multiselect'

    export default {
        components:{
        Multiselect

        },
        props: {
            action: {
                required: true,
                type: String,
            },

          
            auth_token: {
                required: true,
                type: String
            },
            id: {
                required: true,
            }
        },
        data() {
            return {
                errors: [],
            productsValue: [],
            products: [],
            template: {},

                form: {
                    products: [
                        {id: null, price: null, quantity: null}
                    ],
                }
            }
        },
       async mounted() {

             const {data:{data:products}} =   await axios.get('/api/product_variations?per_page=10000000', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });

             const {data:{data:template}} =   await axios.get(`/api/templates/${this.id}?include=products`, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
            this.products =products;
            this.template =template;

             if (this.action === 'edit') {
 

            this.template.products.forEach((product, index) => {
            // console.log("🚀 ~ file: OrderProduct.vue ~ line 267 ~ this.edit.products.forEach ~ product", product,products.length)

                this.productsValue[index] = product
               this.form.products[index].id = product.id

                this.form.products[index].price = product.pivot.price
                this.form.products[index].quantity = product.pivot.quantity
                  if( index < this.template.products.length-1) this.addProduct()

            });

        }

        },
        methods: {
            save() {


                if(this.action === 'edit')
{
    console.log(this.form,'form')
    axios.put(`/api/template_products/${this.template.id}/update`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {

                window.location = `/${this.$dashboardPrefix}/templates/${this.template.id}`
            }).catch((err) => {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 257 ~ save ~ err.response.data.errors", err.response.data.errors, err.response)
                this.errors = err.response.data.errors;

            });
}
                // console.log(`temlpates/${this.template.id}/products`);
                axios.post(`/api/templates/${this.template.id}/products`, this.form, {
                    headers: {
                        Authorization: 'Bearer ' + this.auth_token
                    }
                }).then(res => {
                    window.location = `/${this.$dashboardPrefix}/templates/${this.template.id}`
                }).catch(err => {
                    this.errors = err.response.data?.errors || [];
                })
            },
            removeProduct(index) {
                this.form.products.splice(index, 1)
            },
             productSelected(product,productIndex) {
                console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2", productIndex,product)
                this.form.products[productIndex].id=product.id
                console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2",this.form.products)

                },
            addProduct() {
                this.form.products.push(
                    {id: null, price: null, quantity: null}
                )
            }
        }
    }
</script>