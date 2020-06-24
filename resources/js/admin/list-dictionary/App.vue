<template>
    <div>
        <table class="table" v-if="hasVariables">
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
            <tr v-for="listDictionary in listDictionaries">
                <td><span
                    class="badge badge-primary">{{listDictionary.vocabulary_id}}-{{listDictionary.id}}</span>
                </td>
                <td>
                    {{ listDictionary.name }}
                </td>
                <td>
                    <AutoSaveInput :id="listDictionary.id"
                                   :value="listDictionary.description"
                                   name="description"/>
                </td>
                <td>
                    <AutoSaveInput :id="listDictionary.id"
                                   :value="listDictionary.start_date"
                                   name="start_date"/>
                </td>
                <td>
                    <AutoSaveInput :id="listDictionary.id" :value="listDictionary.end_date"
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
                listDictionaries: []
            }
        },
        created() {
            axios
                .get(apiUrl)
                .then(response => this.listDictionaries = response.data)
        },
        computed: {
            hasVariables() {
                return this.listDictionaries.length > 0
            }
        },
        components: {
            AutoSaveInput
        }
    }
</script>
