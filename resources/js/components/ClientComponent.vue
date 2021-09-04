<template>
    <div class="client">
        <h3>Client</h3>
        <div class="card mt-5">
            <div class="card-header">
                Client
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
                                Slug
                            </th>
                            <th>
                                Phone number
                            </th>
                            <th>
                                Email
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
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
                                    {{client.slug}}
                                </td>
                                <td>
                                    {{client.phone_number}}
                                </td>
                                <td>
                                    {{client.email}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-if="client.parkings_history.length" class="card mt-5">
            <div class="card-header">
                Pick Up list
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
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
                        <tr v-for="(pickUp,index) in client.parkings_history" :key="index">
                            <td>
                                <a :href="`/parking/${pickUp.id}`">{{pickUp.number}}</a>
                            </td>
                            <td>
                                {{pickUp.pivot.car_type}}
                            </td>
                            <td>
                                {{pickUp.price}} $
                            </td>
                            <td>
                                {{pickUp.pivot.start_parking}}
                            </td>
                            <td>
                                {{pickUp.pivot.end_parking}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['client'],
    mounted() {
        console.log(this.client)
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