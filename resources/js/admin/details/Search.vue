<template>
    <div>
        <div class="form-group">
            <input
                :placeholder="placeholder"
                :value='searchTerm'
                @input='onInput'
                autofocus
                class="form-control"
                required="required"
                type="search">
        </div>

        <div class="infos">
            <span class="badge badge-light" v-show="conceptsCount > -1">[{{conceptsCount}}]</span>
            <span class="badge badge-light" span v-show="performSearch">Recherche en cours...</span>
            <span class="badge badge-warning" v-show="noResult">Pas de résultats</span>
        </div>

        <Result :concepts="concepts"/>
    </div>
</template>

<script>
    import Result from './Result'
    import debounce from 'lodash.debounce';

    const axios = require('axios');
    export default {
        data: () => {
            return {
                conceptsCount: -1,
                placeholder: `Rechercher dans ${referential}`,
                searchTerm: '',
                performSearch: false,
                concepts: [],
            }
        },
        created() {
            this.searchAction = debounce(this.query, 700)
        },
        methods: {
            search() {
                if (this.searchTerm) {
                    this.performSearch = true
                    this.searchAction()
                }
            },
            query() {
                let queryParameters = {
                    params: {
                        search: this.searchTerm
                    }
                }
                axios
                    .get(referentialApiUrl, queryParameters)
                    .then(this.response)
                    .then(() => this.performSearch = false);
            },
            response(response) {
                this.concepts = response.data;
                this.conceptsCount = this.concepts.length
            },
            onInput(event) {
                this.searchTerm = event.target.value;
                this.search()
            },
        },
        computed: {
            noResult: function () {
                return !this.performSearch && this.searchTerm && !this.concepts.length
            }
        },
        components: {
            Result
        }
    };
</script>

<style>
    div.infos {
        margin: 2px 0 5px 0;
        min-height: 24px;
    }

    .form-group {
        margin-bottom: .0rem;
    }
</style>
