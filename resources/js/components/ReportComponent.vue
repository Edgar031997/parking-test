<template>
    <div class="pickUp">
        <h3>Pick Up</h3>
        <div class="card">
            <div class="card-header">
                Pick Up report
            </div>
            <div class="card-body">
                <form class="form" @submit.prevent="report(1)">
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Start</label>
                            <date-picker v-model="data.start" valueType="format" type="datetime"></date-picker>
                        </div>
                        <div class="form-group col-3">
                            <label>End</label>
                            <br/>
                            <date-picker v-model="data.end" valueType="format" type="datetime"></date-picker>
                        </div>
                        <div class="ml-auto text-right m-4">
                            <button type="submit" class="btn btn-primary my-2">Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="errorsGetter" class="card mt-5">
            <p v-for="err in errorsGetter" class="w-auto alert alert-danger">{{err}}</p>
        </div>
        <div v-if="allResponse.data" class="card mt-5">
            <div class="card-header">
                Pick Up list
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
                                Client
                            </th>
                            <th>
                                Parking
                            </th>
                            <th>
                                Car type
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Start
                            </th>
                            <th>
                                End
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="pickUp in allResponse.data" :key="`pickUp${pickUp.id}`">
                            <td>
                                {{pickUp.id}}
                            </td>
                            <td>
                                <a :href="`/client/${pickUp.client.slug}`">{{pickUp.client.first_name}} {{pickUp.client.second_name}}</a>
                            </td>
                            <td>
                                <a :href="`/parking/${pickUp.parking.id}`">{{pickUp.parking.number}}</a>
                            </td>
                            <td>
                                {{pickUp.car_type}}
                            </td>
                            <td>
                                {{pickUp.parking.price}} $
                            </td>
                            <td>
                                {{pickUp.start_parking}}
                            </td>
                            <td>
                                {{pickUp.end_parking}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <pagination :data="allResponse" @pagination-change-page="report"></pagination>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import DatePicker from "vue2-datepicker";

    export default {
        components:{DatePicker},
        data(){
            return{
                data:{
                    start : '',
                    end : ''
                },
                allResponse : [],
            }
        },
        computed:{
            ...mapGetters(['errorsGetter']),
        },
        methods:{
            ...mapActions(['getErrors','clearErrors']),
            report(page){
                this.clearErrors();

                axios.get(`/report/search`,{
                    params: {
                        page,
                        start:this.data.start,
                        end:this.data.end,
                    }
                }).then((response)=>{
                    this.allResponse = response.data
                },(xhr)=>{
                    this.getErrors(xhr)
                })
            }
        }
    }
</script>