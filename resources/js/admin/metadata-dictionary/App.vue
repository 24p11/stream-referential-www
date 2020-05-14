<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Variable</th>
            <th scope="col">Déscription</th>
            <th scope="col">Type</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="metadataDictionary in metadataDictionaries">
            <td><span class="badge badge-primary">{{metadataDictionary.vocabulary_id}}-{{metadataDictionary.id}}</span>
            </td>
            <td>
                {{ metadataDictionary.metadata_name }}
            </td>
            <td>
                <AutoSaveInput :metadata-dictionary-id="metadataDictionary.id" :value="metadataDictionary.description"
                               name="description"/>
            </td>
            <td>
                <AutoSaveInput :metadata-dictionary-id="metadataDictionary.id" :value="metadataDictionary.type"
                               name="type"/>
            </td>
            <td>
                <AutoSaveInput :metadata-dictionary-id="metadataDictionary.id" :value="metadataDictionary.start_date"
                               name="start_date"/>
            </td>
            <td>
                <AutoSaveInput :metadata-dictionary-id="metadataDictionary.id" :value="metadataDictionary.end_date"
                               name="end_date"/>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import AutoSaveInput from './AutoSaveInput'

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
        },
        components: {
            AutoSaveInput
        }
    }
</script>
