<template>
<form action="">
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">name <span style="color: red"> * </span></label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" class="form-control " placeholder="name" v-model="form.name" name="name">
            <div v-if="errors['name'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["name"][0] }}</div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">name ar <span style="color: red"> * </span></label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" class="form-control " placeholder="name_ar" v-model="form.name_ar" name="name_ar">
            <div v-if="errors['name_ar'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["name_ar"][0] }}</div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">category type</label>
        <div class="col-lg-10 col-md-9 col-sm-12">

            <multiselect :searchable="true"  v-model="form.categorizable_type" :options="categoriesTypes"></multiselect>

            <div v-if="errors['categorizable_type'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["categorizable_type"][0] }}</div>
            </div>

        </div>
    </div>

    <div v-if="form.categorizable_type" class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">{{ form.categorizable_type }}</label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <!-- <select class=" form-control " v-model="form.accommodation_id" data-placeholder="select accommodation">
                    <option label="Label"></option>
                    <option v-for="accommodation in accommodations" :value="accommodation.id">{{accommodation.name}}</option>
                </select> -->
            <multiselect :searchable="true" v-model="categoryIdValue" track-by="id" label="name" :options="categoryIds"></multiselect>

            <div v-if="errors['discountable_id'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["discountable_id"][0] }}</div>
            </div>
        </div>

    </div>

    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">icon</label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="file" @change="selectFile" class="form-control">

            <div v-if="errors['icon'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["icon"][0] }}</div>
            </div>
<div class="my-3 mx-3 "  v-if="(action==='edit') &&edit.icon  " >
    <img :src="edit.icon " style="cursor:pointer" class="rounded  gallery_pics small-icon "  alt="" >

</div>


        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">parents</label>
        <div class="col-lg-10 col-md-9 col-sm-12">

            <multiselect :searchable="true" v-model="parentsValue" track-by="id" label="name" :options="categories"></multiselect>

            <div v-if="errors['broadcast'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["broadcast"][0] }}</div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save">
            Create Category
        </button>
        <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="editCategory">
            Edit Category
        </button>

    </div>
</form>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
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



        action: {
            required: true,
            type: String,
        },
        typeData: {
            required: false,
            type: Array,
        },
        id: {
            required: false,
        },


        translations: {
            required: false,
            type: Array,
        }
    },
    data() {
        return {
            branchesValue: {},
            parentsValue: {},
            categoryIdValue: {},
            usersValue: [],
            errors: [],
            step: 1,
            discounts: [],
            edit:{},
            categories:[],
            categoryIds: [],
            categoriesTypes: ['posts', 'products', 'accommodations'],
            status: ['active', 'inActive'],
            broadcasts: [{
                id: 1,
                name: 'yes'
            }, {
                id: 0,
                name: 'no'
            }],
            type: ['percentage', 'amount'],
            users: [],
            newUserToken: "",
            form: {
                type: "",
                categorizable_id: null,
                categorizable_type: null,
                icon: "",
                name: "",
                name_ar: "",
                parent_id: ""
            },
        };
    },
    watch: {

        async "form.categorizable_type"(val) {
            let categoryIds = [];
            switch (val) {
                case 'products':
                    categoryIds = await axios.get("/api/products?per_page=10000000000")
                    break;
                case 'posts':
                    categoryIds = await axios.get("/api/product_variations?per_page=10000000000")
                    break;
                case 'accommodations':
                    categoryIds = await axios.get("/api/accommodations?per_page=10000000000", {
                        headers: {
                            Authorization: "Bearer " + this.auth_token,
                        }
                    })
                    break;

                default:
                    break;
            }
            console.log("🚀 ~ file: Discount.vue ~ line 223 ~ categoryIds.data", categoryIds.data)
            this.categoryIds = categoryIds.data.data
            this.categoryIdValue = {}
            this.form.type = val;

            //   console.log("🚀 ~ file: ReservationProduct.vue ~ line 170 ~ val", val)
            //       const branch = this.branches.find(branch => branch.id == val.id);
            //       console.log("🚀 ~ file: ReservationProduct.vue ~ line 228 ~ this.branches", this.branches)

        },
        "categoryIdValue"(val) {
            this.form.categorizable_id = val.id
        },
        "parentsValue"(val) {
            this.form.parent_id = val.id
        }

    },
    computed: {

        // isCreateCategoryButtonDisabled() {
        //     return this.form.products.length
        // },
        // isNextStepDisabled() {
        //     return this.form.user_id && this.form.branch_id && this.form.address_id
        // },
        // canBeSubmited() {
        //     return this.errors.length === 0;
        // },

    },
   async mounted() {
        // toastr.error('')
     const {data:{data:categories}} =   await axios.get('/api/categories?per_page=10000000', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });

            this.categories = categories;

        if (this.action === 'edit') {
               const {data:{data:edit}} =   await axios.get(`/api/categories/${this.id}?include=parent`, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
            this.edit = edit
            console.log(this.edit)
            this.form.parent_id = this.edit.parent_id
            const parent = this.categories.find(category => category.parent_id === this.edit.parent_id)
            console.log("🚀 ~ file: Category.vue ~ line 219 ~ mounted ~ parent", parent)
            this.parentsValue = parent
            this.form.categorizable_type = this.edit.type;
            this.categoryIdValue = this.typeData[0];

            this.form.name = this.edit.name
            this.form.name_ar = this.translations.filter(obj => {
                return obj.key === 'name'
            })[0].value

        }
    },
    methods: {
        goToStep(step) {
            this.step = step
        },

        selectFile(event) {
            this.form.icon = event.target.files[0];
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
            let data = new FormData();
            for (let key in this.form) {
                console.log("🚀 ~ file: Category.vue ~ line 276 ~ save ~ this.form[key]", this.form[key])
                data.append(key, this.form[key]);

            }
            console.log("🚀 ~ file: Category.vue ~ line 245 ~ save ~ data", data)
            axios.post("/api/categories", data, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location =   `/${this.$dashboardPrefix}/categories`
            }).catch((err) => {
                this.errors = err.response.data.errors;
                if ("user_id" in this.errors || "address_id" in this.errors || "branch_id" in this.errors) {
                    this.step = 1
                }
                // check if err contains the array of validation errors and then set errors property
            });
        },

        editCategory() {
                 let data = new FormData();
            for (let key in this.form) {
                console.log("🚀 ~ file: Category.vue ~ line 276 ~ save ~ this.form[key]", this.form[key])
                data.append(key, this.form[key]);

            }
            console.log("🚀 ~ file: Category.vue ~ line 245 ~ save ~ data", data)
      data.append('_method','put')
            axios.post(`/api/categories/${this.edit.id}`, data, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {
                window.location =  `/${this.$dashboardPrefix}/categories/${this.edit.id }`
            }).catch((err) => {
                this.errors = err.response.data.errors;

            });
        },
    },
};
</script>
