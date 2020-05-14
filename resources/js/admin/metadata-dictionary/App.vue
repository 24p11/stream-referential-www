<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Variable</th>
            <th scope="col">Déscription</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="metadataDictionary in metadataDictionaries">
            <td>
                #
            </td>
            <td>
                <div class="form-group">
                    <input :value="metadataDictionary.metadata_name" class="form-control" type="text">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input :value="metadataDictionary.description" class="form-control" type="text">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input :value="metadataDictionary.start_date" class="form-control" type="text">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input :value="metadataDictionary.endate" class="form-control" type="text">
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    const axios = require('axios');
    export default {
        data() {
            return {
                metadataDictionaries: []
            }
        },
        created() {
            axios
                .get(apiUrl)
                .then(response => this.metadataDictionaries = response.data)
        }
    }
</script>
