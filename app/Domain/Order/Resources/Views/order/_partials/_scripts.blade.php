<script>
    
    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name: '{{ getData($data, 'name') }}',
                /**/
                @if ($action == 'edit')
                    _method: 'PATCH',
                @endif
            },
            isLoading: false,
            validation_errors: [],
        },
        mounted () {

        },
        methods: {
            submit (option = 'create') {

                let request = {

                    method: "post",
                    
                    url:'{{ $submitUrl }}',
                    
                    data:this.fData,

                    toaster:{
                        success:{
                            title:"User Saved",
                            subtitle:"User",
                            body:"User has been inserted successfully in the system"
                        },
                        fail:{
                            title:"Process Failer",
                            subtitle:"Fail",
                            body:"User has not been inserted successfully in the system"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ route("orders.create") }}'
                }else{
                    request.redirect = '{{ route("orders.show", ":id") }}'
                }

                this.isLoading = true

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false
                    },(err)=>{
                        this.isLoading = false
                    });
                
            },
        },
    });
</script>
