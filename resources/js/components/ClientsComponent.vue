<template>
    <div class="clients">
        <h3>Clients</h3>
        <div class="card">
            <div class="card-header">
                Add a new client
            </div>
            <div class="card-body">
                <form class="form-row" @submit.prevent="onSubmit">
                    <div class="form-group col-3">
                        <label>First name</label>
                        <input v-model="createClient.first_name" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="form-group col-3">
                        <label>Second Name</label>
                        <input v-model="createClient.second_name" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="form-group col-3">
                        <label>Phone number</label>
                        <input v-mask="'+7(###)###-##-##'" v-model="createClient.phone_number" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="form-group col-3">
                        <label>Email</label>
                        <input v-model="createClient.email" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="ml-auto text-right">
                        <button type="submit" class="btn btn-primary my-2">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="errorsGetter" class="card mt-5">
            <p v-for="err in errorsGetter" class="w-auto alert alert-danger">{{err}}</p>
        </div>
        <div v-if="clientData.data.length" class="card mt-5">
            <div class="card-header">
                Client list
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                ID
                            </th>
                            <th>
                                First name
                            </th>
                            <th>
                                Second name
                            </th>
                            <th>
                                Phone number
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="client in clientData.data" v-bind:key="client.id">
                            <template v-if="editId == client.id">
                                <td>{{ editId }}</td>
                                <td><input v-model="editClient.first_name"  type="text"></td>
                                <td><input v-model="editClient.second_name" type="text"></td>
                                <td><input v-mask="'+7(###)###-##-##'" v-model="editClient.phone_number" type="text"></td>
                                <td><input v-model="editClient.email" type="text"></td>
                                <td>
                                    <button @click="onEditSubmit(client.id)" class="btn btn-success">
                                        <span class="icon">
                                        <i   class="bi-check"></i>
                                    </span>
                                    </button>
                                    <button @click="onCancel" class="btn btn-dark">
                                        <span class="icon">
                                            <i   class="bi-backspace-reverse"></i>
                                        </span>
                                    </button>
                                </td>
                            </template>
                            <template v-else>
                                <td>
                                    {{client.id}}
                                </td>
                                <td>
                                    {{client.first_name}}
                                </td>
                                <td>
                                    {{client.second_name}}
                                </td>
                                <td>
                                    {{client.phone_number}}
                                </td>
                                <td>
                                    {{client.email}}
                                </td>
                                <td>
                                    <button @click="onDelete(client.id)" class="btn btn-danger icon">
                                        <i class="bi-trash"></i>
                                    </button>
                                    <button @click="onEdit(client)" class="btn btn-warning icon">
                                        <i class="bi-pencil"></i>
                                    </button>
                                    <a :href="`/client/${client.slug}`" class="icon">
                                        <button class="btn btn-primary">
                                            <i class="bi-eye"></i>
                                        </button>
                                    </a>
                                </td>
                            </template>
                        </tr>

                        </tbody>
                    </table>
                    <pagination :data="clientData" @pagination-change-page="paginate"></pagination>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapActions,mapGetters} from "vuex"
    import VueTheMask from 'vue-the-mask'

    export default {
        props:['clients'],
        components:{VueTheMask},
        data () {
            return {
                editId: '',
                clientData: this.clients,
                createClient: {
                    first_name : '',
                    second_name : '',
                    phone_number : '',
                    email : '',
                },
                editClient: {
                    first_name : '',
                    second_name : '',
                    phone_number : '',
                    email : '',
                },
            }
        },
        computed:{
            ...mapGetters(['errorsGetter']),
        },
        methods:{
            ...mapActions(['getErrors','clearErrors']),
            paginate($page) {
                axios.get(`/clients?page=${$page}`).then((response)=>{
                    this.clientData = response.data
                },(xhr)=>{
                    this.getErrors(xhr)
                })
            },
            onSubmit(){
                this.clearErrors()
                axios.post('/client',this.createClient).then(()=>{
                    this.paginate(1)
                    this.createClient.first_name = ''
                    this.createClient.second_name = ''
                    this.createClient.phone_number = ''
                    this.createClient.email = ''
                },(xhr)=>{
                    this.getErrors(xhr)
                })

            },
            onDelete(id){
                this.clearErrors()
                if(confirm("Want to delete?")){
                    axios.delete(`/client/${id}`,).then(()=>{
                        this.paginate(this.clientData.current_page)
                    },(xhr)=>{
                        this.getErrors(xhr)
                    })
                }
            },
            onEdit(client){
                this.editId = client.id
                this.editClient.first_name = client.first_name
                this.editClient.second_name = client.second_name
                this.editClient.phone_number = client.phone_number
                this.editClient.email = client.email
            },
            onEditSubmit (id){
                this.clearErrors()
                axios.put(`/client/${id}`,this.editClient).then(()=>{
                    this.paginate(this.clientData.current_page)
                    this.onCancel()
                },(xhr)=>{
                    this.getErrors(xhr)
                })
            },
            onCancel(){
                this.editId = ''
                this.editClient.first_name = ''
                this.editClient.second_name = ''
                this.editClient.phone_number = ''
                this.editClient.email = ''
            },
        }
    }
</script>

<style scoped>
h3{
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}
.icon{
    margin-right: 10px;
}
</style>