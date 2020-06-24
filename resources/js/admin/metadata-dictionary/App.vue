<template>
    <div>
        <table class="table" v-if="hasVariables">
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
                <td><span
                    class="badge badge-primary">{{metadataDictionary.vocabulary_id}}-{{metadataDictionary.id}}</span>
                </td>
                <td>
                    {{ metadataDictionary.metadata_name }}
                </td>
                <td>
                    <AutoSaveInput :id="metadataDictionary.id"
                                   :value="metadataDictionary.description"
                                   name="description"/>
                </td>
                <td>
                    <AutoSaveInput :id="metadataDictionary.id" :value="metadataDictionary.type"
                                   name="type"/>
                </td>
                <td>
                    <AutoSaveInput :id="metadataDictionary.id"
                                   :value="metadataDictionary.start_date"
                                   name="start_date"/>
                </td>
                <td>
                    <AutoSaveInput :id="metadataDictionary.id" :value="metadataDictionary.end_date"
                                   name="end_date"/>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="alert alert-primary" role="alert" v-else>
            Aucune variables pour le référentiel {{referential}}.
        </div>
    </div>
</template>

<script>
    import AutoSaveInput from '../AutoSaveInput'

    const axios = require('axios');
    export default {
        data() {
            return {
                referential: referential,
                metadataDictionaries: []
            }
        },
        created() {
            axios
                .get(apiUrl)
                .then(response => this.metadataDictionaries = response.data)
        },
        computed: {
            hasVariables() {
                return this.metadataDictionaries.length > 0
            }
        },
        components: {
            AutoSaveInput
        }
    }
</script>
